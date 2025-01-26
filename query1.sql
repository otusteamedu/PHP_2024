-- Выбор всех фильмов на сегодня
SELECT m.title
FROM movie m
WHERE m.release_date = CURRENT_DATE;

-- 10_000 rows
-- Seq Scan on movie m  (cost=0.00..549.00 rows=19 width=16) (actual time=0.051..1.389 rows=19 loops=1)
--   Filter: (release_date = CURRENT_DATE)
--   Rows Removed by Filter: 9981
-- Planning Time: 0.066 ms
-- Execution Time: 1.398 ms

-- 10_000_000 rows
-- Gather  (cost=1000.00..463432.41 rows=13628 width=16) (actual time=1.415..5260.647 rows=13581 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on movie m  (cost=0.00..461069.61 rows=5678 width=16) (actual time=1.024..5237.049 rows=4527 loops=3)
--         Filter: (release_date = CURRENT_DATE)
--         Rows Removed by Filter: 3328806
-- Planning Time: 0.680 ms
-- Execution Time: 5261.598 ms

-- Что тут можно сделать, добавить индекс на колонку release_date в таблице movie
-- После добавления индекса cost значительно уменьшился и время выполнения запроса стало меньше.

-- Bitmap Heap Scan on movie m  (cost=154.12..46613.45 rows=13637 width=16) (actual time=2.544..8.954 rows=13581 loops=1)
--   Recheck Cond: (release_date = CURRENT_DATE)
--   Heap Blocks: exact=13372
--   ->  Bitmap Index Scan on handle_movie_release_date  (cost=0.00..150.71 rows=13637 width=0) (actual time=1.173..1.173 rows=13581 loops=1)
--         Index Cond: (release_date = CURRENT_DATE)
-- Planning Time: 0.077 ms
-- Execution Time: 9.381 ms
