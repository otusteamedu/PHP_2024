-- Запросы без оптимизации


-- 1. Доступные фильмы на сегодня (с учетом даты сеанса и текущего времени)
-- time 3s
explain analyze
select f.id   as film_id,
       f.name as film_name
from sessions s
         join films f on f.id = s.film_id
         join times t on s.time_id = t.id
where s.date = CURRENT_DATE
  AND time > current_time
group by f.id;

-- 10000000
-- Group  (cost=231161.21..243203.69 rows=120000 width=35) (actual time=2183.947..2264.354 rows=334356 loops=1)
--   Group Key: f.id
--   ->  Gather Merge  (cost=231161.21..242953.69 rows=100000 width=35) (actual time=2183.942..2240.798 rows=338184 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Group  (cost=230161.18..230411.18 rows=50000 width=35) (actual time=2141.529..2159.121 rows=112728 loops=3)
--               Group Key: f.id
--               ->  Sort  (cost=230161.18..230286.18 rows=50000 width=35) (actual time=2141.485..2150.219 rows=113386 loops=3)
--                     Sort Key: f.id
--                     Sort Method: external merge  Disk: 5112kB
--                     Worker 0:  Sort Method: external merge  Disk: 4952kB
--                     Worker 1:  Sort Method: external merge  Disk: 4944kB
--                     ->  Nested Loop  (cost=54.64..226258.77 rows=50000 width=35) (actual time=16.026..2067.038 rows=113386 loops=3)
--                           ->  Hash Join  (cost=54.20..136478.77 rows=50000 width=4) (actual time=15.937..390.776 rows=113386 loops=3)
--                                 Hash Cond: (s.time_id = t.id)
--                                 ->  Parallel Seq Scan on sessions s  (cost=0.00..136030.00 rows=150000 width=8) (actual time=15.768..363.666 rows=113386 loops=3)
--                                       Filter: (date = CURRENT_DATE)
--                                       Rows Removed by Filter: 3219947
--                                 ->  Hash  (cost=45.70..45.70 rows=680 width=4) (actual time=0.075..0.077 rows=6 loops=3)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                       ->  Seq Scan on times t  (cost=0.00..45.70 rows=680 width=4) (actual time=0.065..0.067 rows=6 loops=3)
-- "                                            Filter: ((""time"")::time with time zone > CURRENT_TIME)"
--                           ->  Index Scan using films_pkey on films f  (cost=0.43..1.80 rows=1 width=35) (actual time=0.014..0.014 rows=1 loops=340159)
--                                 Index Cond: (id = s.film_id)
-- Planning Time: 0.848 ms
-- JIT:
--   Functions: 68
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 5.679 ms (Deform 2.151 ms), Inlining 0.000 ms, Optimization 1.833 ms, Emission 45.487 ms, Total 52.999 ms"
-- Execution Time: 2275.302 ms





-- 2. Подсчёт проданных билетов за неделю
-- time 4s
explain analyze
select count(t.id) as count_tickets
from tickets t
         join sessions s on t.session_id = s.id
where s.date BETWEEN (CURRENT_DATE - INTERVAL '6 days')
          AND CURRENT_DATE;

-- 10000000
-- Finalize Aggregate  (cost=423307.30..423307.31 rows=1 width=8) (actual time=2112.788..2184.392 rows=1 loops=1)
--   ->  Gather  (cost=423307.08..423307.29 rows=2 width=8) (actual time=2112.167..2184.377 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=422307.08..422307.09 rows=1 width=8) (actual time=2079.184..2079.191 rows=1 loops=3)
--               ->  Parallel Hash Join  (cost=183684.26..419807.43 rows=999861 width=4) (actual time=1520.589..2054.773 rows=793177 loops=3)
--                     Hash Cond: (t.session_id = s.id)
--                     ->  Parallel Seq Scan on tickets t  (cost=0.00..188725.67 rows=4166667 width=8) (actual time=71.687..333.797 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=167280.00..167280.00 rows=999861 width=4) (actual time=777.301..777.303 rows=792889 loops=3)
--                           Buckets: 262144  Batches: 16  Memory Usage: 7904kB
--                           ->  Parallel Seq Scan on sessions s  (cost=0.00..167280.00 rows=999861 width=4) (actual time=12.885..635.055 rows=792889 loops=3)
--                                 Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
--                                 Rows Removed by Filter: 2540444
-- Planning Time: 0.438 ms
-- JIT:
--   Functions: 41
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 5.111 ms (Deform 1.038 ms), Inlining 0.000 ms, Optimization 1.672 ms, Emission 36.871 ms, Total 43.655 ms"
-- Execution Time: 2187.062 ms






--  3. Формирование афиши (фильмы, которые показывают сегодня, без учета текущего времени)
-- time 3s
explain analyze
select distinct f.id as film_id, f.name
from sessions s
         join films f on f.id = s.film_id
where s.date = CURRENT_DATE;

-- 10000000
-- Unique  (cost=307277.68..344530.12 rows=300000 width=35) (actual time=2017.120..2082.349 rows=334356 loops=1)
--   ->  Gather Merge  (cost=307277.68..343030.12 rows=300000 width=35) (actual time=2017.118..2058.006 rows=334356 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Unique  (cost=306277.65..307402.65 rows=150000 width=35) (actual time=1983.093..1997.318 rows=111452 loops=3)
--               ->  Sort  (cost=306277.65..306652.65 rows=150000 width=35) (actual time=1983.092..1988.723 rows=113386 loops=3)
-- "                    Sort Key: f.id, f.name"
--                     Sort Method: external merge  Disk: 5024kB
--                     Worker 0:  Sort Method: external merge  Disk: 4960kB
--                     Worker 1:  Sort Method: external merge  Disk: 5024kB
--                     ->  Parallel Hash Join  (cost=137905.00..289279.70 rows=150000 width=35) (actual time=364.805..1950.734 rows=113386 loops=3)
--                           Hash Cond: (f.id = s.film_id)
--                           ->  Parallel Seq Scan on films f  (cost=0.00..135124.69 rows=4166669 width=35) (actual time=0.688..312.861 rows=3333333 loops=3)
--                           ->  Parallel Hash  (cost=136030.00..136030.00 rows=150000 width=4) (actual time=361.024..361.024 rows=113386 loops=3)
--                                 Buckets: 524288  Batches: 1  Memory Usage: 17440kB
--                                 ->  Parallel Seq Scan on sessions s  (cost=0.00..136030.00 rows=150000 width=4) (actual time=13.286..303.282 rows=113386 loops=3)
--                                       Filter: (date = CURRENT_DATE)
--                                       Rows Removed by Filter: 3219947
-- Planning Time: 0.298 ms
-- JIT:
--   Functions: 40
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 3.590 ms (Deform 1.229 ms), Inlining 0.000 ms, Optimization 2.473 ms, Emission 37.230 ms, Total 43.294 ms"
-- Execution Time: 2091.882 ms






-- 4. Поиск 3 самых прибыльных фильмов за неделю
-- time 8s
explain analyze
select sum(t.session_price * t.seat_price_coefficient) as sales_by_film,
       count(t.id)                                     as count_tickets,
       f.id                                            as film_id,
       f.name                                          as film_name
from tickets t
         join sessions s on t.session_id = s.id
         join films f on f.id = s.film_id
where s.date BETWEEN (CURRENT_DATE - INTERVAL '6 days') AND CURRENT_DATE
group by f.id
order by sales_by_film desc
    limit 3;

-- 10000000
-- Limit  (cost=1186141.86..1186141.87 rows=3 width=75) (actual time=5032.623..5377.437 rows=3 loops=1)
--   ->  Sort  (cost=1186141.86..1192141.03 rows=2399667 width=75) (actual time=4731.947..5076.760 rows=3 loops=1)
--         Sort Key: (sum((t.session_price * t.seat_price_coefficient))) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=849319.49..1155126.61 rows=2399667 width=75) (actual time=3821.820..4961.537 rows=1397063 loops=1)
--               Group Key: f.id
--               ->  Gather Merge  (cost=849319.49..1105133.56 rows=1999722 width=75) (actual time=3821.769..4530.170 rows=1397063 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=848319.47..873316.00 rows=999861 width=75) (actual time=3791.281..4059.810 rows=465688 loops=3)
--                           Group Key: f.id
--                           ->  Sort  (cost=848319.47..850819.12 rows=999861 width=49) (actual time=3791.229..3843.680 rows=793177 loops=3)
--                                 Sort Key: f.id
--                                 Sort Method: external merge  Disk: 45224kB
--                                 Worker 0:  Sort Method: external merge  Disk: 49888kB
--                                 Worker 1:  Sort Method: external merge  Disk: 47168kB
--                                 ->  Parallel Hash Join  (cost=454440.69..680321.48 rows=999861 width=49) (actual time=3051.536..3606.538 rows=793177 loops=3)
--                                       Hash Cond: (f.id = s.film_id)
--                                       ->  Parallel Seq Scan on films f  (cost=0.00..135124.69 rows=4166669 width=35) (actual time=0.054..173.926 rows=3333333 loops=3)
--                                       ->  Parallel Hash  (cost=436083.43..436083.43 rows=999861 width=18) (actual time=2524.215..2524.291 rows=793177 loops=3)
--                                             Buckets: 131072  Batches: 32  Memory Usage: 5152kB
--                                             ->  Parallel Hash Join  (cost=183684.26..436083.43 rows=999861 width=18) (actual time=1844.483..2432.224 rows=793177 loops=3)
--                                                   Hash Cond: (t.session_id = s.id)
--                                                   ->  Parallel Seq Scan on tickets t  (cost=0.00..188725.67 rows=4166667 width=18) (actual time=71.599..359.419 rows=3333333 loops=3)
--                                                   ->  Parallel Hash  (cost=167280.00..167280.00 rows=999861 width=8) (actual time=962.364..962.366 rows=792889 loops=3)
--                                                         Buckets: 262144  Batches: 16  Memory Usage: 7904kB
--                                                         ->  Parallel Seq Scan on sessions s  (cost=0.00..167280.00 rows=999861 width=8) (actual time=211.226..790.492 rows=792889 loops=3)
--                                                               Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
--                                                               Rows Removed by Filter: 2540444
-- Planning Time: 0.725 ms
-- JIT:
--   Functions: 79
-- "  Options: Inlining true, Optimization true, Expressions true, Deforming true"
-- "  Timing: Generation 5.544 ms (Deform 2.431 ms), Inlining 256.287 ms, Optimization 407.407 ms, Emission 270.898 ms, Total 940.135 ms"
-- Execution Time: 5392.529 ms




-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
-- time 832 ms

explain analyze
select h.id                                               as hall_id,
       h.name                                             as hall_name,
       hs.id                                              as hall_seat_id,
       hs.number                                          as hall_seat_number,
       count(t.id)                                        as count_tickets,
       case when count(t.id) > 0 then false else true END as is_empty
from halls h
         join hall_seats hs
              on h.id = hs.hall_id
         left join tickets t on hs.id = t.hall_seat_id
         left join sessions s on t.session_id = s.id
where s.id = 4790
group by h.id, hs.id;

-- 10000000
-- GroupAggregate  (cost=100610.01..200186.91 rows=2 width=1049) (actual time=345.628..352.733 rows=1 loops=1)
-- "  Group Key: h.id, hs.id"
--   ->  Incremental Sort  (cost=100610.01..200186.87 rows=2 width=1044) (actual time=345.611..352.715 rows=1 loops=1)
-- "        Sort Key: h.id, hs.id"
--         Presorted Key: h.id
--         Full-sort Groups: 1  Sort Method: quicksort  Average Memory: 25kB  Peak Memory: 25kB
--         ->  Nested Loop  (cost=1033.22..200186.78 rows=2 width=1044) (actual time=345.591..352.703 rows=1 loops=1)
--               Join Filter: (hs.id = t.hall_seat_id)
--               Rows Removed by Join Filter: 13
--               ->  Merge Join  (cost=32.78..35.58 rows=140 width=1040) (actual time=30.449..30.467 rows=14 loops=1)
--                     Merge Cond: (h.id = hs.hall_id)
--                     ->  Sort  (cost=16.39..16.74 rows=140 width=520) (actual time=30.348..30.351 rows=2 loops=1)
--                           Sort Key: h.id
--                           Sort Method: quicksort  Memory: 25kB
--                           ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (actual time=30.326..30.335 rows=2 loops=1)
--                     ->  Sort  (cost=16.39..16.74 rows=140 width=524) (actual time=0.067..0.073 rows=14 loops=1)
--                           Sort Key: hs.hall_id
--                           Sort Method: quicksort  Memory: 25kB
--                           ->  Seq Scan on hall_seats hs  (cost=0.00..11.40 rows=140 width=524) (actual time=0.038..0.041 rows=14 loops=1)
--               ->  Materialize  (cost=1000.43..200147.01 rows=2 width=8) (actual time=22.489..23.012 rows=1 loops=14)
--                     ->  Gather  (cost=1000.43..200147.00 rows=2 width=8) (actual time=314.837..322.150 rows=1 loops=1)
--                           Workers Planned: 2
--                           Workers Launched: 2
--                           ->  Nested Loop  (cost=0.43..199146.80 rows=1 width=8) (actual time=249.676..277.807 rows=0 loops=3)
--                                 ->  Parallel Seq Scan on tickets t  (cost=0.00..199142.33 rows=1 width=12) (actual time=249.613..277.738 rows=0 loops=3)
--                                       Filter: (session_id = 4790)
--                                       Rows Removed by Filter: 3333333
--                                 ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.143..0.145 rows=1 loops=1)
--                                       Index Cond: (id = 4790)
--                                       Heap Fetches: 0
-- Planning Time: 0.398 ms
-- JIT:
--   Functions: 35
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.919 ms (Deform 1.400 ms), Inlining 0.000 ms, Optimization 1.758 ms, Emission 40.981 ms, Total 45.659 ms"
-- Execution Time: 354.942 ms





