EXPLAIN ANALYSE
    SELECT id, row, place
FROM tickets where place > 10;

QUERY PLAN   (10000 rows)
---------------------------------------------------------------------------------------------------------------------------
 Bitmap Heap Scan on tickets  (cost=4.30..11.49 rows=2 width=16) (actual time=0.038..0.056 rows=3 loops=1)
   Recheck Cond: (place > 10)
   Heap Blocks: exact=1
   ->  Bitmap Index Scan on indx_tickets_place  (cost=0.00..4.30 rows=2 width=0) (actual time=0.022..0.025 rows=3 loops=1)
         Index Cond: (place > 10)
 Planning Time: 0.596 ms
 Execution Time: 0.138 ms
(7 rows)



EXPLAIN ANALYSE
    SELECT id, row, place, session_id
FROM tickets where place > 10 ORDER BY session_id;

QUERY PLAN   (10000 rows)
---------------------------------------------------------------------------------------------------------------------------------
 Sort  (cost=11.50..11.51 rows=2 width=24) (actual time=0.063..0.079 rows=3 loops=1)
   Sort Key: session_id
   Sort Method: quicksort  Memory: 25kB
   ->  Bitmap Heap Scan on tickets  (cost=4.30..11.49 rows=2 width=24) (actual time=0.031..0.045 rows=3 loops=1)
         Recheck Cond: (place > 10)
         Heap Blocks: exact=1
         ->  Bitmap Index Scan on indx_tickets_place  (cost=0.00..4.30 rows=2 width=0) (actual time=0.012..0.014 rows=3 loops=1)
               Index Cond: (place > 10)
 Planning Time: 0.370 ms
 Execution Time: 0.133 ms
(10 rows)



EXPLAIN ANALYSE
    SELECT session_id, count(id)
FROM tickets GROUP BY session_id;

QUERY PLAN   (10000 rows)
-------------------------------------------------------------------------------------------------------------------
 HashAggregate  (cost=254.06..254.14 rows=8 width=16) (actual time=45.954..45.973 rows=8 loops=1)
   Group Key: session_id
   Batches: 1  Memory Usage: 24kB
   ->  Seq Scan on tickets  (cost=0.00..204.04 rows=10004 width=16) (actual time=0.021..21.872 rows=10004 loops=1)
 Planning Time: 0.175 ms
 Execution Time: 46.057 ms
(6 rows)



EXPLAIN ANALYSE
    SELECT m.name, p.price as sum
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE p.price > 100 and z.number_of_seats > 40;

QUERY PLAN   (10000 rows)
---------------------------------------------------------------------------------------------------------------------------------------------
 Hash Left Join  (cost=77.64..353.39 rows=870 width=530) (actual time=0.237..88.330 rows=3452 loops=1)
   Hash Cond: (s.movie_id = m.id)
   ->  Nested Loop Left Join  (cost=64.49..337.91 rows=870 width=22) (actual time=0.195..74.630 rows=3452 loops=1)
         ->  Hash Join  (cost=64.33..314.61 rows=870 width=22) (actual time=0.163..47.178 rows=3452 loops=1)
               Hash Cond: (tickets.zone_id = z.id)
               ->  Seq Scan on tickets  (cost=0.00..204.04 rows=10004 width=16) (actual time=0.015..19.767 rows=10004 loops=1)
               ->  Hash  (cost=62.61..62.61 rows=137 width=30) (actual time=0.107..0.136 rows=2 loops=1)
                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
                     ->  Hash Join  (cost=36.16..62.61 rows=137 width=30) (actual time=0.075..0.121 rows=2 loops=1)
                           Hash Cond: (p.zone_id = z.id)
                           ->  Seq Scan on prices p  (cost=0.00..25.38 rows=410 width=22) (actual time=0.041..0.055 rows=6 loops=1)
                                 Filter: (price > '100'::numeric)
                           ->  Hash  (cost=29.62..29.62 rows=523 width=8) (actual time=0.019..0.029 rows=1 loops=1)
                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                 ->  Seq Scan on zones z  (cost=0.00..29.62 rows=523 width=8) (actual time=0.008..0.013 rows=1 loops=1)
                                       Filter: (number_of_seats > 40)
                                       Rows Removed by Filter: 5
         ->  Memoize  (cost=0.16..0.18 rows=1 width=16) (actual time=0.002..0.002 rows=1 loops=3452)
               Cache Key: tickets.session_id
               Cache Mode: logical
               Hits: 3444  Misses: 8  Evictions: 0  Overflows: 0  Memory Usage: 1kB
               ->  Index Scan using sessions_pkey on sessions s  (cost=0.15..0.17 rows=1 width=16) (actual time=0.005..0.006 rows=1 loops=8)
                     Index Cond: (id = tickets.session_id)
   ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.028..0.036 rows=4 loops=1)
         Buckets: 1024  Batches: 1  Memory Usage: 9kB
         ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.007..0.017 rows=4 loops=1)
 Planning Time: 1.077 ms
 Execution Time: 95.128 ms
