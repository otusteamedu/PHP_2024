---6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

SELECT max(tickets.price) as MAXIMUM, min(tickets.price) AS MINUMUM
    from tickets
    join cinema_show_seat on cinema_show_seat.id = tickets.cinema_show_seat_id
    WHERE cinema_show_seat.cinema_show_id = 1;

---10_000 записей
/*
 Aggregate  (cost=366.89..366.90 rows=1 width=64) (actual time=4.839..4.843 rows=1 loops=1)
   ->  Hash Join  (cost=209.00..349.39 rows=3500 width=5) (actual time=1.666..4.026 rows=3500 loops=1)
         Hash Cond: (tickets.cinema_show_seat_id = cinema_show_seat.id)
         ->  Seq Scan on tickets  (cost=0.00..122.00 rows=7000 width=13) (actual time=0.007..0.639 rows=7000 loops=1)
         ->  Hash  (cost=159.00..159.00 rows=4000 width=4) (actual time=1.646..1.648 rows=4000 loops=1)
               Buckets: 4096  Batches: 1  Memory Usage: 173kB
               ->  Seq Scan on cinema_show_seat  (cost=0.00..159.00 rows=4000 width=4) (actual time=0.007..1.036 rows=4000 loops=1)
                     Filter: (cinema_show_id = 1)
                     Rows Removed by Filter: 4000
 Planning Time: 0.269 ms
 Execution Time: 4.898 ms
(11 rows)
*/

--10_000_000 записей
/*
 Finalize Aggregate  (cost=253139.56..253139.57 rows=1 width=64) (actual time=2031.025..2034.348 rows=1 loops=1)
   ->  Gather  (cost=253139.34..253139.55 rows=2 width=64) (actual time=2023.160..2034.281 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=252139.34..252139.35 rows=1 width=64) (actual time=1970.171..1970.177 rows=1 loops=3)
               ->  Parallel Hash Join  (cost=150967.77..251875.45 rows=52778 width=5) (actual time=552.164..1956.264 rows=66333 loops=3)
                     Hash Cond: (tickets.cinema_show_seat_id = cinema_show_seat.id)
                     ->  Parallel Seq Scan on tickets  (cost=0.00..92157.60 rows=3333360 width=13) (actual time=0.060..351.514 rows=2666667 loops=3)
                     ->  Parallel Hash  (cost=149983.12..149983.12 rows=78772 width=4) (actual time=550.968..550.970 rows=66333 loops=3)
                           Buckets: 262144  Batches: 1  Memory Usage: 9888kB
                           ->  Parallel Seq Scan on cinema_show_seat  (cost=0.00..149983.12 rows=78772 width=4) (actual time=41.690..507.508 rows=66333 loops=3)
                                 Filter: (cinema_show_id = 1)
                                 Rows Removed by Filter: 3913667
 Planning Time: 0.564 ms
 JIT:
   Functions: 44
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 2.852 ms, Inlining 0.000 ms, Optimization 1.516 ms, Emission 123.639 ms, Total 128.007 ms
 Execution Time: 2035.481 ms
(19 rows)
*/

/* Предлагаемая оптимизация - добавить индекс на поле cinema_show_seat.cinema_show_id */

CREATE INDEX idx_cinema_show_seat_cinema_show_id ON cinema_show_seat(cinema_show_id);

/* результат для 10_000_000 записей после добавления индекса

 Finalize Aggregate  (cost=108129.89..108129.90 rows=1 width=64) (actual time=1591.975..1611.963 rows=1 loops=1)
   ->  Gather  (cost=108129.67..108129.88 rows=2 width=64) (actual time=1590.315..1611.920 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=107129.67..107129.68 rows=1 width=64) (actual time=1542.759..1542.764 rows=1 loops=3)
               ->  Parallel Hash Join  (cost=5958.44..106865.78 rows=52778 width=5) (actual time=102.710..1520.884 rows=66333 loops=3)
                     Hash Cond: (tickets.cinema_show_seat_id = cinema_show_seat.id)
                     ->  Parallel Seq Scan on tickets  (cost=0.00..92157.33 rows=3333333 width=13) (actual time=0.036..374.305 rows=2666667 loops=3)
                     ->  Parallel Hash  (cost=4568.37..4568.37 rows=111206 width=4) (actual time=94.338..94.340 rows=66333 loops=3)
                           Buckets: 262144  Batches: 1  Memory Usage: 9856kB
                           ->  Parallel Index Scan using idx_cinema_show_seat_cinema_show_id on cinema_show_seat  (cost=0.43..4568.37 rows=111206 width=4) (actual time=21.383..54.182 rows=6
6333 loops=3)
                                 Index Cond: (cinema_show_id = 1)
 Planning Time: 0.380 ms
 JIT:
   Functions: 44
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 3.050 ms, Inlining 0.000 ms, Optimization 1.611 ms, Emission 62.564 ms, Total 67.224 ms
 Execution Time: 1613.397 ms
(18 rows)
*/

/* вывод - добавление индекса сократило Execution Time c 2035.481 ms до 1613.397 ms */