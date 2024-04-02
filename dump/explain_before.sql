EXPLAIN ANALYSE
    SELECT id, row, place
FROM tickets where place > 10;

QUERY PLAN   (10000 rows)
----------------------------------------------------------------------------------------------------
 Seq Scan on tickets  (cost=0.00..229.05 rows=3 width=16) (actual time=0.034..3.850 rows=3 loops=1)
   Filter: (place > 10)
   Rows Removed by Filter: 10001
 Planning Time: 1.031 ms
 Execution Time: 3.982 ms
(5 rows)



EXPLAIN ANALYSE
    SELECT id, row, place, session_id
FROM tickets where place > 10 ORDER BY session_id;

QUERY PLAN   (10000 rows)
----------------------------------------------------------------------------------------------------------
 Sort  (cost=229.07..229.08 rows=3 width=24) (actual time=2.102..2.116 rows=3 loops=1)
   Sort Key: session_id
   Sort Method: quicksort  Memory: 25kB
   ->  Seq Scan on tickets  (cost=0.00..229.05 rows=3 width=24) (actual time=0.020..2.049 rows=3 loops=1)
         Filter: (place > 10)
         Rows Removed by Filter: 10001
 Planning Time: 0.239 ms
 Execution Time: 2.172 ms
(8 rows)




EXPLAIN ANALYSE
    SELECT session_id, count(id)
FROM tickets GROUP BY session_id;

QUERY PLAN      (10000 rows)
-------------------------------------------------------------------------------------------------------------------
 HashAggregate  (cost=254.06..254.14 rows=8 width=16) (actual time=44.967..44.995 rows=8 loops=1)
   Group Key: session_id
   Batches: 1  Memory Usage: 24kB
   ->  Seq Scan on tickets  (cost=0.00..204.04 rows=10004 width=16) (actual time=0.009..21.803 rows=10004 loops=1)
 Planning Time: 0.167 ms
 Execution Time: 45.126 ms
(6 rows)



EXPLAIN ANALYSE
    SELECT m.name, p.price as sum
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE p.price > 100 and z.number_of_seats > 40;

