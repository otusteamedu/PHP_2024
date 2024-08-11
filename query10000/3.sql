-- Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN ANALYSE
SELECT movies.title, movies.genre, movies.duration, sessions.start_time
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.start_time >= CURRENT_DATE
  AND sessions.start_time < CURRENT_DATE + INTERVAL '1 day';

-- Nested Loop  (cost=5.38..414.16 rows=333 width=145) (actual time=0.111..1.340 rows=333 loops=1)
--   ->  Nested Loop  (cost=5.09..280.43 rows=333 width=149) (actual time=0.103..0.878 rows=333 loops=1)
--         ->  Bitmap Heap Scan on sessions  (cost=4.81..76.30 rows=333 width=16) (actual time=0.092..0.228 rows=333 loops=1)
--               Recheck Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--               Heap Blocks: exact=64
--               ->  Bitmap Index Scan on sessions_start_time_idx  (cost=0.00..4.72 rows=333 width=0) (actual time=0.083..0.083 rows=333 loops=1)
--                     Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--         ->  Index Scan using movies_pkey on movies  (cost=0.29..0.61 rows=1 width=141) (actual time=0.001..0.001 rows=1 loops=333)
--               Index Cond: (id = sessions.movie_id)
--   ->  Index Only Scan using halls_pkey on halls  (cost=0.29..0.40 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=333)
--         Index Cond: (id = sessions.hall_id)
--         Heap Fetches: 0
-- Planning Time: 1.022 ms
-- Execution Time: 1.453 ms

CREATE INDEX ON sessions (start_time);
CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);

-- Nested Loop  (cost=5.38..414.16 rows=333 width=145) (actual time=0.068..1.508 rows=333 loops=1)
--   ->  Nested Loop  (cost=5.09..280.43 rows=333 width=149) (actual time=0.058..0.926 rows=333 loops=1)
--         ->  Bitmap Heap Scan on sessions  (cost=4.81..76.30 rows=333 width=16) (actual time=0.043..0.208 rows=333 loops=1)
--               Recheck Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--               Heap Blocks: exact=64
--               ->  Bitmap Index Scan on sessions_start_time_idx1  (cost=0.00..4.72 rows=333 width=0) (actual time=0.033..0.033 rows=333 loops=1)
--                     Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--         ->  Index Scan using movies_pkey on movies  (cost=0.29..0.61 rows=1 width=141) (actual time=0.001..0.001 rows=1 loops=333)
--               Index Cond: (id = sessions.movie_id)
--   ->  Index Only Scan using halls_pkey on halls  (cost=0.29..0.40 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=333)
--         Index Cond: (id = sessions.hall_id)
--         Heap Fetches: 0
-- Planning Time: 1.017 ms
-- Execution Time: 1.641 ms
