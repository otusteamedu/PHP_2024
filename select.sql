-- Запросы без оптимизации

-- 1. Доступные фильмы на сегодня (с учетом даты сеанса и текущего времени)
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
-- Group  (cost=229620.90..240983.22 rows=113222 width=35) (actual time=755.795..799.458 rows=56230 loops=1)
--   Group Key: f.id
--   ->  Gather Merge  (cost=229620.90..240747.34 rows=94352 width=35) (actual time=755.781..789.651 rows=56330 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Group  (cost=228620.88..228856.76 rows=47176 width=35) (actual time=720.969..728.455 rows=18777 loops=3)
--               Group Key: f.id
--               ->  Sort  (cost=228620.88..228738.82 rows=47176 width=35) (actual time=720.917..724.596 rows=18793 loops=3)
--                     Sort Key: f.id
--                     Sort Method: quicksort  Memory: 1833kB
--                     Worker 0:  Sort Method: quicksort  Memory: 1778kB
--                     Worker 1:  Sort Method: quicksort  Memory: 1778kB
--                     ->  Nested Loop  (cost=54.64..224958.66 rows=47176 width=35) (actual time=18.103..710.980 rows=18793 loops=3)
--                           ->  Hash Join  (cost=54.20..136456.48 rows=47176 width=4) (actual time=18.016..355.825 rows=18793 loops=3)
--                                 Hash Cond: (s.time_id = t.id)
--                                 ->  Parallel Seq Scan on sessions s  (cost=0.00..136030.00 rows=141528 width=8) (actual time=17.735..342.161 rows=113038 loops=3)
--                                       Filter: (date = CURRENT_DATE)
--                                       Rows Removed by Filter: 3220295
--                                 ->  Hash  (cost=45.70..45.70 rows=680 width=4) (actual time=0.176..0.178 rows=1 loops=3)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                       ->  Seq Scan on times t  (cost=0.00..45.70 rows=680 width=4) (actual time=0.164..0.165 rows=1 loops=3)
-- "                                            Filter: ((""time"")::time with time zone > CURRENT_TIME)"
--                                             Rows Removed by Filter: 5
--                           ->  Index Scan using films_pkey on films f  (cost=0.43..1.88 rows=1 width=35) (actual time=0.018..0.018 rows=1 loops=56379)
--                                 Index Cond: (id = s.film_id)
-- Planning Time: 2.314 ms
-- JIT:
--   Functions: 68
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 4.526 ms (Deform 1.672 ms), Inlining 0.000 ms, Optimization 2.395 ms, Emission 50.812 ms, Total 57.733 ms"
-- Execution Time: 847.582 ms


-- 2. Подсчёт проданных билетов за неделю
explain analyze
select sum(t.session_price * t.seat_price_coefficient) as sales_by_week
from tickets t
         join sessions s on t.session_id = s.id
where s.date BETWEEN (CURRENT_DATE - INTERVAL '6 days')
          AND CURRENT_DATE;

-- 10000000
-- Finalize Aggregate  (cost=360222.74..360222.75 rows=1 width=32) (actual time=2632.542..2726.615 rows=1 loops=1)
--   ->  Gather  (cost=360222.52..360222.73 rows=2 width=32) (actual time=2631.649..2726.596 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=359222.52..359222.53 rows=1 width=32) (actual time=2593.543..2594.462 rows=1 loops=3)
--               ->  Parallel Hash Join  (cost=183558.77..354261.36 rows=992230 width=10) (actual time=1917.694..2528.821 rows=793046 loops=3)
--                     Hash Cond: (t.session_id = s.id)
--                     ->  Parallel Seq Scan on tickets t  (cost=0.00..115197.00 rows=4166700 width=14) (actual time=0.381..661.191 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=167280.00..167280.00 rows=992222 width=4) (actual time=826.169..826.170 rows=792741 loops=3)
--                           Buckets: 262144  Batches: 16  Memory Usage: 7904kB
--                           ->  Parallel Seq Scan on sessions s  (cost=0.00..167280.00 rows=992222 width=4) (actual time=10.285..676.458 rows=792741 loops=3)
--                                 Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
--                                 Rows Removed by Filter: 2540592
-- Planning Time: 2.954 ms
-- JIT:
--   Functions: 41
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.840 ms (Deform 0.828 ms), Inlining 0.000 ms, Optimization 1.686 ms, Emission 29.262 ms, Total 33.788 ms"
-- Execution Time: 2727.786 ms



--  3. Формирование афиши (фильмы, которые показывают сегодня, без учета текущего времени)
explain analyze
select distinct f.id as film_id, f.name
from sessions s
         join films f on f.id = s.film_id
where s.date = CURRENT_DATE;

-- 10000000
-- Unique  (cost=306117.76..341266.19 rows=283056 width=35) (actual time=1329.976..1396.738 rows=333301 loops=1)
--   ->  Gather Merge  (cost=306117.76..339850.91 rows=283056 width=35) (actual time=1329.975..1371.886 rows=333301 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Unique  (cost=305117.74..306179.20 rows=141528 width=35) (actual time=1290.133..1305.186 rows=111100 loops=3)
--               ->  Sort  (cost=305117.74..305471.56 rows=141528 width=35) (actual time=1290.132..1296.005 rows=113038 loops=3)
-- "                    Sort Key: f.id, f.name"
--                     Sort Method: external merge  Disk: 5000kB
--                     Worker 0:  Sort Method: external merge  Disk: 5000kB
--                     Worker 1:  Sort Method: external merge  Disk: 4968kB
--                     ->  Parallel Hash Join  (cost=137799.10..289138.50 rows=141528 width=35) (actual time=367.942..1270.649 rows=113038 loops=3)
--                           Hash Cond: (f.id = s.film_id)
--                           ->  Parallel Seq Scan on films f  (cost=0.00..135124.69 rows=4166669 width=35) (actual time=0.496..185.520 rows=3333333 loops=3)
--                           ->  Parallel Hash  (cost=136030.00..136030.00 rows=141528 width=4) (actual time=364.930..364.931 rows=113038 loops=3)
--                                 Buckets: 524288  Batches: 1  Memory Usage: 17440kB
--                                 ->  Parallel Seq Scan on sessions s  (cost=0.00..136030.00 rows=141528 width=4) (actual time=13.980..310.490 rows=113038 loops=3)
--                                       Filter: (date = CURRENT_DATE)
--                                       Rows Removed by Filter: 3220295
-- Planning Time: 0.351 ms
-- JIT:
--   Functions: 40
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 3.157 ms (Deform 1.276 ms), Inlining 0.000 ms, Optimization 2.417 ms, Emission 39.268 ms, Total 44.843 ms"
-- Execution Time: 1406.592 ms





-- 4. Поиск 3 самых прибыльных фильмов за неделю
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
-- Limit  (cost=1177722.30..1177722.30 rows=3 width=75) (actual time=4987.466..5309.724 rows=3 loops=1)
--   ->  Sort  (cost=1177722.30..1183637.07 rows=2365909 width=75) (actual time=4693.490..5015.747 rows=3 loops=1)
--         Sort Key: (sum((t.session_price * t.seat_price_coefficient))) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=845638.32..1147143.37 rows=2365909 width=75) (actual time=3718.557..4894.701 rows=1396595 loops=1)
--               Group Key: f.id
--               ->  Gather Merge  (cost=845638.32..1097853.60 rows=1971590 width=75) (actual time=3718.546..4446.797 rows=1396595 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=844638.30..869283.17 rows=985795 width=75) (actual time=3688.973..3977.879 rows=465532 loops=3)
--                           Group Key: f.id
--                           ->  Sort  (cost=844638.30..847102.79 rows=985795 width=49) (actual time=3688.938..3755.464 rows=793046 loops=3)
--                                 Sort Key: f.id
--                                 Sort Method: external merge  Disk: 47552kB
--                                 Worker 0:  Sort Method: external merge  Disk: 46896kB
--                                 Worker 1:  Sort Method: external merge  Disk: 47808kB
--                                 ->  Parallel Hash Join  (cost=453368.65..679108.83 rows=985795 width=49) (actual time=2976.192..3509.789 rows=793046 loops=3)
--                                       Hash Cond: (f.id = s.film_id)
--                                       ->  Parallel Seq Scan on films f  (cost=0.00..135124.69 rows=4166669 width=35) (actual time=0.057..182.215 rows=3333333 loops=3)
--                                       ->  Parallel Hash  (cost=435269.21..435269.21 rows=985795 width=18) (actual time=2426.609..2426.689 rows=793046 loops=3)
--                                             Buckets: 131072  Batches: 32  Memory Usage: 5152kB
--                                             ->  Parallel Hash Join  (cost=183558.77..435269.21 rows=985795 width=18) (actual time=1694.729..2332.540 rows=793046 loops=3)
--                                                   Hash Cond: (t.session_id = s.id)
--                                                   ->  Parallel Seq Scan on tickets t  (cost=0.00..188455.78 rows=4139678 width=18) (actual time=93.177..346.606 rows=3333333 loops=3)
--                                                   ->  Parallel Hash  (cost=167280.00..167280.00 rows=992222 width=8) (actual time=899.540..899.542 rows=792741 loops=3)
--                                                         Buckets: 262144  Batches: 16  Memory Usage: 7936kB
--                                                         ->  Parallel Seq Scan on sessions s  (cost=0.00..167280.00 rows=992222 width=8) (actual time=212.567..739.597 rows=792741 loops=3)
--                                                               Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
--                                                               Rows Removed by Filter: 2540592
-- Planning Time: 0.463 ms
-- JIT:
--   Functions: 79
-- "  Options: Inlining true, Optimization true, Expressions true, Deforming true"
-- "  Timing: Generation 5.533 ms (Deform 2.431 ms), Inlining 257.785 ms, Optimization 415.556 ms, Emission 258.678 ms, Total 937.552 ms"
-- Execution Time: 5325.479 ms



-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

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
-- GroupAggregate  (cost=100441.33..199849.56 rows=2 width=1049) (actual time=364.325..372.364 rows=1 loops=1)
-- "  Group Key: h.id, hs.id"
--   ->  Incremental Sort  (cost=100441.33..199849.52 rows=2 width=1044) (actual time=364.307..372.346 rows=1 loops=1)
-- "        Sort Key: h.id, hs.id"
--         Presorted Key: h.id
--         Full-sort Groups: 1  Sort Method: quicksort  Average Memory: 25kB  Peak Memory: 25kB
--         ->  Nested Loop  (cost=1033.22..199849.43 rows=2 width=1044) (actual time=364.270..372.318 rows=1 loops=1)
--               Join Filter: (hs.id = t.hall_seat_id)
--               Rows Removed by Join Filter: 13
--               ->  Merge Join  (cost=32.78..35.58 rows=140 width=1040) (actual time=25.120..25.141 rows=14 loops=1)
--                     Merge Cond: (h.id = hs.hall_id)
--                     ->  Sort  (cost=16.39..16.74 rows=140 width=520) (actual time=25.024..25.027 rows=2 loops=1)
--                           Sort Key: h.id
--                           Sort Method: quicksort  Memory: 25kB
--                           ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (actual time=25.004..25.013 rows=2 loops=1)
--                     ->  Sort  (cost=16.39..16.74 rows=140 width=524) (actual time=0.063..0.068 rows=14 loops=1)
--                           Sort Key: hs.hall_id
--                           Sort Method: quicksort  Memory: 25kB
--                           ->  Seq Scan on hall_seats hs  (cost=0.00..11.40 rows=140 width=524) (actual time=0.032..0.035 rows=14 loops=1)
--               ->  Materialize  (cost=1000.43..199809.65 rows=2 width=8) (actual time=17.739..24.794 rows=1 loops=14)
--                     ->  Gather  (cost=1000.43..199809.64 rows=2 width=8) (actual time=248.339..347.103 rows=1 loops=1)
--                           Workers Planned: 2
--                           Workers Launched: 2
--                           ->  Nested Loop  (cost=0.43..198809.44 rows=1 width=8) (actual time=274.427..304.584 rows=0 loops=3)
--                                 ->  Parallel Seq Scan on tickets t  (cost=0.00..198804.98 rows=1 width=12) (actual time=274.393..304.547 rows=0 loops=3)
--                                       Filter: (session_id = 4790)
--                                       Rows Removed by Filter: 3333333
--                                 ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.045..0.046 rows=1 loops=1)
--                                       Index Cond: (id = 4790)
--                                       Heap Fetches: 0
-- Planning Time: 0.364 ms
-- JIT:
--   Functions: 35
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.345 ms (Deform 1.083 ms), Inlining 0.000 ms, Optimization 2.157 ms, Emission 35.892 ms, Total 40.394 ms"
-- Execution Time: 374.026 ms




