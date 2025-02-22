SELECT
	COUNT(*)
FROM
	sales
WHERE
	date BETWEEN CURRENT_DATE - interval '6 days' AND CURRENT_DATE
;

-- 10_000 rows
 -- Aggregate  (cost=181.02..181.03 rows=1 width=8) (actual time=1.533..1.534 rows=1 loops=1)
 --   ->  Seq Scan on sales  (cost=0.00..180.00 rows=407 width=0) (actual time=0.008..1.173 rows=407 loops=1)
 --         Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
 --         Rows Removed by Filter: 5593
 -- Planning Time: 0.143 ms
 -- Execution Time: 1.565 ms
-- 
-- 10_000_000 rows
 -- Finalize Aggregate  (cost=59825.52..59825.53 rows=1 width=8) (actual time=802.349..818.868 rows=1 loops=1)
 --   ->  Gather  (cost=59825.31..59825.51 rows=2 width=8) (actual time=802.342..818.863 rows=3 loops=1)
 --         Workers Planned: 2
 --         Workers Launched: 2
 --         ->  Partial Aggregate  (cost=58825.31..58825.32 rows=1 width=8) (actual time=798.250..798.251 rows=1 loops=3)
 --               ->  Parallel Seq Scan on sales  (cost=0.00..58548.50 rows=110722 width=0) (actual time=0.030..792.359 rows=81686 loops=3)
 --                     Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
 --                     Rows Removed by Filter: 1084980
 -- Planning Time: 0.718 ms
 -- Execution Time: 819.006 ms
-- 
-- Что удалось улучшить:
-- Уменьшен "cost" запроса.
-- Перечень оптимизаций:
-- Добавил индекс на поле "date". При наложении условии вместо Seq Scan стал использоваться Index Only Scan
-- 
-- Результат:
-- Finalize Aggregate  (cost=5946.01..5946.02 rows=1 width=8) (actual time=23.356..26.507 rows=1 loops=1)
--    ->  Gather  (cost=5945.79..5946.00 rows=2 width=8) (actual time=19.980..26.487 rows=3 loops=1)
--          Workers Planned: 2
--          Workers Launched: 2
--          ->  Partial Aggregate  (cost=4945.79..4945.80 rows=1 width=8) (actual time=14.243..14.245 rows=1 loops=3)
--                ->  Parallel Index Only Scan using sales_date_idx on sales  (cost=0.44..4668.99 rows=110722 width=0) (actual time=0.446..10.744 rows=81686 loops=3)
--                      Index Cond: ((date >= (CURRENT_DATE - '6 days'::interval)) AND (date <= CURRENT_DATE))
--                      Heap Fetches: 0
--  Planning Time: 20.930 ms
--  Execution Time: 26.700 ms