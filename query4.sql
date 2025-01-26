-- Поиск 3 самых прибыльных фильмов за неделю
SELECT m.title,
       SUM(t.price) as amount
FROM ticket t
    JOIN session s ON s.id = t.session_id
    JOIN movie m ON m.id = s.movie_id
WHERE t.sold_at BETWEEN (CURRENT_DATE - INTERVAL '6 days') AND CURRENT_DATE
GROUP BY m.id
ORDER BY amount DESC LIMIT 3;

-- 10_000 rows
-- Limit  (cost=624.71..624.72 rows=3 width=52) (actual time=2.922..2.923 rows=3 loops=1)
--   ->  Sort  (cost=624.71..624.89 rows=70 width=52) (actual time=2.921..2.922 rows=3 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=622.41..623.81 rows=70 width=52) (actual time=2.851..2.897 rows=73 loops=1)
--               Group Key: m.id
--               ->  Sort  (cost=622.41..622.58 rows=70 width=26) (actual time=2.846..2.850 rows=75 loops=1)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 29kB
--                     ->  Nested Loop  (cost=300.16..620.26 rows=70 width=26) (actual time=1.564..2.822 rows=75 loops=1)
--                           ->  Hash Join  (cost=299.88..587.08 rows=70 width=10) (actual time=1.556..2.665 rows=75 loops=1)
--                                 Hash Cond: (s.id = t.session_id)
--                                 ->  Seq Scan on session s  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.006..0.487 rows=10000 loops=1)
--                                 ->  Hash  (cost=299.00..299.00 rows=70 width=10) (actual time=1.530..1.530 rows=75 loops=1)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 12kB
--                                       ->  Seq Scan on ticket t  (cost=0.00..299.00 rows=70 width=10) (actual time=0.039..1.519 rows=75 loops=1)
--                                             Filter: ((sold_at <= CURRENT_DATE) AND (sold_at >= (CURRENT_DATE - '6 days'::interval)))
--                                             Rows Removed by Filter: 9925
--                           ->  Index Scan using movie_pkey on movie m  (cost=0.29..0.47 rows=1 width=20) (actual time=0.002..0.002 rows=1 loops=75)
--                                 Index Cond: (id = s.movie_id)
-- Planning Time: 0.244 ms
-- Execution Time: 2.950 ms

-- 10_000_000 rows
-- Limit  (cost=351254.96..351254.97 rows=3 width=52) (actual time=3492.360..3500.573 rows=3 loops=1)
--   ->  Sort  (cost=351254.96..351440.85 rows=74357 width=52) (actual time=3492.359..3500.571 rows=3 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=341127.89..350293.91 rows=74357 width=52) (actual time=3402.535..3485.076 rows=81195 loops=1)
--               Group Key: m.id
--               ->  Gather Merge  (cost=341127.89..348899.72 rows=61964 width=52) (actual time=3402.531..3438.033 rows=81425 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=340127.87..340747.51 rows=30982 width=52) (actual time=3382.738..3400.471 rows=27142 loops=3)
--                           Group Key: m.id
--                           ->  Sort  (cost=340127.87..340205.33 rows=30982 width=26) (actual time=3382.730..3385.040 rows=27274 loops=3)
--                                 Sort Key: m.id
--                                 Sort Method: quicksort  Memory: 2224kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 2239kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 2227kB
--                                 ->  Nested Loop  (cost=167668.46..337816.75 rows=30982 width=26) (actual time=644.700..3367.715 rows=27274 loops=3)
--                                       ->  Parallel Hash Join  (cost=167668.02..298619.24 rows=30982 width=10) (actual time=644.223..1538.593 rows=27274 loops=3)
--                                             Hash Cond: (s.id = t.session_id)
--                                             ->  Parallel Seq Scan on session s  (cost=0.00..115197.00 rows=4166700 width=8) (actual time=0.082..299.843 rows=3333333 loops=3)
--                                             ->  Parallel Hash  (cost=167280.75..167280.75 rows=30982 width=10) (actual time=643.884..643.884 rows=27274 loops=3)
--                                                   Buckets: 131072  Batches: 1  Memory Usage: 4928kB
--                                                   ->  Parallel Seq Scan on ticket t  (cost=0.00..167280.75 rows=30982 width=10) (actual time=0.067..635.298 rows=27274 loops=3)
--                                                         Filter: ((sold_at <= CURRENT_DATE) AND (sold_at >= (CURRENT_DATE - '6 days'::interval)))
--                                                         Rows Removed by Filter: 3306060
--                                       ->  Index Scan using movie_pkey on movie m  (cost=0.43..1.27 rows=1 width=20) (actual time=0.066..0.066 rows=1 loops=81821)
--                                             Index Cond: (id = s.movie_id)
-- Planning Time: 1.814 ms
-- Execution Time: 3500.937 ms

