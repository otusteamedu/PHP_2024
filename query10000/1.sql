-- Выбор всех фильмов на сегодня

EXPLAIN ANALYSE
SELECT movies.title
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
WHERE DATE(sessions.start_time) = CURRENT_DATE;

-- Nested Loop  (cost=0.29..324.53 rows=50 width=15) (actual time=0.031..3.201 rows=333 loops=1)
--   ->  Seq Scan on sessions  (cost=0.00..239.00 rows=50 width=4) (actual time=0.014..1.895 rows=333 loops=1)
--         Filter: (date(start_time) = CURRENT_DATE)
--         Rows Removed by Filter: 9667
--   ->  Index Scan using movies_pkey on movies  (cost=0.29..1.71 rows=1 width=19) (actual time=0.003..0.003 rows=1 loops=333)
--         Index Cond: (id = sessions.movie_id)
-- Planning Time: 0.301 ms
-- Execution Time: 3.357 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (start_time);

-- Nested Loop  (cost=0.29..324.53 rows=50 width=15) (actual time=0.021..1.587 rows=333 loops=1)
--   ->  Seq Scan on sessions  (cost=0.00..239.00 rows=50 width=4) (actual time=0.010..0.980 rows=333 loops=1)
--         Filter: (date(start_time) = CURRENT_DATE)
--         Rows Removed by Filter: 9667
--   ->  Index Scan using movies_pkey on movies  (cost=0.29..1.71 rows=1 width=19) (actual time=0.001..0.001 rows=1 loops=333)
--         Index Cond: (id = sessions.movie_id)
-- Planning Time: 0.210 ms
-- Execution Time: 1.668 ms
