-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN ANALYSE
SELECT MIN(price), MAX(price)
FROM tickets
WHERE session_id = 1;

-- Aggregate  (cost=2.51..2.52 rows=1 width=64) (actual time=0.023..0.024 rows=1 loops=1)
--   ->  Index Scan using tickets_session_id_idx1 on tickets  (cost=0.29..2.50 rows=1 width=5) (actual time=0.016..0.017 rows=1 loops=1)
--         Index Cond: (session_id = 1)
-- Planning Time: 0.128 ms
-- Execution Time: 0.080 ms
CREATE INDEX ON tickets (session_id);

-- Aggregate  (cost=2.51..2.52 rows=1 width=64) (actual time=0.040..0.041 rows=1 loops=1)
--   ->  Index Scan using tickets_session_id_idx2 on tickets  (cost=0.29..2.50 rows=1 width=5) (actual time=0.031..0.032 rows=1 loops=1)
--         Index Cond: (session_id = 1)
-- Planning Time: 0.495 ms
-- Execution Time: 0.090 ms
