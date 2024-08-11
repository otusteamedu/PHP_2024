-- Подсчёт проданных билетов за неделю

EXPLAIN ANALYSE
SELECT COUNT(*)
FROM tickets
WHERE tickets.date >= CURRENT_DATE - INTERVAL '7 days';

-- Aggregate  (cost=270.31..270.32 rows=1 width=8) (actual time=1.735..1.736 rows=1 loops=1)
--   ->  Seq Scan on tickets  (cost=0.00..269.00 rows=524 width=0) (actual time=0.008..1.651 rows=482 loops=1)
--         Filter: (date >= (CURRENT_DATE - '7 days'::interval))
--         Rows Removed by Filter: 9518
-- Planning Time: 0.055 ms
-- Execution Time: 1.761 ms
CREATE INDEX ON tickets (date);

-- Aggregate  (cost=11.87..11.88 rows=1 width=8) (actual time=0.273..0.274 rows=1 loops=1)
--   ->  Index Only Scan using tickets_date_idx on tickets  (cost=0.29..10.56 rows=524 width=0) (actual time=0.048..0.158 rows=482 loops=1)
--         Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--         Heap Fetches: 0
-- Planning Time: 0.410 ms
-- Execution Time: 0.322 ms
