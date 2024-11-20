EXPLAIN ANALYSE SELECT * FROM "order"
                                  JOIN "user" u on u.id = "order".user_id
                WHERE u.email = 'mail1@mail.ru';

Hash Join  (cost=8.31..550.10 rows=3 width=793) (actual time=0.359..0.360 rows=0 loops=1)
   Hash Cond: ("order".user_id = u.id)
   ->  Seq Scan on "order"  (cost=0.00..463.00 rows=30000 width=16) (actual time=0.005..0.005 rows=1 loops=1)
   ->  Hash  (cost=8.30..8.30 rows=1 width=777) (actual time=0.350..0.351 rows=0 loops=1)
         Buckets: 1024  Batches: 1  Memory Usage: 8kB
         ->  Index Scan using users_email_index on "user" u  (cost=0.29..8.30 rows=1 width=777) (actual time=0.350..0.350 rows=0 loops=1)
               Index Cond: ((email)::text = 'mail1@mail.ru'::text)
 Planning Time: 2.867 ms
 Execution Time: 0.381 ms

EXPLAIN ANALYSE SELECT movie_id, COUNT(o.id) FROM sessions
                                                      JOIN "order" o on sessions.id = o.session_id
                WHERE movie_id=1
                GROUP BY movie_id;

 GroupAggregate  (cost=182.90..750.25 rows=1 width=12) (actual time=9.560..9.562 rows=1 loops=1)
   ->  Hash Join  (cost=182.90..724.68 rows=10224 width=8) (actual time=1.637..8.757 rows=10356 loops=1)
         Hash Cond: (o.session_id = sessions.id)
         ->  Seq Scan on "order" o  (cost=0.00..463.00 rows=30000 width=8) (actual time=0.004..2.073 rows=30000 loops=1)
         ->  Hash  (cost=140.30..140.30 rows=3408 width=8) (actual time=1.627..1.627 rows=3408 loops=1)
               Buckets: 4096  Batches: 1  Memory Usage: 166kB
               ->  Bitmap Heap Scan on sessions  (cost=42.70..140.30 rows=3408 width=8) (actual time=0.700..1.195 rows=3408 loops=1)
                     Recheck Cond: (movie_id = 1)
                     Heap Blocks: exact=55
                     ->  Bitmap Index Scan on session_movie_index  (cost=0.00..41.84 rows=3408 width=0) (actual time=0.688..0.688 rows=3408 loops=1)
                           Index Cond: (movie_id = 1)
 Planning Time: 2.546 ms
 Execution Time: 9.596 ms