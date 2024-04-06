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
SELECT movie_id, COUNT(s.id)
FROM tickets
         JOIN sessions s on s.id = tickets.session_id
WHERE movie_id = 1
GROUP BY movie_id;

QUERY PLAN     (10000 rows)
---------------------------------------------------------------------------------------------------------------------------------------------------------
 GroupAggregate  (cost=0.29..46.89 rows=1 width=16) (actual time=21.724..21.740 rows=1 loops=1)
   ->  Nested Loop  (cost=0.29..43.76 rows=1250 width=16) (actual time=0.061..16.334 rows=2513 loops=1)
         ->  Seq Scan on sessions s  (cost=0.00..1.10 rows=1 width=16) (actual time=0.018..0.032 rows=2 loops=1)
               Filter: (movie_id = 1)
               Rows Removed by Filter: 6
         ->  Index Only Scan using indx_tickets_session_id on tickets  (cost=0.29..30.16 rows=1250 width=8) (actual time=0.021..2.847 rows=1256 loops=2)
               Index Cond: (session_id = s.id)
               Heap Fetches: 0
 Planning Time: 0.289 ms
 Execution Time: 21.804 ms
(10 rows)



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