QUERY PLAN    (10000 rows)
---------------------------------------------------------------------------------------------------------------------------------------------
 Hash Left Join  (cost=77.64..353.39 rows=870 width=530) (actual time=0.257..132.717 rows=3452 loops=1)
   Hash Cond: (s.movie_id = m.id)
   ->  Nested Loop Left Join  (cost=64.49..337.91 rows=870 width=22) (actual time=0.198..112.072 rows=3452 loops=1)
         ->  Hash Join  (cost=64.33..314.61 rows=870 width=22) (actual time=0.160..69.459 rows=3452 loops=1)
               Hash Cond: (tickets.zone_id = z.id)
               ->  Seq Scan on tickets  (cost=0.00..204.04 rows=10004 width=16) (actual time=0.011..28.920 rows=10004 loops=1)
               ->  Hash  (cost=62.61..62.61 rows=137 width=30) (actual time=0.116..0.158 rows=2 loops=1)
                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
                     ->  Hash Join  (cost=36.16..62.61 rows=137 width=30) (actual time=0.074..0.136 rows=2 loops=1)
                           Hash Cond: (p.zone_id = z.id)
                           ->  Seq Scan on prices p  (cost=0.00..25.38 rows=410 width=22) (actual time=0.013..0.028 rows=6 loops=1)
                                 Filter: (price > '100'::numeric)
                           ->  Hash  (cost=29.62..29.62 rows=523 width=8) (actual time=0.023..0.052 rows=1 loops=1)
                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                 ->  Seq Scan on zones z  (cost=0.00..29.62 rows=523 width=8) (actual time=0.007..0.031 rows=1 loops=1)
                                       Filter: (number_of_seats > 40)
                                       Rows Removed by Filter: 5
         ->  Memoize  (cost=0.16..0.18 rows=1 width=16) (actual time=0.003..0.003 rows=1 loops=3452)
               Cache Key: tickets.session_id
               Cache Mode: logical
               Hits: 3444  Misses: 8  Evictions: 0  Overflows: 0  Memory Usage: 1kB
               ->  Index Scan using sessions_pkey on sessions s  (cost=0.15..0.17 rows=1 width=16) (actual time=0.007..0.007 rows=1 loops=8)
                     Index Cond: (id = tickets.session_id)
   ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.032..0.051 rows=4 loops=1)
         Buckets: 1024  Batches: 1  Memory Usage: 9kB
         ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.008..0.032 rows=4 loops=1)
 Planning Time: 1.695 ms
 Execution Time: 143.012 ms
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
 Sort  (cost=556.93..563.46 rows=2613 width=530) (actual time=77.444..83.191 rows=3310 loops=1)
   Sort Key: p.price
   Sort Method: quicksort  Memory: 252kB
   ->  Hash Left Join  (cost=127.05..408.62 rows=2613 width=530) (actual time=0.269..69.806 rows=3310 loops=1)
         Hash Cond: (s.movie_id = m.id)
         ->  Hash Left Join  (cost=113.90..388.47 rows=2613 width=22) (actual time=0.203..57.153 rows=3310 loops=1)
               Hash Cond: (tickets.session_id = s.id)
               ->  Hash Join  (cost=76.90..344.59 rows=2613 width=22) (actual time=0.137..44.392 rows=3310 loops=1)
                     Hash Cond: (tickets.zone_id = z.id)
                     ->  Seq Scan on tickets  (cost=0.00..204.04 rows=10004 width=16) (actual time=0.014..18.575 rows=10004 loops=1)
                     ->  Hash  (cost=71.78..71.78 rows=410 width=30) (actual time=0.109..0.136 rows=2 loops=1)
                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
                           ->  Hash Join  (cost=45.33..71.78 rows=410 width=30) (actual time=0.078..0.119 rows=2 loops=1)
                                 Hash Cond: (p.zone_id = z.id)
                                 ->  Seq Scan on prices p  (cost=0.00..25.38 rows=410 width=22) (actual time=0.015..0.024 rows=2 loops=1)
                                       Filter: (price > '300'::numeric)
                                       Rows Removed by Filter: 4
                                 ->  Hash  (cost=25.70..25.70 rows=1570 width=8) (actual time=0.042..0.050 rows=6 loops=1)
                                       Buckets: 2048  Batches: 1  Memory Usage: 17kB
                                       ->  Seq Scan on zones z  (cost=0.00..25.70 rows=1570 width=8) (actual time=0.009..0.023 rows=6 loops=1)
               ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.050..0.057 rows=8 loops=1)
                     Buckets: 2048  Batches: 1  Memory Usage: 17kB
                     ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.009..0.027 rows=8 loops=1)
         ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.037..0.046 rows=4 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 9kB
               ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.011..0.021 rows=4 loops=1)
 Planning Time: 1.111 ms
 Execution Time: 89.050 ms
(28 rows)





EXPLAIN ANALYSE
    SELECT m.name, sum(t.selling_price) as sum
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
GROUP BY m.id
ORDER BY sum DESC;

QUERY PLAN   (10000 rows)
---------------------------------------------------------------------------------------------------------------------------------------
 Sort  (cost=364.12..364.47 rows=140 width=556) (actual time=247.158..247.257 rows=4 loops=1)
   Sort Key: (sum(t.selling_price)) DESC
    Sort Method: quicksort  Memory: 25kB
   ->  HashAggregate  (cost=357.38..359.13 rows=140 width=556) (actual time=247.047..247.138 rows=4 loops=1)
         Group Key: m.id
         Batches: 1  Memory Usage: 40kB
         ->  Hash Left Join  (cost=50.15..307.36 rows=10004 width=529) (actual time=0.283..203.764 rows=10004 loops=1)
               Hash Cond: (s.movie_id = m.id)
               ->  Hash Left Join  (cost=37.00..267.39 rows=10004 width=13) (actual time=0.147..122.561 rows=10004 loops=1)
                     Hash Cond: (t.session_id = s.id)
                     ->  Seq Scan on tickets t  (cost=0.00..204.04 rows=10004 width=13) (actual time=0.014..41.350 rows=10004 loops=1)
                     ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.101..0.106 rows=8 loops=1)
                           Buckets: 2048  Batches: 1  Memory Usage: 17kB
                           ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.025..0.068 rows=8 loops=1)
               ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.089..0.103 rows=4 loops=1)
                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
                     ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.021..0.048 rows=4 loops=1)
 Planning Time: 0.957 ms
 Execution Time: 247.479 ms
(19 rows)
