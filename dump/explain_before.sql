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




EXPLAIN ANALYSE
SELECT count(t.id) as tickets_sold_last_week
FROM tickets as t
WHERE t.sale_at > (now() - interval '7 day');

QUERY PLAN    (10000 rows)
-------------------------------------------------------------------------------------------------------------------
 Aggregate  (cost=304.15..304.16 rows=1 width=8) (actual time=5.795..5.795 rows=1 loops=1)
   ->  Seq Scan on tickets t  (cost=0.00..279.14 rows=10004 width=8) (actual time=0.011..4.815 rows=10004 loops=1)
         Filter: (sale_at > (now() - '7 days'::interval))
         Rows Removed by Filter: 4
 Planning Time: 0.262 ms
 Execution Time: 5.815 ms




EXPLAIN ANALYSE
SELECT m.name, sum(t.selling_price) as sum, count(t.id) as tickets_count
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE t.sale_at > (now() - interval '7 day')
GROUP BY m.name
ORDER BY sum DESC
LIMIT 3;

QUERY PLAN    (10000 rows)
--------------------------------------------------------------------------------------------------------------------------------------------
 Limit  (cost=439.28..439.28 rows=3 width=556) (actual time=23.568..23.573 rows=3 loops=1)
   ->  Sort  (cost=439.28..439.63 rows=140 width=556) (actual time=23.566..23.570 rows=3 loops=1)
         Sort Key: (sum(t.selling_price)) DESC
    Sort Method: quicksort  Memory: 25kB
         ->  HashAggregate  (cost=435.72..437.47 rows=140 width=556) (actual time=23.550..23.557 rows=4 loops=1)
               Group Key: m.name
               Batches: 1  Memory Usage: 40kB
               ->  Hash Left Join  (cost=14.33..360.69 rows=10004 width=529) (actual time=0.058..16.960 rows=10004 loops=1)
                     Hash Cond: (s.movie_id = m.id)
                     ->  Hash Left Join  (cost=1.18..320.49 rows=10004 width=21) (actual time=0.044..12.471 rows=10004 loops=1)
                           Hash Cond: (t.session_id = s.id)
                           ->  Seq Scan on tickets t  (cost=0.00..279.14 rows=10004 width=21) (actual time=0.021..7.398 rows=10004 loops=1)
                                 Filter: (sale_at > (now() - '7 days'::interval))
                                 Rows Removed by Filter: 4
                           ->  Hash  (cost=1.08..1.08 rows=8 width=16) (actual time=0.015..0.016 rows=8 loops=1)
                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                 ->  Seq Scan on sessions s  (cost=0.00..1.08 rows=8 width=16) (actual time=0.006..0.009 rows=8 loops=1)
                     ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.009..0.009 rows=4 loops=1)
                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
                           ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.005..0.006 rows=4 loops=1)
 Planning Time: 0.424 ms
 Execution Time: 23.653 ms






EXPLAIN ANALYSE
SELECT m.name, MIN(t.selling_price) as min_sell_price, MAX(t.selling_price) as max_sell_price
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE s.id = 2
GROUP BY m.name;

QUERY PLAN
------------------------------------------------------------------------------------------------------------------------------------------
 HashAggregate  (cost=260.49..261.89 rows=140 width=580) (actual time=17.050..17.084 rows=1 loops=1)
   Group Key: m.name
   Batches: 1  Memory Usage: 40kB
   ->  Nested Loop  (cost=0.14..251.06 rows=1258 width=521) (actual time=0.060..12.342 rows=1258 loops=1)
         ->  Nested Loop Left Join  (cost=0.14..9.38 rows=1 width=524) (actual time=0.046..0.069 rows=1 loops=1)
               ->  Seq Scan on sessions s  (cost=0.00..1.10 rows=1 width=16) (actual time=0.018..0.027 rows=1 loops=1)
                     Filter: (id = 2)
                     Rows Removed by Filter: 7
               ->  Index Scan using movies_pkey on movies m  (cost=0.14..8.16 rows=1 width=524) (actual time=0.017..0.019 rows=1 loops=1)
                     Index Cond: (id = s.movie_id)
         ->  Seq Scan on tickets t  (cost=0.00..229.10 rows=1258 width=13) (actual time=0.008..5.710 rows=1258 loops=1)
               Filter: (session_id = 2)
               Rows Removed by Filter: 8750
 Planning Time: 0.308 ms
 Execution Time: 17.171 ms
