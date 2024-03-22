SELECT
	price
FROM
	prices
WHERE
	movie_id IN (2, 3, 4, 5, 6, 7, 100)
	AND CURRENT_DATE > date_from
	AND type = 'first'
ORDER BY
	price
;

-- 10_000 rows
-- Sort  (cost=3.95..3.99 rows=16 width=6) (actual time=0.163..0.165 rows=17 loops=1)
--    Sort Key: price
--    Sort Method: quicksort  Memory: 25kB
--    ->  Seq Scan on prices  (cost=0.00..3.63 rows=16 width=6) (actual time=0.015..0.024 rows=17 loops=1)
--          Filter: (((type)::text = 'first'::text) AND (CURRENT_DATE > date_from) AND (movie_id = ANY ('{2,3,4,5,6,7,100}'::bigint[])))
--          Rows Removed by Filter: 83
--  Planning Time: 0.359 ms
--  Execution Time: 0.177 ms
-- 
-- 10_000_000 rows
-- Sort  (cost=107.43..107.55 rows=46 width=6) (actual time=53.200..53.206 rows=45 loops=1)
--    Sort Key: price
--    Sort Method: quicksort  Memory: 25kB
--    ->  Bitmap Heap Scan on prices  (cost=30.62..106.16 rows=46 width=6) (actual time=8.726..52.713 rows=45 loops=1)
--          Recheck Cond: ((movie_id = ANY ('{2,3,4,5,6,7,100}'::bigint[])) AND ((type)::text = 'first'::text))
--          Filter: (CURRENT_DATE > date_from)
--          Heap Blocks: exact=36
--          ->  Bitmap Index Scan on prices_unique  (cost=0.00..30.61 rows=46 width=0) (actual time=6.346..6.347 rows=45 loops=1)
--                Index Cond: ((movie_id = ANY ('{2,3,4,5,6,7,100}'::bigint[])) AND ((type)::text = 'first'::text) AND (date_from < CURRENT_DATE))
--  Planning Time: 5.672 ms
--  Execution Time: 53.285 ms
-- 
-- Что удалось улучшить:
-- Ничего
-- Перечень оптимизаций:
-- Так как у таблицы уже был уникальный по 3-м полям индекс, то планировщик использовал его? и потому cost запроса изначально был невысок.