-- Что тут можно сделать, добавить индекс на колонку sold_at в таблице ticket.
-- После добавления индекса cost получения данных из таблицы ticket значительно уменьшился, а время запроса уменьшилось в 2 раза.
-- Добавление индексов на связанные колонки таблиц результата не дало, поэтому их можно не использовать.

-- Limit  (cost=262372.18..262372.19 rows=3 width=52) (actual time=1686.929..1695.358 rows=3 loops=1)
--   ->  Sort  (cost=262372.18..262558.07 rows=74356 width=52) (actual time=1686.928..1695.355 rows=3 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=252245.14..261411.15 rows=74356 width=52) (actual time=1597.429..1680.004 rows=81195 loops=1)
--               Group Key: m.id
--               ->  Gather Merge  (cost=252245.14..260016.97 rows=61964 width=52) (actual time=1597.423..1633.168 rows=81415 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=251245.12..251864.76 rows=30982 width=52) (actual time=1577.246..1595.011 rows=27138 loops=3)
--                           Group Key: m.id
--                           ->  Sort  (cost=251245.12..251322.57 rows=30982 width=26) (actual time=1577.239..1579.534 rows=27274 loops=3)
--                                 Sort Key: m.id
--                                 Sort Method: quicksort  Memory: 2234kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 2219kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 2237kB
--                                 ->  Nested Loop  (cost=78786.12..248933.99 rows=30982 width=26) (actual time=159.869..1566.763 rows=27274 loops=3)
--                                       ->  Parallel Hash Join  (cost=78785.69..209736.45 rows=30982 width=10) (actual time=159.752..1021.967 rows=27274 loops=3)
--                                             Hash Cond: (s.id = t.session_id)
--                                             ->  Parallel Seq Scan on session s  (cost=0.00..115196.67 rows=4166667 width=8) (actual time=0.059..302.701 rows=3333333 loops=3)
--                                             ->  Parallel Hash  (cost=78398.41..78398.41 rows=30982 width=10) (actual time=159.410..159.411 rows=27274 loops=3)
--                                                   Buckets: 131072  Batches: 1  Memory Usage: 4896kB
--                                                   ->  Parallel Bitmap Heap Scan on ticket t  (cost=1578.59..78398.41 rows=30982 width=10) (actual time=5.297..152.288 rows=27274 loops=3)
--                                                         Recheck Cond: ((sold_at >= (CURRENT_DATE - '6 days'::interval)) AND (sold_at <= CURRENT_DATE))
--                                                         Heap Blocks: exact=20860
--                                                         ->  Bitmap Index Scan on handle_ticket_sold_at  (cost=0.00..1560.00 rows=74356 width=0) (actual time=9.708..9.708 rows=81821 loops=1)
--                                                               Index Cond: ((sold_at >= (CURRENT_DATE - '6 days'::interval)) AND (sold_at <= CURRENT_DATE))
--                                       ->  Index Scan using movie_pkey on movie m  (cost=0.43..1.27 rows=1 width=20) (actual time=0.019..0.019 rows=1 loops=81821)
--                                             Index Cond: (id = s.movie_id)
-- Planning Time: 0.490 ms
-- Execution Time: 1695.650 ms