-- 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
-- time 802 ms

explain analyze
select max(t.session_price * t.seat_price_coefficient) as max_price,
       min(t.session_price * t.seat_price_coefficient) as min_price
from tickets t
         join sessions s on t.session_id = s.id
where s.id = 310;

-- 10000000
-- Aggregate  (cost=200147.02..200147.03 rows=1 width=64) (actual time=325.947..334.547 rows=1 loops=1)
--   ->  Gather  (cost=1000.43..200147.00 rows=2 width=10) (actual time=255.508..334.468 rows=2 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Nested Loop  (cost=0.43..199146.80 rows=1 width=10) (actual time=227.352..286.954 rows=1 loops=3)
--               ->  Parallel Seq Scan on tickets t  (cost=0.00..199142.33 rows=1 width=14) (actual time=226.798..286.396 rows=1 loops=3)
--                     Filter: (session_id = 310)
--                     Rows Removed by Filter: 3333333
--               ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.769..0.771 rows=1 loops=2)
--                     Index Cond: (id = 310)
--                     Heap Fetches: 0
-- Planning Time: 0.173 ms
-- JIT:
--   Functions: 17
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.209 ms (Deform 0.799 ms), Inlining 0.000 ms, Optimization 1.790 ms, Emission 20.055 ms, Total 24.054 ms"
-- Execution Time: 335.561 ms





