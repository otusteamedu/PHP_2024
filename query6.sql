-- Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
SELECT MIN(p.price) min_price,
       MAX(p.price) max_price
FROM session s
         JOIN price p ON s.id = p.session_id
WHERE s.id = 1
GROUP BY s.id;

-- 10_000 rows
-- GroupAggregate  (cost=0.29..193.34 rows=1 width=68) (actual time=0.692..0.693 rows=1 loops=1)
--   ->  Nested Loop  (cost=0.29..193.32 rows=2 width=10) (actual time=0.271..0.689 rows=1 loops=1)
--         ->  Index Only Scan using session_pkey on session s  (cost=0.29..4.30 rows=1 width=4) (actual time=0.014..0.015 rows=1 loops=1)
--               Index Cond: (id = 1)
--               Heap Fetches: 0
--         ->  Seq Scan on price p  (cost=0.00..189.00 rows=2 width=10) (actual time=0.256..0.673 rows=1 loops=1)
--               Filter: (session_id = 1)
--               Rows Removed by Filter: 9999
-- Planning Time: 0.105 ms
-- Execution Time: 0.712 ms

-- 10_000_000 rows
-- GroupAggregate  (cost=1000.43..116782.34 rows=1 width=68) (actual time=859.550..862.799 rows=1 loops=1)
--   ->  Gather  (cost=1000.43..116782.32 rows=2 width=10) (actual time=859.424..862.792 rows=1 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Nested Loop  (cost=0.43..115782.12 rows=1 width=10) (actual time=787.140..842.094 rows=0 loops=3)
--               ->  Parallel Seq Scan on price p  (cost=0.00..115777.66 rows=1 width=10) (actual time=786.965..841.918 rows=0 loops=3)
--                     Filter: (session_id = 1)
--                     Rows Removed by Filter: 3333333
--               ->  Index Only Scan using session_pkey on session s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.518..0.520 rows=1 loops=1)
--                     Index Cond: (id = 1)
--                     Heap Fetches: 0
-- Planning Time: 0.469 ms
-- Execution Time: 862.902 ms

-- Что тут можно сделать, добавить индекс на колонку session_id таблицы price.
-- После добавления индекса cost джойна значительно уменьшился, чем значительно сократило время запроса.

-- GroupAggregate  (cost=0.87..16.96 rows=1 width=68) (actual time=0.026..0.027 rows=1 loops=1)
--   ->  Nested Loop  (cost=0.87..16.94 rows=2 width=10) (actual time=0.022..0.023 rows=1 loops=1)
--         ->  Index Only Scan using session_pkey on session s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.015..0.015 rows=1 loops=1)
--               Index Cond: (id = 1)
--               Heap Fetches: 0
--         ->  Index Scan using idx_price_session_id on price p  (cost=0.43..12.47 rows=2 width=10) (actual time=0.006..0.007 rows=1 loops=1)
--               Index Cond: (session_id = 1)
-- Planning Time: 0.110 ms
-- Execution Time: 0.049 ms
