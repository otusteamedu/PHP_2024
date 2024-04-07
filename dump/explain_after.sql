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



EXPLAIN ANALYSE
    SELECT count(t.id) as tickets_sold_last_week
FROM tickets as t
WHERE t.sale_at > (now() - interval '7 day');

QUERY PLAN   (10000 rows)
-------------------------------------------------------------------------------------------------------------------
 Aggregate  (cost=304.15..304.16 rows=1 width=8) (actual time=6.258..6.259 rows=1 loops=1)
   ->  Seq Scan on tickets t  (cost=0.00..279.14 rows=10004 width=8) (actual time=0.013..5.272 rows=10004 loops=1)
         Filter: (sale_at > (now() - '7 days'::interval))
         Rows Removed by Filter: 4
 Planning Time: 0.186 ms
 Execution Time: 6.295 ms



EXPLAIN ANALYSE
SELECT m.name, sum(t.selling_price) as sum, count(t.id) as tickets_count
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE t.sale_at > (now() - interval '7 day')
GROUP BY m.name
ORDER BY sum DESC
LIMIT 3;

QUERY PLAN   (10000 rows)
--------------------------------------------------------------------------------------------------------------------------------------------
 Limit  (cost=439.28..439.28 rows=3 width=556) (actual time=14.312..14.318 rows=3 loops=1)
   ->  Sort  (cost=439.28..439.63 rows=140 width=556) (actual time=14.311..14.316 rows=3 loops=1)
         Sort Key: (sum(t.selling_price)) DESC
    Sort Method: quicksort  Memory: 25kB
         ->  HashAggregate  (cost=435.72..437.47 rows=140 width=556) (actual time=14.295..14.302 rows=4 loops=1)
               Group Key: m.name
               Batches: 1  Memory Usage: 40kB
               ->  Hash Left Join  (cost=14.33..360.69 rows=10004 width=529) (actual time=0.037..9.682 rows=10004 loops=1)
                     Hash Cond: (s.movie_id = m.id)
                     ->  Hash Left Join  (cost=1.18..320.49 rows=10004 width=21) (actual time=0.026..7.079 rows=10004 loops=1)
                           Hash Cond: (t.session_id = s.id)
                           ->  Seq Scan on tickets t  (cost=0.00..279.14 rows=10004 width=21) (actual time=0.011..4.089 rows=10004 loops=1)
                                 Filter: (sale_at > (now() - '7 days'::interval))
                                 Rows Removed by Filter: 4
                           ->  Hash  (cost=1.08..1.08 rows=8 width=16) (actual time=0.009..0.011 rows=8 loops=1)
                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                 ->  Seq Scan on sessions s  (cost=0.00..1.08 rows=8 width=16) (actual time=0.003..0.006 rows=8 loops=1)
                     ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.007..0.007 rows=4 loops=1)
                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
                           ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.002..0.003 rows=4 loops=1)
 Planning Time: 0.651 ms
 Execution Time: 14.379 ms



EXPLAIN ANALYSE
SELECT m.name, MIN(t.selling_price) as min_sell_price, MAX(t.selling_price) as max_sell_price
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE s.id = 2
GROUP BY m.name;

QUERY PLAN  (10000 rows)
---------------------------------------------------------------------------------------------------------------------------------------------------
 HashAggregate  (cost=169.15..170.55 rows=140 width=580) (actual time=1.938..1.941 rows=1 loops=1)
   Group Key: m.name
   Batches: 1  Memory Usage: 40kB
   ->  Nested Loop  (cost=18.18..159.72 rows=1258 width=521) (actual time=0.199..1.232 rows=1258 loops=1)
         ->  Nested Loop Left Join  (cost=0.14..9.38 rows=1 width=524) (actual time=0.054..0.056 rows=1 loops=1)
               ->  Seq Scan on sessions s  (cost=0.00..1.10 rows=1 width=16) (actual time=0.006..0.007 rows=1 loops=1)
                     Filter: (id = 2)
                     Rows Removed by Filter: 7
               ->  Index Scan using movies_pkey on movies m  (cost=0.14..8.16 rows=1 width=524) (actual time=0.046..0.046 rows=1 loops=1)
                     Index Cond: (id = s.movie_id)
         ->  Bitmap Heap Scan on tickets t  (cost=18.03..137.76 rows=1258 width=13) (actual time=0.143..0.813 rows=1258 loops=1)
               Recheck Cond: (session_id = 2)
               Heap Blocks: exact=104
               ->  Bitmap Index Scan on indx_tickets_session_id  (cost=0.00..17.72 rows=1258 width=0) (actual time=0.112..0.112 rows=1258 loops=1)
                     Index Cond: (session_id = 2)
 Planning Time: 0.712 ms
 Execution Time: 2.060 ms

