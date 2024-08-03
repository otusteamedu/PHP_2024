-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN ANALYSE
SELECT MIN(price), MAX(price)
FROM tickets
WHERE session_id = 1;

-- Aggregate  (cost=126613.44..126613.45 rows=1 width=64) (actual time=459.384..462.135 rows=1 loops=1)
--   ->  Gather  (cost=1000.00..126613.43 rows=1 width=5) (actual time=459.204..462.091 rows=1 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Parallel Seq Scan on tickets  (cost=0.00..125613.33 rows=1 width=5) (actual time=314.382..448.270 rows=0 loops=3)
--               Filter: (session_id = 1)
--               Rows Removed by Filter: 3333333
-- Planning Time: 30.647 ms
-- JIT:
--   Functions: 14
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 1.135 ms, Inlining 0.000 ms, Optimization 0.717 ms, Emission 13.359 ms, Total 15.211 ms"
-- Execution Time: 474.461 ms



CREATE INDEX ON tickets (session_id);

-- Aggregate  (cost=2.66..2.67 rows=1 width=64) (actual time=0.030..0.031 rows=1 loops=1)
--   ->  Index Scan using tickets_session_id_idx on tickets  (cost=0.43..2.65 rows=1 width=5) (actual time=0.025..0.026 rows=1 loops=1)
--         Index Cond: (session_id = 1)
-- Planning Time: 0.232 ms
-- Execution Time: 0.063 ms

