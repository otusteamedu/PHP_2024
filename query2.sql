-- Подсчёт проданных билетов за неделю
SELECT COUNT(1)
FROM ticket t
WHERE t.sold_at BETWEEN (CURRENT_DATE - INTERVAL '6 days') AND CURRENT_DATE;

-- 10_000 rows
-- Aggregate  (cost=299.18..299.19 rows=1 width=8) (actual time=1.512..1.513 rows=1 loops=1)
--   ->  Seq Scan on ticket t  (cost=0.00..299.00 rows=70 width=0) (actual time=0.044..1.506 rows=75 loops=1)
--         Filter: ((sold_at <= CURRENT_DATE) AND (sold_at >= (CURRENT_DATE - '6 days'::interval)))
--         Rows Removed by Filter: 9925
-- Planning Time: 0.077 ms
-- Execution Time: 1.526 ms

-- 10_000_000 rows
-- Finalize Aggregate  (cost=168358.42..168358.43 rows=1 width=8) (actual time=652.627..656.240 rows=1 loops=1)
--   ->  Gather  (cost=168358.20..168358.42 rows=2 width=8) (actual time=652.507..656.232 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=167358.20..167358.21 rows=1 width=8) (actual time=635.222..635.222 rows=1 loops=3)
--               ->  Parallel Seq Scan on ticket t  (cost=0.00..167280.75 rows=30982 width=0) (actual time=0.067..633.312 rows=27274 loops=3)
--                     Filter: ((sold_at <= CURRENT_DATE) AND (sold_at >= (CURRENT_DATE - '6 days'::interval)))
--                     Rows Removed by Filter: 3306060
-- Planning Time: 0.286 ms
-- Execution Time: 656.323 ms

-- Что тут можно сделать, добавить индекс на колонку sold_at в таблице ticket
-- После добавления индекса cost значительно уменьшился и время выполнения запроса стало меньше.

-- Aggregate  (cost=2489.45..2489.46 rows=1 width=8) (actual time=17.858..17.858 rows=1 loops=1)
--   ->  Index Only Scan using handle_ticket_sold_at on ticket t  (cost=0.44..2303.56 rows=74356 width=0) (actual time=0.064..14.582 rows=81821 loops=1)
--         Index Cond: ((sold_at >= (CURRENT_DATE - '6 days'::interval)) AND (sold_at <= CURRENT_DATE))
--         Heap Fetches: 0
-- Planning Time: 0.295 ms
-- Execution Time: 17.875 ms
