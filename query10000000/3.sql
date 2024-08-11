-- Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN ANALYSE
SELECT movies.title, movies.genre, movies.duration, sessions.start_time
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.start_time >= CURRENT_DATE
  AND sessions.start_time < CURRENT_DATE + INTERVAL '1 day';

-- Gather  (cost=1000.87..371165.69 rows=332000 width=148) (actual time=8.079..4287.722 rows=333334 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Nested Loop  (cost=0.87..336965.69 rows=138333 width=148) (actual time=7.442..4221.036 rows=111111 loops=3)
--         ->  Nested Loop  (cost=0.43..261802.08 rows=138333 width=152) (actual time=7.255..1712.083 rows=111111 loops=3)
--               ->  Parallel Seq Scan on sessions  (cost=0.00..157445.00 rows=138333 width=16) (actual time=7.198..1026.552 rows=111111 loops=3)
--                     Filter: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                     Rows Removed by Filter: 3222222
--               ->  Index Scan using movies_pkey on movies  (cost=0.43..0.75 rows=1 width=144) (actual time=0.005..0.005 rows=1 loops=333334)
--                     Index Cond: (id = sessions.movie_id)
--         ->  Index Only Scan using halls_pkey on halls  (cost=0.43..0.54 rows=1 width=4) (actual time=0.022..0.022 rows=1 loops=333334)
--               Index Cond: (id = sessions.hall_id)
--               Heap Fetches: 0
-- Planning Time: 3.713 ms
-- JIT:
--   Functions: 33
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.193 ms, Inlining 0.000 ms, Optimization 0.937 ms, Emission 20.631 ms, Total 23.761 ms"
-- Execution Time: 4405.182 ms



CREATE INDEX ON sessions (start_time);
CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);

-- Gather  (cost=4714.51..284241.83 rows=332000 width=148) (actual time=42.692..2650.544 rows=333334 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Nested Loop  (cost=3714.51..250041.83 rows=138333 width=148) (actual time=33.709..2543.992 rows=111111 loops=3)
--         ->  Nested Loop  (cost=3714.08..174878.22 rows=138333 width=152) (actual time=32.997..1696.557 rows=111111 loops=3)
--               ->  Parallel Bitmap Heap Scan on sessions  (cost=3713.64..70521.14 rows=138333 width=16) (actual time=26.837..517.525 rows=111111 loops=3)
--                     Recheck Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                     Heap Blocks: exact=19962
--                     ->  Bitmap Index Scan on sessions_start_time_idx  (cost=0.00..3630.64 rows=332000 width=0) (actual time=31.627..31.627 rows=333334 loops=1)
--                           Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--               ->  Index Scan using movies_pkey on movies  (cost=0.43..0.75 rows=1 width=144) (actual time=0.010..0.010 rows=1 loops=333334)
--                     Index Cond: (id = sessions.movie_id)
--         ->  Index Only Scan using halls_pkey on halls  (cost=0.43..0.54 rows=1 width=4) (actual time=0.007..0.007 rows=1 loops=333334)
--               Index Cond: (id = sessions.hall_id)
--               Heap Fetches: 0
-- Planning Time: 5.379 ms
-- JIT:
--   Functions: 39
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.132 ms, Inlining 0.000 ms, Optimization 1.177 ms, Emission 23.133 ms, Total 26.442 ms"
-- Execution Time: 2823.385 ms


