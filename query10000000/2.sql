-- Подсчёт проданных билетов за неделю

EXPLAIN ANALYSE
SELECT COUNT(*)
FROM tickets
WHERE tickets.date >= CURRENT_DATE - INTERVAL '7 days';

-- Finalize Aggregate  (cost=6844.34..6844.35 rows=1 width=8) (actual time=58.616..61.172 rows=1 loops=1)
--   ->  Gather  (cost=6844.13..6844.34 rows=2 width=8) (actual time=58.247..61.163 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=5844.13..5844.14 rows=1 width=8) (actual time=47.149..47.151 rows=1 loops=3)
--               ->  Parallel Index Only Scan using tickets_date_idx2 on tickets  (cost=0.44..5396.06 rows=179226 width=0) (actual time=0.025..23.206 rows=132422 loops=3)
--                     Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                     Heap Fetches: 0
-- Planning Time: 0.079 ms
-- Execution Time: 61.227 ms


CREATE INDEX ON tickets (date);

-- Finalize Aggregate  (cost=6844.29..6844.30 rows=1 width=8) (actual time=109.288..111.836 rows=1 loops=1)
--   ->  Gather  (cost=6844.08..6844.29 rows=2 width=8) (actual time=108.977..111.828 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=5844.08..5844.09 rows=1 width=8) (actual time=93.786..93.787 rows=1 loops=3)
--               ->  Parallel Index Only Scan using tickets_date_idx2 on tickets  (cost=0.44..5396.02 rows=179224 width=0) (actual time=0.023..37.090 rows=132422 loops=3)
--                     Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                     Heap Fetches: 0
-- Planning Time: 0.234 ms
-- Execution Time: 111.887 ms


