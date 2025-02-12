-- выбор всех фильмов за сегодня
-- Nested Loop  (cost=0.30..281.46 rows=50 width=26) (actual time=0.049..5.702 rows=10000 loops=1)
--   ->  Seq Scan on sessions s  (cost=0.00..269.00 rows=50 width=24) (actual time=0.016..1.910 rows=10000 loops=1)
--         Filter: ((start_time)::date = CURRENT_DATE)
--   ->  Memoize  (cost=0.30..5.67 rows=1 width=14) (actual time=0.000..0.000 rows=1 loops=10000)
--         Cache Key: s.movie_id
--         Cache Mode: logical
--         Hits: 9999  Misses: 1  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..5.66 rows=1 width=14) (actual time=0.026..0.026 rows=1 loops=1)
--               Index Cond: (id = s.movie_id)
-- Planning Time: 0.482 ms
-- Execution Time: 6.276 ms

-- подсчёт проданных билетов за неделю
--
-- Aggregate  (cost=291.97..291.98 rows=1 width=8) (actual time=0.006..0.007 rows=1 loops=1)
--   ->  Nested Loop  (cost=0.29..290.83 rows=453 width=4) (actual time=0.004..0.004 rows=0 loops=1)
--         ->  Seq Scan on tickets t  (cost=0.00..33.80 rows=453 width=12) (actual time=0.003..0.004 rows=0 loops=1)
--               Filter: (purchase_time >= (CURRENT_DATE - '7 days'::interval))
--         ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.29..0.57 rows=1 width=4) (never executed)
--               Index Cond: (id = t.session_id)
--               Heap Fetches: 0
-- Planning Time: 0.281 ms
-- Execution Time: 0.027 ms

-- формирование афиши
--
-- Nested Loop  (cost=0.30..281.46 rows=50 width=26) (actual time=0.023..4.349 rows=10000 loops=1)
--   ->  Seq Scan on sessions s  (cost=0.00..269.00 rows=50 width=24) (actual time=0.009..1.387 rows=10000 loops=1)
--         Filter: ((start_time)::date = CURRENT_DATE)
--   ->  Memoize  (cost=0.30..5.67 rows=1 width=14) (actual time=0.000..0.000 rows=1 loops=10000)
--         Cache Key: s.movie_id
--         Cache Mode: logical
--         Hits: 9999  Misses: 1  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..5.66 rows=1 width=14) (actual time=0.010..0.010 rows=1 loops=1)
--               Index Cond: (id = s.movie_id)
-- Planning Time: 0.106 ms
-- Execution Time: 4.709 ms

-- 3 самых прибыльных фильмов за неделю
-- Limit  (cost=378.66..378.66 rows=3 width=22) (actual time=0.008..0.010 rows=0 loops=1)
--   ->  Sort  (cost=378.66..379.79 rows=453 width=22) (actual time=0.008..0.009 rows=0 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: quicksort  Memory: 25kB
--         ->  HashAggregate  (cost=368.27..372.80 rows=453 width=22) (actual time=0.005..0.006 rows=0 loops=1)
--               Group Key: m.id
--               Batches: 1  Memory Usage: 37kB
--               ->  Nested Loop  (cost=319.30..366.01 rows=453 width=18) (actual time=0.003..0.004 rows=0 loops=1)
--                     ->  Hash Join  (cost=319.00..353.99 rows=453 width=12) (actual time=0.003..0.004 rows=0 loops=1)
--                           Hash Cond: (t.session_id = s.id)
--                           ->  Seq Scan on tickets t  (cost=0.00..33.80 rows=453 width=12) (actual time=0.002..0.003 rows=0 loops=1)
--                                 Filter: (purchase_time >= (CURRENT_DATE - '7 days'::interval))
--                           ->  Hash  (cost=194.00..194.00 rows=10000 width=12) (never executed)
--                                 ->  Seq Scan on sessions s  (cost=0.00..194.00 rows=10000 width=12) (never executed)
--                     ->  Memoize  (cost=0.30..0.36 rows=1 width=14) (never executed)
--                           Cache Key: s.movie_id
--                           Cache Mode: logical
--                           ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.35 rows=1 width=14) (never executed)
--                                 Index Cond: (id = s.movie_id)
-- Planning Time: 0.198 ms
-- Execution Time: 0.052 ms

-- схема зала

-- Nested Loop  (cost=0.16..56.38 rows=1 width=40) (actual time=0.003..0.004 rows=0 loops=1)
--   ->  Seq Scan on tickets t  (cost=0.00..27.00 rows=7 width=12) (actual time=0.003..0.003 rows=0 loops=1)
--         Filter: (session_id = 1)
--   ->  Memoize  (cost=0.16..4.18 rows=1 width=12) (never executed)
--         Cache Key: t.seat_id
--         Cache Mode: logical
--         ->  Index Scan using seats_pkey on seats s  (cost=0.15..4.17 rows=1 width=12) (never executed)
--               Index Cond: (id = t.seat_id)
--               Filter: (hall_id = 1)
-- Planning Time: 0.217 ms
-- Execution Time: 0.022 ms

-- диапазон на конкретный сеанс
--
-- Aggregate  (cost=27.04..27.05 rows=1 width=8) (actual time=0.004..0.004 rows=1 loops=1)
--   ->  Seq Scan on tickets t  (cost=0.00..27.00 rows=7 width=4) (actual time=0.001..0.001 rows=0 loops=1)
--         Filter: (session_id = 1)
-- Planning Time: 0.067 ms
-- Execution Time: 0.017 ms