(28 rows)


EXPLAIN ANALYSE
    SELECT m.name, p.price
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE p.price > 300 ORDER BY p.price;

QUERY PLAN   (10000 rows)
-----------------------------------------------------------------------------------------------------------------------------------------------
 Sort  (cost=556.93..563.46 rows=2613 width=530) (actual time=81.806..88.046 rows=3310 loops=1)
   Sort Key: p.price
   Sort Method: quicksort  Memory: 252kB
   ->  Hash Left Join  (cost=127.05..408.62 rows=2613 width=530) (actual time=0.264..73.813 rows=3310 loops=1)
         Hash Cond: (s.movie_id = m.id)
         ->  Hash Left Join  (cost=113.90..388.47 rows=2613 width=22) (actual time=0.221..60.453 rows=3310 loops=1)
               Hash Cond: (tickets.session_id = s.id)
               ->  Hash Join  (cost=76.90..344.59 rows=2613 width=22) (actual time=0.122..46.994 rows=3310 loops=1)
                     Hash Cond: (tickets.zone_id = z.id)
                     ->  Seq Scan on tickets  (cost=0.00..204.04 rows=10004 width=16) (actual time=0.020..19.855 rows=10004 loops=1)
                     ->  Hash  (cost=71.78..71.78 rows=410 width=30) (actual time=0.090..0.109 rows=2 loops=1)
                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
                           ->  Hash Join  (cost=45.33..71.78 rows=410 width=30) (actual time=0.065..0.096 rows=2 loops=1)
                                 Hash Cond: (p.zone_id = z.id)
                                 ->  Seq Scan on prices p  (cost=0.00..25.38 rows=410 width=22) (actual time=0.014..0.021 rows=2 loops=1)
                                       Filter: (price > '300'::numeric)
                                       Rows Removed by Filter: 4
                                 ->  Hash  (cost=25.70..25.70 rows=1570 width=8) (actual time=0.038..0.046 rows=6 loops=1)
                                       Buckets: 2048  Batches: 1  Memory Usage: 17kB
                                       ->  Seq Scan on zones z  (cost=0.00..25.70 rows=1570 width=8) (actual time=0.006..0.020 rows=6 loops=1)
               ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.087..0.094 rows=8 loops=1)
                     Buckets: 2048  Batches: 1  Memory Usage: 17kB
                     ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.007..0.049 rows=8 loops=1)
         ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.029..0.039 rows=4 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 9kB
               ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.009..0.020 rows=4 loops=1)
 Planning Time: 0.841 ms
 Execution Time: 94.099 ms
(28 rows)


EXPLAIN ANALYSE
    SELECT m.name, sum(t.selling_price) as sum
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
GROUP BY m.id
ORDER BY sum DESC;


QUERY PLAN    (10000 rows)
---------------------------------------------------------------------------------------------------------------------------------------
 Sort  (cost=364.12..364.47 rows=140 width=556) (actual time=115.300..115.352 rows=4 loops=1)
   Sort Key: (sum(t.selling_price)) DESC
    Sort Method: quicksort  Memory: 25kB
   ->  HashAggregate  (cost=357.38..359.13 rows=140 width=556) (actual time=115.249..115.302 rows=4 loops=1)
         Group Key: m.id
         Batches: 1  Memory Usage: 40kB
         ->  Hash Left Join  (cost=50.15..307.36 rows=10004 width=529) (actual time=0.157..95.060 rows=10004 loops=1)
               Hash Cond: (s.movie_id = m.id)
               ->  Hash Left Join  (cost=37.00..267.39 rows=10004 width=13) (actual time=0.101..57.067 rows=10004 loops=1)
                     Hash Cond: (t.session_id = s.id)
                     ->  Seq Scan on tickets t  (cost=0.00..204.04 rows=10004 width=13) (actual time=0.017..18.634 rows=10004 loops=1)
                     ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.064..0.071 rows=8 loops=1)
                           Buckets: 2048  Batches: 1  Memory Usage: 17kB
                           ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.015..0.034 rows=8 loops=1)
               ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.040..0.050 rows=4 loops=1)
                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
                     ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.009..0.025 rows=4 loops=1)
 Planning Time: 0.521 ms
 Execution Time: 115.476 ms
(19 rows)
