-- Формирование афиши (фильмы, которые показывают сегодня)
SELECT s.id
FROM session s
WHERE s.start_time::date = CURRENT_DATE;

-- 10_000 rows
-- Seq Scan on session s  (cost=0.00..249.00 rows=50 width=4) (actual time=0.022..1.145 rows=15 loops=1)
--   Filter: ((start_time)::date = CURRENT_DATE)
--   Rows Removed by Filter: 9985
-- Planning Time: 0.064 ms
-- Execution Time: 1.154 ms

-- 10_000_000 rows
-- Gather  (cost=1000.00..152447.25 rows=50000 width=4) (actual time=0.321..538.978 rows=13857 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on session s  (cost=0.00..146447.25 rows=20833 width=4) (actual time=0.122..515.166 rows=4619 loops=3)
--         Filter: ((start_time)::date = CURRENT_DATE)
--         Rows Removed by Filter: 3328714
-- Planning Time: 0.260 ms
-- Execution Time: 539.572 ms

-- Что тут можно сделать, добавить индекс на колонку start_time в таблице session с применением преобразования к дате.
-- После добавления индекса cost значительно уменьшился и время выполнения запроса стало меньше.

-- Bitmap Heap Scan on session s  (cost=559.94..70947.18 rows=50000 width=4) (actual time=2.612..81.175 rows=13857 loops=1)
--   Recheck Cond: ((start_time)::date = CURRENT_DATE)
--   Heap Blocks: exact=12624
--   ->  Bitmap Index Scan on handle_session_start_time  (cost=0.00..547.44 rows=50000 width=0) (actual time=1.289..1.290 rows=13857 loops=1)
--         Index Cond: ((start_time)::date = CURRENT_DATE)
-- Planning Time: 0.231 ms
-- Execution Time: 81.695 ms
