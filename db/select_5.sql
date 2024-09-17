---5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

SELECT seats.row, seats.place, (case when tickets.id is not null then 1 else 0 end) as status_place from seats
    JOIN cinema_show_seat on cinema_show_seat.seat_id = seats.id
    LEFT JOIN tickets on tickets.cinema_show_seat_id = cinema_show_seat.id
    WHERE cinema_show_seat.cinema_show_id = 1;


---10_000 записей
/*
 Merge Join  (cost=589.12..793.35 rows=4000 width=12) (actual time=5.952..9.845 rows=4000 loops=1)
   Merge Cond: (seats.id = cinema_show_seat.seat_id)
   ->  Index Scan using seats_pkey on seats  (cost=0.42..6644.42 rows=199000 width=12) (actual time=0.013..1.363 rows=4001 loops=1)
   ->  Sort  (cost=588.70..598.70 rows=4000 width=12) (actual time=5.919..6.244 rows=4000 loops=1)
         Sort Key: cinema_show_seat.seat_id
         Sort Method: quicksort  Memory: 311kB
         ->  Hash Right Join  (cost=209.00..349.39 rows=4000 width=12) (actual time=2.259..4.847 rows=4000 loops=1)
               Hash Cond: (tickets.cinema_show_seat_id = cinema_show_seat.id)
               ->  Seq Scan on tickets  (cost=0.00..122.00 rows=7000 width=12) (actual time=0.010..0.714 rows=7000 loops=1)
               ->  Hash  (cost=159.00..159.00 rows=4000 width=12) (actual time=2.235..2.236 rows=4000 loops=1)
                     Buckets: 4096  Batches: 1  Memory Usage: 204kB
                     ->  Seq Scan on cinema_show_seat  (cost=0.00..159.00 rows=4000 width=12) (actual time=0.010..1.359 rows=4000 loops=1)
                           Filter: (cinema_show_id = 1)
                           Rows Removed by Filter: 4000
 Planning Time: 0.743 ms
 Execution Time: 10.290 ms
(16 rows)
*/

--10_000_000 записей
/*
 Gather  (cost=155199.43..342053.76 rows=189052 width=12) (actual time=1856.308..3151.686 rows=199000 loops=1)
   Workers Planned: 2
   Workers Launched: 2
   ->  Parallel Hash Left Join  (cost=154199.43..322148.56 rows=78772 width=12) (actual time=1822.009..2668.002 rows=66333 loops=3)
         Hash Cond: (cinema_show_seat.id = tickets.cinema_show_seat_id)
         ->  Parallel Hash Join  (cost=4097.83..154287.73 rows=78772 width=12) (actual time=88.542..518.772 rows=66333 loops=3)
               Hash Cond: (cinema_show_seat.seat_id = seats.id)
               ->  Parallel Seq Scan on cinema_show_seat  (cost=0.00..149983.12 rows=78772 width=12) (actual time=0.114..394.442 rows=66333 loops=3)
                     Filter: (cinema_show_id = 1)
                     Rows Removed by Filter: 3913667
               ->  Parallel Hash  (cost=2634.59..2634.59 rows=117059 width=12) (actual time=77.650..77.653 rows=66333 loops=3)
                     Buckets: 262144  Batches: 1  Memory Usage: 11424kB
                     ->  Parallel Seq Scan on seats  (cost=0.00..2634.59 rows=117059 width=12) (actual time=0.082..39.682 rows=66333 loops=3)
         ->  Parallel Hash  (cost=92157.60..92157.60 rows=3333360 width=12) (actual time=1236.443..1236.444 rows=2666667 loops=3)
               Buckets: 262144  Batches: 64  Memory Usage: 8000kB
               ->  Parallel Seq Scan on tickets  (cost=0.00..92157.60 rows=3333360 width=12) (actual time=12.102..493.069 rows=2666667 loops=3)
 Planning Time: 1.661 ms
 JIT:
   Functions: 63
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 3.218 ms, Inlining 0.000 ms, Optimization 1.829 ms, Emission 34.690 ms, Total 39.737 ms
 Execution Time: 3198.719 ms
(22 rows)
*/

/* Предлагаемая оптимизация - добавить индекс на поле cinema_show_seat.cinema_show_id */

CREATE INDEX idx_cinema_show_seat_cinema_show_id ON cinema_show_seat(cinema_show_id);

/* результат для 10_000_000 записей после добавления индекса

 Gather  (cost=155199.26..197332.61 rows=189050 width=12) (actual time=2155.373..3746.387 rows=199000 loops=1)
   Workers Planned: 1
   Workers Launched: 1
   ->  Parallel Hash Left Join  (cost=154199.26..177427.61 rows=111206 width=12) (actual time=2098.504..3343.306 rows=99500 loops=2)
         Hash Cond: (cinema_show_seat.id = tickets.cinema_show_seat_id)
         ->  Parallel Hash Join  (cost=4098.26..8958.12 rows=111206 width=12) (actual time=72.995..139.003 rows=99500 loops=2)
               Hash Cond: (cinema_show_seat.seat_id = seats.id)
               ->  Parallel Index Scan using idx_cinema_show_seat_cinema_show_id on cinema_show_seat  (cost=0.43..4568.37 rows=111206 width=12) (actual time=0.119..25.809 rows=99500 loops=2
)
                     Index Cond: (cinema_show_id = 1)
               ->  Parallel Hash  (cost=2634.59..2634.59 rows=117059 width=12) (actual time=71.312..71.314 rows=99500 loops=2)
                     Buckets: 262144  Batches: 1  Memory Usage: 11424kB
                     ->  Parallel Seq Scan on seats  (cost=0.00..2634.59 rows=117059 width=12) (actual time=0.084..21.905 rows=99500 loops=2)
         ->  Parallel Hash  (cost=92157.33..92157.33 rows=3333333 width=12) (actual time=1906.181..1906.182 rows=4000000 loops=2)
               Buckets: 262144  Batches: 64  Memory Usage: 7968kB
               ->  Parallel Seq Scan on tickets  (cost=0.00..92157.33 rows=3333333 width=12) (actual time=41.530..791.797 rows=4000000 loops=2)
 Planning Time: 1.989 ms
 JIT:
   Functions: 42
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 17.898 ms, Inlining 0.000 ms, Optimization 4.903 ms, Emission 78.263 ms, Total 101.064 ms
 Execution Time: 3812.349 ms
(21 rows)
*/

