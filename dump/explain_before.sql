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
SELECT movie_id, COUNT(s.id)
FROM tickets
         JOIN sessions s on s.id = tickets.session_id
WHERE movie_id = 1
GROUP BY movie_id;

QUERY PLAN      (10000 rows)
------------------------------------------------------------------------------------------------------------------------
 GroupAggregate  (cost=25.07..255.60 rows=1 width=16) (actual time=52.567..52.596 rows=1 loops=1)
   ->  Hash Join  (cost=25.07..255.46 rows=50 width=16) (actual time=0.067..47.187 rows=2513 loops=1)
         Hash Cond: (tickets.session_id = s.id)
         ->  Seq Scan on tickets  (cost=0.00..204.04 rows=10004 width=8) (actual time=0.015..20.363 rows=10004 loops=1)
         ->  Hash  (cost=25.00..25.00 rows=6 width=16) (actual time=0.034..0.043 rows=2 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 9kB
               ->  Seq Scan on sessions s  (cost=0.00..25.00 rows=6 width=16) (actual time=0.011..0.020 rows=2 loops=1)
                     Filter: (movie_id = 1)
                     Rows Removed by Filter: 6
 Planning Time: 0.219 ms
 Execution Time: 52.671 ms
(11 rows)




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
