-- Выбор всех фильмов на сегодня

EXPLAIN ANALYSE
SELECT movies.title
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
WHERE DATE(sessions.start_time) = CURRENT_DATE;

-- Gather  (cost=1000.43..180483.23 rows=50000 width=18) (actual time=4.634..3652.255 rows=333333 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Nested Loop  (cost=0.43..174483.23 rows=20833 width=18) (actual time=6.502..3571.688 rows=111111 loops=3)
--         ->  Parallel Seq Scan on sessions  (cost=0.00..136611.67 rows=20833 width=4) (actual time=6.131..500.130 rows=111111 loops=3)
--               Filter: (date(start_time) = CURRENT_DATE)
--               Rows Removed by Filter: 3222222
--         ->  Index Scan using movies_pkey on movies  (cost=0.43..1.82 rows=1 width=22) (actual time=0.027..0.027 rows=1 loops=333333)
--               Index Cond: (id = sessions.movie_id)
-- Planning Time: 2.393 ms
-- JIT:
--   Functions: 21
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 1.813 ms, Inlining 0.000 ms, Optimization 0.823 ms, Emission 17.513 ms, Total 20.149 ms"
-- Execution Time: 3718.688 ms


CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (start_time);

-- Gather  (cost=1000.43..180483.23 rows=50000 width=18) (actual time=5.236..1955.501 rows=333333 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Nested Loop  (cost=0.43..174483.23 rows=20833 width=18) (actual time=5.197..1791.777 rows=111111 loops=3)
--         ->  Parallel Seq Scan on sessions  (cost=0.00..136611.67 rows=20833 width=4) (actual time=5.145..983.579 rows=111111 loops=3)
--               Filter: (date(start_time) = CURRENT_DATE)
--               Rows Removed by Filter: 3222222
--         ->  Index Scan using movies_pkey on movies  (cost=0.43..1.82 rows=1 width=22) (actual time=0.005..0.005 rows=1 loops=333333)
--               Index Cond: (id = sessions.movie_id)
-- Planning Time: 0.538 ms
-- JIT:
--   Functions: 21
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 1.274 ms, Inlining 0.000 ms, Optimization 0.950 ms, Emission 14.422 ms, Total 16.646 ms"
-- Execution Time: 2070.834 ms
