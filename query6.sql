SELECT
	min(p.price) min_price,
	max(p.price) max_price
FROM
	shows s
	JOIN prices p ON s.movie_id = p.movie_id
WHERE
	s.id = 5
GROUP BY
	s.id
;

-- 10_000 rows
-- GroupAggregate  (cost=8.30..10.74 rows=1 width=72) (actual time=0.087..0.089 rows=1 loops=1)
--    ->  Hash Join  (cost=8.30..10.68 rows=10 width=15) (actual time=0.064..0.078 rows=13 loops=1)
--          Hash Cond: (p.movie_id = s.movie_id)
--          ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=15) (actual time=0.010..0.016 rows=100 loops=1)
--          ->  Hash  (cost=8.29..8.29 rows=1 width=16) (actual time=0.037..0.037 rows=1 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Index Scan using shows_pk on shows s  (cost=0.27..8.29 rows=1 width=16) (actual time=0.032..0.033 rows=1 loops=1)
--                      Index Cond: (id = 5)
--  Planning Time: 0.259 ms
--  Execution Time: 0.129 ms
-- 
-- 10_000_000 rows
-- GroupAggregate  (cost=4.86..60.44 rows=1 width=72) (actual time=16.292..16.295 rows=1 loops=1)
--   ->  Nested Loop  (cost=4.86..60.33 rows=20 width=14) (actual time=3.680..16.221 rows=18 loops=1)
--         ->  Index Scan using shows_pk on shows s  (cost=0.42..8.44 rows=1 width=16) (actual time=2.002..2.008 rows=1 loops=1)
--               Index Cond: (id = 5)
--         ->  Bitmap Heap Scan on prices p  (cost=4.44..51.69 rows=20 width=14) (actual time=1.663..14.156 rows=18 loops=1)
--               Recheck Cond: (movie_id = s.movie_id)
--               Heap Blocks: exact=16
--               ->  Bitmap Index Scan on prices_unique  (cost=0.00..4.44 rows=20 width=0) (actual time=0.871..0.872 rows=18 loops=1)
--                     Index Cond: (movie_id = s.movie_id)
-- Planning Time: 20.982 ms
-- Execution Time: 16.362 ms
-- 
-- Что удалось улучшить:
-- Ничего.
-- Перечень оптимизаций:
-- В целом, запрос оптимален, так как уже существует индекс, который используется планировщиком.