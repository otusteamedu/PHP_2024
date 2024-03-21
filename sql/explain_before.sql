EXPLAIN ANALYSE SELECT * FROM sessions
                WHERE movie_id = 1;

Seq Scan on sessions  (cost=0.00..180.00 rows=3408 width=24) (actual time=0.008..0.908 rows=3408 loops=1)
   Filter: (movie_id = 1)
   Rows Removed by Filter: 6592
 Planning Time: 0.047 ms
 Execution Time: 1.055 ms

EXPLAIN ANALYSE SELECT * FROM "order"
WHERE user_id = 1;

Seq Scan on "order"  (cost=0.00..538.00 rows=10016 width=16) (actual time=0.007..2.035 rows=10016 loops=1)
   Filter: (user_id = 1)
   Rows Removed by Filter: 19984
 Planning Time: 0.035 ms
 Execution Time: 2.370 ms

EXPLAIN ANALYSE SELECT * FROM "order"
                                  JOIN "user" u on u.id = "order".user_id
                WHERE u.email = 'mail1@mail.ru';

Hash Join  (cost=219.05..760.83 rows=3 width=793) (actual time=0.825..0.827 rows=0 loops=1)
   Hash Cond: ("order".user_id = u.id)
   ->  Seq Scan on "order"  (cost=0.00..463.00 rows=30000 width=16) (actual time=0.004..0.004 rows=1 loops=1)
   ->  Hash  (cost=219.04..219.04 rows=1 width=777) (actual time=0.818..0.819 rows=0 loops=1)
         Buckets: 1024  Batches: 1  Memory Usage: 8kB
         ->  Seq Scan on "user" u  (cost=0.00..219.04 rows=1 width=777) (actual time=0.818..0.818 rows=0 loops=1)
               Filter: ((email)::text = 'mail1@mail.ru'::text)
               Rows Removed by Filter: 10003
 Planning Time: 0.125 ms
 Execution Time: 0.842 ms

EXPLAIN ANALYSE SELECT movie_id, COUNT(o.id) FROM sessions
                                                      JOIN "order" o on sessions.id = o.session_id
WHERE movie_id=1
                GROUP BY movie_id;

GroupAggregate  (cost=222.60..789.95 rows=1 width=12) (actual time=20.605..20.608 rows=1 loops=1)
   ->  Hash Join  (cost=222.60..764.38 rows=10224 width=8) (actual time=2.076..19.669 rows=10356 loops=1)
         Hash Cond: (o.session_id = sessions.id)
         ->  Seq Scan on "order" o  (cost=0.00..463.00 rows=30000 width=8) (actual time=0.005..11.025 rows=30000 loops=1)
         ->  Hash  (cost=180.00..180.00 rows=3408 width=8) (actual time=2.059..2.061 rows=3408 loops=1)
               Buckets: 4096  Batches: 1  Memory Usage: 166kB
               ->  Seq Scan on sessions  (cost=0.00..180.00 rows=3408 width=8) (actual time=0.006..1.448 rows=3408 loops=1)
                     Filter: (movie_id = 1)
                     Rows Removed by Filter: 6592
 Planning Time: 1.929 ms
 Execution Time: 20.639 ms


