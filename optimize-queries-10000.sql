
EXPLAIN ANALYSE SELECT
            DISTINCT f.film
        FROM
            films f,
            sessions s
        WHERE
            s.session_at BETWEEN TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
                AND TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
          AND s.film_id = f.id;


-- HashAggregate  (cost=13092.09..13102.09 rows=1000 width=14) (actual time=327.353..328.845 rows=999 loops=1)
--   Group Key: f.film
--   Batches: 1  Memory Usage: 129kB
--   ->  Gather  (cost=12877.09..13087.09 rows=2000 width=14) (actual time=326.728..328.348 rows=2591 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  HashAggregate  (cost=11877.09..11887.09 rows=1000 width=14) (actual time=321.998..322.069 rows=864 loops=3)
--               Group Key: f.film
--               Batches: 1  Memory Usage: 129kB
--               Worker 0:  Batches: 1  Memory Usage: 129kB
--               Worker 1:  Batches: 1  Memory Usage: 129kB
--               ->  Hash Join  (cost=29.50..11869.99 rows=2840 width=14) (actual time=1.150..321.006 rows=2000 loops=3)
--                     Hash Cond: (s.film_id = f.id)
--                     ->  Parallel Seq Scan on sessions s  (cost=0.00..11833.00 rows=2840 width=8) (actual time=0.354..319.251 rows=2000 loops=3)
-- "                          Filter: ((session_at >= to_timestamp(to_char(now(), 'YYYY-MM-DD 00:00:00'::text), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at <= to_timestamp(to_char(now(), 'YYYY-MM-DD 23:59:59'::text), 'YYYY-MM-DD HH24:MI:SS'::text)))"
--                           Rows Removed by Filter: 196667
--                     ->  Hash  (cost=17.00..17.00 rows=1000 width=22) (actual time=0.729..0.730 rows=1000 loops=3)
--                           Buckets: 1024  Batches: 1  Memory Usage: 63kB
--                           ->  Seq Scan on films f  (cost=0.00..17.00 rows=1000 width=22) (actual time=0.029..0.540 rows=1000 loops=3)
-- Planning Time: 4.209 ms
-- Execution Time: 328.996 ms


CREATE INDEX sess_at_key ON sessions(session_at);

-- HashAggregate  (cost=4945.57..4955.57 rows=1000 width=14) (actual time=103.453..103.520 rows=999 loops=1)
--   Group Key: f.film
--   Batches: 1  Memory Usage: 129kB
--   ->  Hash Join  (cost=127.81..4928.53 rows=6817 width=14) (actual time=1.531..101.817 rows=6000 loops=1)
--         Hash Cond: (s.film_id = f.id)
--         ->  Bitmap Heap Scan on sessions s  (cost=98.31..4881.06 rows=6817 width=8) (actual time=1.328..100.002 rows=6000 loops=1)
-- "              Recheck Cond: ((session_at >= to_timestamp(to_char(now(), 'YYYY-MM-DD 00:00:00'::text), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at <= to_timestamp(to_char(now(), 'YYYY-MM-DD 23:59:59'::text), 'YYYY-MM-DD HH24:MI:SS'::text)))"
--               Heap Blocks: exact=3270
--               ->  Bitmap Index Scan on sess_at_key  (cost=0.00..96.61 rows=6817 width=0) (actual time=0.558..0.558 rows=6000 loops=1)
-- "                    Index Cond: ((session_at >= to_timestamp(to_char(now(), 'YYYY-MM-DD 00:00:00'::text), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at <= to_timestamp(to_char(now(), 'YYYY-MM-DD 23:59:59'::text), 'YYYY-MM-DD HH24:MI:SS'::text)))"
--         ->  Hash  (cost=17.00..17.00 rows=1000 width=22) (actual time=0.193..0.194 rows=1000 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 63kB
--               ->  Seq Scan on films f  (cost=0.00..17.00 rows=1000 width=22) (actual time=0.005..0.090 rows=1000 loops=1)
-- Planning Time: 3.413 ms
-- Execution Time: 103.584 ms


EXPLAIN ANALYSE SELECT * FROM seats
        WHERE number = 'A10';

-- Seq Scan on seats  (cost=0.00..1699.00 rows=2907 width=21) (actual time=0.009..4.620 rows=3000 loops=1)
--   Filter: ((number)::text = 'A10'::text)
--   Rows Removed by Filter: 87000
-- Planning Time: 0.664 ms
-- Execution Time: 4.710 ms


CREATE INDEX seat_num_idx ON seats(number);

-- Bitmap Heap Scan on seats  (cost=34.82..645.16 rows=2907 width=21) (actual time=0.363..1.508 rows=3000 loops=1)
--   Recheck Cond: ((number)::text = 'A10'::text)
--   Heap Blocks: exact=574
--   ->  Bitmap Index Scan on seat_num_idx  (cost=0.00..34.09 rows=2907 width=0) (actual time=0.277..0.278 rows=3000 loops=1)
--         Index Cond: ((number)::text = 'A10'::text)
-- Planning Time: 0.754 ms
-- Execution Time: 1.656 ms


EXPLAIN ANALYSE SELECT * FROM booking_session_seats where hall_id = 10 AND price > 500 AND price < 600;

-- Gather  (cost=1000.00..1122319.70 rows=6157 width=38) (actual time=3432.343..5406.283 rows=6226 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on booking_session_seats  (cost=0.00..1120704.00 rows=2565 width=38) (actual time=1202.084..4274.049 rows=2075 loops=3)
--         Filter: ((price > '500'::numeric) AND (price < '600'::numeric) AND (hall_id = 10))
--         Rows Removed by Filter: 17877925
-- Planning Time: 5.801 ms
-- JIT:
--   Functions: 6
-- "  Options: Inlining true, Optimization true, Expressions true, Deforming true"
-- "  Timing: Generation 1.264 ms, Inlining 144.387 ms, Optimization 27.777 ms, Emission 32.126 ms, Total 205.554 ms"
-- Execution Time: 5532.866 ms

CREATE INDEX hall_price_idx ON booking_session_seats(hall_id, price);


-- Bitmap Heap Scan on booking_session_seats  (cost=175.07..23124.31 rows=6157 width=38) (actual time=3.529..6.036 rows=6226 loops=1)
--   Recheck Cond: ((hall_id = 10) AND (price > '500'::numeric) AND (price < '600'::numeric))
--   Heap Blocks: exact=4422
--   ->  Bitmap Index Scan on hall_price_idx  (cost=0.00..173.53 rows=6157 width=0) (actual time=3.061..3.062 rows=6226 loops=1)
--         Index Cond: ((hall_id = 10) AND (price > '500'::numeric) AND (price < '600'::numeric))
-- Planning Time: 101.527 ms
-- Execution Time: 6.228 ms