/*Вывод - добавление индекса не дает улучшения времени выполнения запроса. удалим индекс командой */

DROP INDEX idx_cinema_show_seat_cinema_show_id;

/* Предлагаемая ещё одна оптимизация - добавление индекса на tickets.cinema_show_seat_id */

CREATE INDEX idx_tickets_cinema_show_seat_id ON tickets(cinema_show_seat_id);

/* результат для 10_000_000 записей после добавления индекса

Gather  (cost=155198.82..342052.32 rows=189050 width=12) (actual time=2036.222..3384.845 rows=199000 loops=1)
   Workers Planned: 2
   Workers Launched: 2
   ->  Parallel Hash Left Join  (cost=154198.82..322147.32 rows=78771 width=12) (actual time=1986.155..2865.870 rows=66333 loops=3)
         Hash Cond: (cinema_show_seat.id = tickets.cinema_show_seat_id)
         ->  Parallel Hash Join  (cost=4097.83..154287.10 rows=78771 width=12) (actual time=57.578..563.621 rows=66333 loops=3)
               Hash Cond: (cinema_show_seat.seat_id = seats.id)
               ->  Parallel Seq Scan on cinema_show_seat  (cost=0.00..149982.50 rows=78771 width=12) (actual time=0.067..465.710 rows=66333 loops=3)
                     Filter: (cinema_show_id = 1)
                     Rows Removed by Filter: 3913667
               ->  Parallel Hash  (cost=2634.59..2634.59 rows=117059 width=12) (actual time=46.333..46.335 rows=66333 loops=3)
                     Buckets: 262144  Batches: 1  Memory Usage: 11424kB
                     ->  Parallel Seq Scan on seats  (cost=0.00..2634.59 rows=117059 width=12) (actual time=0.080..15.206 rows=66333 loops=3)
         ->  Parallel Hash  (cost=92157.33..92157.33 rows=3333333 width=12) (actual time=1374.353..1374.354 rows=2666667 loops=3)
               Buckets: 262144  Batches: 64  Memory Usage: 7968kB
               ->  Parallel Seq Scan on tickets  (cost=0.00..92157.33 rows=3333333 width=12) (actual time=18.062..554.300 rows=2666667 loops=3)
 Planning Time: 1.555 ms
 JIT:
   Functions: 63
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 3.702 ms, Inlining 0.000 ms, Optimization 3.083 ms, Emission 51.393 ms, Total 58.178 ms
 Execution Time: 3426.769 ms
(22 rows) */

/*Вывод - добавление индекса не дает улучшения времени выполнения запроса. удалим индекс командой */

DROP INDEX idx_tickets_cinema_show_seat_id;

/* Предлагаемая ещё одна оптимизация - добавление индекса на cinema_show_seat.seat_id */

CREATE INDEX idx_cinema_show_seat_seat_id ON cinema_show_seat(seat_id);

/* результат для 10_000_000 записей после добавления индекса

 Gather  (cost=155198.82..342052.32 rows=189050 width=12) (actual time=1926.563..3224.370 rows=199000 loops=1)
   Workers Planned: 2
   Workers Launched: 2
   ->  Parallel Hash Left Join  (cost=154198.82..322147.32 rows=78771 width=12) (actual time=1925.739..2719.078 rows=66333 loops=3)
         Hash Cond: (cinema_show_seat.id = tickets.cinema_show_seat_id)
         ->  Parallel Hash Join  (cost=4097.83..154287.10 rows=78771 width=12) (actual time=89.439..527.762 rows=66333 loops=3)
               Hash Cond: (cinema_show_seat.seat_id = seats.id)
               ->  Parallel Seq Scan on cinema_show_seat  (cost=0.00..149982.50 rows=78771 width=12) (actual time=0.049..410.053 rows=66333 loops=3)
                     Filter: (cinema_show_id = 1)
                     Rows Removed by Filter: 3913667
               ->  Parallel Hash  (cost=2634.59..2634.59 rows=117059 width=12) (actual time=88.203..88.205 rows=66333 loops=3)
                     Buckets: 262144  Batches: 1  Memory Usage: 11424kB
                     ->  Parallel Seq Scan on seats  (cost=0.00..2634.59 rows=117059 width=12) (actual time=0.060..10.918 rows=66333 loops=3)
         ->  Parallel Hash  (cost=92157.33..92157.33 rows=3333333 width=12) (actual time=1339.989..1339.989 rows=2666667 loops=3)
               Buckets: 262144  Batches: 64  Memory Usage: 7968kB
               ->  Parallel Seq Scan on tickets  (cost=0.00..92157.33 rows=3333333 width=12) (actual time=14.186..536.650 rows=2666667 loops=3)
 Planning Time: 0.722 ms
 JIT:
   Functions: 63
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 10.483 ms, Inlining 0.000 ms, Optimization 2.171 ms, Emission 40.602 ms, Total 53.256 ms
 Execution Time: 3237.496 ms
(22 rows)
*/

/*Вывод - добавление индекса не дает улучшения времени выполнения запроса. удалим индекс командой */

DROP INDEX idx_cinema_show_seat_seat_id;