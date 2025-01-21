-- Запросы с оптимизацией

-- Добавление индекса на дату в сеансы
CREATE INDEX sessions_date_current_date_idx ON sessions (date)
    WHERE date = '2025-01-20';
CREATE INDEX sessions_date_current_week_idx ON sessions (date)
    WHERE date BETWEEN '2025-01-14' AND '2025-01-20';

-- 1. Доступные фильмы на сегодня (с учетом даты сеанса и текущего времени)
explain analyze
select f.id   as film_id,
       f.name as film_name
from sessions s
         join films f on f.id = s.film_id
         join times t on s.time_id = t.id
where s.date = '2025-01-20'
  AND time >= current_time
group by f.id;

-- 10000000
-- Group  (cost=199723.05..211085.37 rows=113222 width=35) (actual time=622.475..662.159 rows=56230 loops=1)
--   Group Key: f.id
--   ->  Gather Merge  (cost=199723.05..210849.49 rows=94352 width=35) (actual time=622.471..653.247 rows=56323 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Group  (cost=198723.02..198958.90 rows=47176 width=35) (actual time=599.112..605.055 rows=18774 loops=3)
--               Group Key: f.id
--               ->  Sort  (cost=198723.02..198840.96 rows=47176 width=35) (actual time=599.078..601.786 rows=18793 loops=3)
--                     Sort Key: f.id
--                     Sort Method: quicksort  Memory: 1845kB
--                     Worker 0:  Sort Method: quicksort  Memory: 1773kB
--                     Worker 1:  Sort Method: quicksort  Memory: 1770kB
--                     ->  Nested Loop  (cost=2995.55..195060.81 rows=47176 width=35) (actual time=40.256..590.821 rows=18793 loops=3)
--                           ->  Hash Join  (cost=2995.11..106558.63 rows=47176 width=4) (actual time=40.179..362.293 rows=18793 loops=3)
--                                 Hash Cond: (s.time_id = t.id)
--                                 ->  Parallel Bitmap Heap Scan on sessions s  (cost=2940.91..106132.15 rows=141528 width=8) (actual time=24.385..330.023 rows=113038 loops=3)
--                                       Recheck Cond: (date = '2025-01-20'::date)
--                                       Rows Removed by Index Recheck: 1445996
--                                       Heap Blocks: exact=13964 lossy=11655
--                                       ->  Bitmap Index Scan on sessions_date_current_date_idx  (cost=0.00..2856.00 rows=339667 width=0) (actual time=35.879..35.879 rows=339115 loops=1)
--                                 ->  Hash  (cost=45.70..45.70 rows=680 width=4) (actual time=15.718..15.719 rows=1 loops=3)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                       ->  Seq Scan on times t  (cost=0.00..45.70 rows=680 width=4) (actual time=15.704..15.705 rows=1 loops=3)
-- "                                            Filter: ((""time"")::time with time zone >= CURRENT_TIME)"
--                                             Rows Removed by Filter: 5
--                           ->  Index Scan using films_pkey on films f  (cost=0.43..1.88 rows=1 width=35) (actual time=0.012..0.012 rows=1 loops=56379)
--                                 Index Cond: (id = s.film_id)
-- Planning Time: 0.622 ms
-- JIT:
--   Functions: 68
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 3.489 ms (Deform 1.477 ms), Inlining 0.000 ms, Optimization 1.985 ms, Emission 45.182 ms, Total 50.656 ms"
-- Execution Time: 666.423 ms


-- Дублирование даты из сеанса в таблицу с билетами, индекс на дату
alter table tickets
    add column date date null;

UPDATE tickets
SET date = (SELECT sessions.date FROM sessions WHERE id = tickets.session_id)
where id > 0;

CREATE INDEX tickets_date_current_week_idx ON tickets (date)
    WHERE date BETWEEN '2025-01-14' AND '2025-01-20';

-- 2. Подсчёт проданных билетов за неделю - берем дату из билетов
explain analyze
select sum(t.session_price * t.seat_price_coefficient) as sales_by_week
from tickets t
where t.date BETWEEN '2025-01-14' AND '2025-01-20';

-- 10000000
-- Aggregate  (cost=103264.90..103264.91 rows=1 width=32) (actual time=1199.981..1199.984 rows=1 loops=1)
--   ->  Bitmap Heap Scan on tickets t  (cost=434.93..103014.89 rows=50000 width=10) (actual time=133.547..948.902 rows=2379138 loops=1)
--         Recheck Cond: ((date >= '2025-01-14'::date) AND (date <= '2025-01-20'::date))
--         Rows Removed by Index Recheck: 3422859
--         Heap Blocks: exact=40498 lossy=33032
--         ->  Bitmap Index Scan on tickets_date_current_week_idx  (cost=0.00..422.43 rows=50000 width=0) (actual time=117.049..117.050 rows=2379138 loops=1)
-- Planning Time: 0.386 ms
-- JIT:
--   Functions: 5
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 0.745 ms (Deform 0.326 ms), Inlining 0.000 ms, Optimization 1.496 ms, Emission 5.410 ms, Total 7.652 ms"
-- Execution Time: 1200.851 ms



--  3. Формирование афиши (фильмы, которые показывают сегодня, без учета текущего времени)
explain analyze
select f.id   as film_id,
       f.name as film_name
from sessions s
         join films f on f.id = s.film_id
where s.date = '2025-01-20'
group by f.id;

-- 4. Поиск 3 самых прибыльных фильмов за неделю
explain analyze
select sum(price)  as sales_by_film,
       count(t.id) as count_tickets,
       f.id        as film_id,
       f.name      as film_name
from tickets t
         join sessions s on t.session_id = s.id
         join films f on f.id = s.film_id
where s.date BETWEEN '2025-01-14' AND '2025-01-20'
group by f.id
order by sales_by_film desc
    limit 3;

-- Limit  (cost=1120442.74..1120442.74 rows=3 width=75) (actual time=4714.346..5012.398 rows=3 loops=1)
--   ->  Sort  (cost=1120442.74..1126357.51 rows=2365909 width=75) (actual time=4463.006..4761.057 rows=3 loops=1)
--         Sort Key: (sum(s.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=790823.25..1089863.81 rows=2365909 width=75) (actual time=3563.009..4640.929 rows=1396595 loops=1)
--               Group Key: f.id
--               ->  Gather Merge  (cost=790823.25..1040574.04 rows=1971590 width=75) (actual time=3562.991..4204.365 rows=1396595 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=789823.23..812003.61 rows=985795 width=75) (actual time=3534.559..3772.768 rows=465532 loops=3)
--                           Group Key: f.id
--                           ->  Sort  (cost=789823.23..792287.71 rows=985795 width=44) (actual time=3534.516..3591.801 rows=793046 loops=3)
--                                 Sort Key: f.id
--                                 Sort Method: external merge  Disk: 44464kB
--                                 Worker 0:  Sort Method: external merge  Disk: 43936kB
--                                 Worker 1:  Sort Method: external merge  Disk: 44360kB
--                                 ->  Parallel Hash Join  (cost=406250.58..631027.76 rows=985795 width=44) (actual time=2907.214..3362.118 rows=793046 loops=3)
--                                       Hash Cond: (f.id = s.film_id)
--                                       ->  Parallel Seq Scan on films f  (cost=0.00..135124.69 rows=4166669 width=35) (actual time=0.053..212.700 rows=3333333 loops=3)
--                                       ->  Parallel Hash  (cost=389114.14..389114.14 rows=985795 width=13) (actual time=2318.179..2318.189 rows=793046 loops=3)
--                                             Buckets: 262144  Batches: 32  Memory Usage: 5600kB
--                                             ->  Parallel Hash Join  (cost=152604.70..389114.14 rows=985795 width=13) (actual time=1765.295..2227.521 rows=793046 loops=3)
--                                                   Hash Cond: (t.session_id = s.id)
--                                                   ->  Parallel Seq Scan on tickets t  (cost=0.00..188455.78 rows=4139678 width=8) (actual time=47.714..339.670 rows=3333333 loops=3)
--                                                   ->  Parallel Hash  (cost=135356.93..135356.93 rows=992222 width=13) (actual time=896.163..896.165 rows=792741 loops=3)
--                                                         Buckets: 262144  Batches: 32  Memory Usage: 5568kB
--                                                         ->  Parallel Bitmap Heap Scan on sessions s  (cost=20546.88..135356.93 rows=992222 width=13) (actual time=267.677..716.791 rows=792741 loops=3)
--                                                               Recheck Cond: ((date >= '2025-01-14'::date) AND (date <= '2025-01-20'::date))
--                                                               Rows Removed by Index Recheck: 1140815
--                                                               Heap Blocks: exact=18115 lossy=15530
--                                                               ->  Bitmap Index Scan on sessions_date_current_week_idx  (cost=0.00..19951.54 rows=2381333 width=0) (actual time=108.714..108.714 rows=2378223 loops=1)
-- Planning Time: 1.496 ms
-- JIT:
--   Functions: 79
-- "  Options: Inlining true, Optimization true, Expressions true, Deforming true"
-- "  Timing: Generation 4.928 ms (Deform 1.959 ms), Inlining 196.394 ms, Optimization 330.572 ms, Emission 248.149 ms, Total 780.043 ms"
-- Execution Time: 5025.132 ms

