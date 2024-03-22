SELECT
	*
FROM
	movies
WHERE
	now() BETWEEN "from" AND "to"
;

-- 10_000 rows
-- Seq Scan on movies  (cost=0.00..37.20 rows=272 width=32) (actual time=0.034..0.036 rows=2 loops=1)
--    Filter: ((now() >= "from") AND (now() <= "to"))
--    Rows Removed by Filter: 8
--  Planning Time: 0.304 ms
--  Execution Time: 0.057 ms
-- 
-- 10_000_000 rows
-- Seq Scan on movies  (cost=0.00..14.00 rows=150 width=32) (actual time=0.032..0.111 rows=150 loops=1)
--    Filter: ((now() >= "from") AND (now() <= "to"))
--    Rows Removed by Filter: 350
--  Planning Time: 0.519 ms
--  Execution Time: 0.153 ms
-- 
-- Что удалось улучшить:
-- Уменьшен "cost" запроса.
-- Перечень оптимизаций:
-- Добавил индекс на поле "from".
-- 
-- Результат:
-- Bitmap Heap Scan on movies  (cost=5.31..12.31 rows=150 width=32) (actual time=0.026..0.055 rows=150 loops=1)
--    Filter: ((now() >= "from") AND (now() <= "to"))
--    Heap Blocks: exact=4
--    ->  Bitmap Index Scan on movies_from_idx  (cost=0.00..5.28 rows=150 width=0) (actual time=0.017..0.018 rows=150 loops=1)
--          Index Cond: ("from" <= now())
--  Planning Time: 0.771 ms
--  Execution Time: 0.080 ms