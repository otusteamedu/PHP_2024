-- Запросы с оптимизацией
-- Запросы без explain analyze выполняются быстрее, так что time указано при обычном выполнении

-- 1. Доступные фильмы на сегодня (с учетом даты сеанса и текущего времени)
-- Изменила запрос на where in
-- time 902 ms
EXPLAIN analyze
select f.id   as film_id,
       f.name as film_name
from films f
where id in (select film_id
             from sessions s
                      join times t on s.time_id = t.id
             where s.date = CURRENT_DATE
               and t.time > current_time);

-- 10000000
-- Gather  (cost=138103.77..296722.22 rows=120000 width=35) (actual time=418.575..1743.883 rows=334356 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Hash Semi Join  (cost=137103.77..283722.22 rows=50000 width=35) (actual time=381.487..1691.413 rows=111452 loops=3)
--         Hash Cond: (f.id = s.film_id)
--         ->  Parallel Seq Scan on films f  (cost=0.00..135124.69 rows=4166669 width=35) (actual time=0.712..297.182 rows=3333333 loops=3)
--         ->  Parallel Hash  (cost=136478.77..136478.77 rows=50000 width=4) (actual time=379.512..379.515 rows=113386 loops=3)
--               Buckets: 524288 (originally 131072)  Batches: 1 (originally 1)  Memory Usage: 20512kB
--               ->  Hash Join  (cost=54.20..136478.77 rows=50000 width=4) (actual time=18.127..323.067 rows=113386 loops=3)
--                     Hash Cond: (s.time_id = t.id)
--                     ->  Parallel Seq Scan on sessions s  (cost=0.00..136030.00 rows=150000 width=8) (actual time=18.004..303.579 rows=113386 loops=3)
--                           Filter: (date = CURRENT_DATE)
--                           Rows Removed by Filter: 3219947
--                     ->  Hash  (cost=45.70..45.70 rows=680 width=4) (actual time=0.088..0.089 rows=6 loops=3)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Seq Scan on times t  (cost=0.00..45.70 rows=680 width=4) (actual time=0.077..0.079 rows=6 loops=3)
-- "                                Filter: ((""time"")::time with time zone > CURRENT_TIME)"
-- Planning Time: 0.484 ms
-- JIT:
--   Functions: 66
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 5.132 ms (Deform 2.206 ms), Inlining 0.000 ms, Optimization 2.294 ms, Emission 51.725 ms, Total 59.151 ms"
-- Execution Time: 1759.911 ms


-- Индекс на дату в сеансы (запрос по времени не ускорился, только хуже стал)
-- time 1 s 265 ms
-- CREATE INDEX sessions_date_idx ON sessions (date);

-- Gather  (cost=115264.32..273882.77 rows=120000 width=35) (actual time=561.884..1941.109 rows=334356 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Hash Semi Join  (cost=114264.32..260882.77 rows=50000 width=35) (actual time=525.075..1888.160 rows=111452 loops=3)
--         Hash Cond: (f.id = s.film_id)
--         ->  Parallel Seq Scan on films f  (cost=0.00..135124.69 rows=4166669 width=35) (actual time=0.048..268.965 rows=3333333 loops=3)
--         ->  Parallel Hash  (cost=113639.32..113639.32 rows=50000 width=4) (actual time=523.553..523.555 rows=113386 loops=3)
--               Buckets: 524288 (originally 131072)  Batches: 1 (originally 1)  Memory Usage: 20544kB
--               ->  Hash Join  (cost=4064.64..113639.32 rows=50000 width=4) (actual time=54.542..461.921 rows=113386 loops=3)
--                     Hash Cond: (s.time_id = t.id)
--                     ->  Parallel Bitmap Heap Scan on sessions s  (cost=4010.44..113190.55 rows=150000 width=8) (actual time=34.762..418.336 rows=113386 loops=3)
--                           Recheck Cond: (date = CURRENT_DATE)
--                           Rows Removed by Index Recheck: 1445747
--                           Heap Blocks: exact=14267 lossy=11845
--                           ->  Bitmap Index Scan on sessions_date_idx  (cost=0.00..3920.44 rows=360000 width=0) (actual time=57.678..57.679 rows=340159 loops=1)
--                                 Index Cond: (date = CURRENT_DATE)
--                     ->  Hash  (cost=45.70..45.70 rows=680 width=4) (actual time=19.729..19.729 rows=6 loops=3)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Seq Scan on times t  (cost=0.00..45.70 rows=680 width=4) (actual time=19.704..19.712 rows=6 loops=3)
-- "                                Filter: ((""time"")::time with time zone > CURRENT_TIME)"
-- Planning Time: 0.556 ms
-- JIT:
--   Functions: 69
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 5.347 ms (Deform 2.295 ms), Inlining 0.000 ms, Optimization 2.536 ms, Emission 56.590 ms, Total 64.473 ms"
-- Execution Time: 1955.828 ms





-- 2. Подсчёт проданных билетов за неделю - берем дату из билетов

-- Дублирование даты из сеанса в таблицу с билетами, чтоб зафиксировать дату в билете
alter table tickets
    add column date date null;

UPDATE tickets
SET date = (SELECT sessions.date FROM sessions WHERE id = tickets.session_id)
where id > 0;

-- time 1 s 766 ms
explain analyze
select count(t.id) as count_tickets
from tickets t
WHERE date BETWEEN (CURRENT_DATE - INTERVAL '6 days')
  AND CURRENT_DATE;

-- 10000000
-- Finalize Aggregate  (cost=244319.29..244319.30 rows=1 width=8) (actual time=793.846..802.473 rows=1 loops=1)
--   ->  Gather  (cost=244319.07..244319.28 rows=2 width=8) (actual time=793.519..802.410 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=243319.07..243319.08 rows=1 width=8) (actual time=756.794..756.796 rows=1 loops=3)
--               ->  Parallel Seq Scan on tickets t  (cost=0.00..240809.00 rows=1004028 width=4) (actual time=88.807..714.784 rows=793177 loops=3)
--                     Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
--                     Rows Removed by Filter: 2540157
-- Planning Time: 0.283 ms
-- JIT:
--   Functions: 17
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.524 ms (Deform 0.845 ms), Inlining 0.000 ms, Optimization 3.188 ms, Emission 17.268 ms, Total 22.981 ms"
-- Execution Time: 803.784 ms


-- индекс не работает (не числится в explain analyze)
-- CREATE INDEX tickets_date_idx ON tickets (date);



--  3. Формирование афиши (фильмы, которые показывают сегодня, без учета текущего времени)

-- Изменила запрос
-- time 957 ms

explain analyze
select f.id, f.name
from films f
where f.id in (select film_id from sessions s where s.date = CURRENT_DATE) order by f.name;

-- Gather  (cost=138905.00..322635.95 rows=360000 width=35) (actual time=391.449..1806.943 rows=334356 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Hash Semi Join  (cost=137905.00..285635.95 rows=150000 width=35) (actual time=360.059..1755.244 rows=111452 loops=3)
--         Hash Cond: (f.id = s.film_id)
--         ->  Parallel Seq Scan on films f  (cost=0.00..135124.69 rows=4166669 width=35) (actual time=0.466..304.482 rows=3333333 loops=3)
--         ->  Parallel Hash  (cost=136030.00..136030.00 rows=150000 width=4) (actual time=356.766..356.768 rows=113386 loops=3)
--               Buckets: 524288  Batches: 1  Memory Usage: 17472kB
--               ->  Parallel Seq Scan on sessions s  (cost=0.00..136030.00 rows=150000 width=4) (actual time=13.153..300.707 rows=113386 loops=3)
--                     Filter: (date = CURRENT_DATE)
--                     Rows Removed by Filter: 3219947
-- Planning Time: 0.280 ms
-- JIT:
--   Functions: 36
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.364 ms (Deform 1.082 ms), Inlining 0.000 ms, Optimization 2.153 ms, Emission 37.159 ms, Total 41.676 ms"
-- Execution Time: 1823.082 ms


--     VIEW

-- Еще как вариант
-- Можно создать материализованное представление, которое кэширует запрос

CREATE MATERIALIZED VIEW materialized_view AS
select f.id   as film_id,
       f.name as film_name
from sessions s
         join films f on f.id = s.film_id
         join times t on s.time_id = t.id
where s.date = CURRENT_DATE
  AND time >= current_time
group by f.id;

explain analyze
select *
from materialized_view;

-- Seq Scan on materialized_view  (cost=0.00..11.40 rows=140 width=520) (actual time=0.007..0.009 rows=0 loops=1)
-- Planning Time: 0.170 ms
-- Execution Time: 0.024 ms


--     CONF

-- Меняла, вообще не влияют ни на что..
-- SHOW work_mem;
-- ALTER SYSTEM SET work_mem TO '10MB'; -- 4MB
-- ALTER SYSTEM SET work_mem TO '4MB'; -- 4MB

-- SHOW shared_buffers;
-- ALTER SYSTEM SET shared_buffers TO '256MB'; -- 128MB
-- ALTER SYSTEM SET shared_buffers TO '128MB'; -- 128MB

-- SELECT pg_reload_conf();