-- 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

explain analyze
select max(t.session_price * t.seat_price_coefficient) as max_price,
       min(t.session_price * t.seat_price_coefficient) as min_price
from tickets t
         join sessions s on t.session_id = s.id
where s.id = 310;

-- 10000000
-- Aggregate  (cost=199809.66..199809.67 rows=1 width=64) (actual time=351.427..361.617 rows=1 loops=1)
--   ->  Gather  (cost=1000.43..199809.64 rows=2 width=10) (actual time=351.175..361.505 rows=2 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Nested Loop  (cost=0.43..198809.44 rows=1 width=10) (actual time=253.198..313.598 rows=1 loops=3)
--               ->  Parallel Seq Scan on tickets t  (cost=0.00..198804.98 rows=1 width=14) (actual time=253.030..313.426 rows=1 loops=3)
--                     Filter: (session_id = 310)
--                     Rows Removed by Filter: 3333333
--               ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.195..0.197 rows=1 loops=2)
--                     Index Cond: (id = 310)
--                     Heap Fetches: 0
-- Planning Time: 0.240 ms
-- JIT:
--   Functions: 17
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.086 ms (Deform 0.827 ms), Inlining 0.000 ms, Optimization 1.528 ms, Emission 19.229 ms, Total 22.843 ms"
-- Execution Time: 362.790 ms




