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


EXPLAIN ANALYSE
SELECT
    f.film,
    t.price
FROM
    films f,
    (
        SELECT
            b.film_id,
            SUM(b.price) price
        FROM
            sessions s,
            booking_session_seats b
        WHERE
            s.session_at BETWEEN
                TO_TIMESTAMP(concat(current_date - interval '7 days', ' ', '00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
                AND TO_TIMESTAMP(concat(current_date, ' ', '23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
          AND b.session_id = s.id AND b.is_reserved = true
        GROUP BY
            b.film_id
        ORDER BY
            price DESC
        LIMIT 3
    ) t
WHERE f.id = t.film_id;

-- Hash Join  (cost=1223445.28..1223464.92 rows=3 width=46) (actual time=7259.874..7263.695 rows=3 loops=1)
--   Hash Cond: (f.id = t.film_id)
--   ->  Seq Scan on films f  (cost=0.00..17.00 rows=1000 width=22) (actual time=0.011..0.061 rows=1000 loops=1)
--   ->  Hash  (cost=1223445.24..1223445.24 rows=3 width=40) (actual time=7259.837..7263.579 rows=3 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Subquery Scan on t  (cost=1223445.21..1223445.24 rows=3 width=40) (actual time=7259.830..7263.572 rows=3 loops=1)
--               ->  Limit  (cost=1223445.21..1223445.21 rows=3 width=40) (actual time=7259.825..7263.566 rows=3 loops=1)
--                     ->  Sort  (cost=1223445.21..1223447.71 rows=1000 width=40) (actual time=7115.401..7119.141 rows=3 loops=1)
--                           Sort Key: (sum(b.price)) DESC
--                           Sort Method: top-N heapsort  Memory: 25kB
--                           ->  Finalize GroupAggregate  (cost=1223171.43..1223432.28 rows=1000 width=40) (actual time=7114.047..7119.014 rows=1000 loops=1)
--                                 Group Key: b.film_id
--                                 ->  Gather Merge  (cost=1223171.43..1223404.78 rows=2000 width=40) (actual time=7114.033..7118.165 rows=3000 loops=1)
--                                       Workers Planned: 2
--                                       Workers Launched: 2
--                                       ->  Sort  (cost=1222171.41..1222173.91 rows=1000 width=40) (actual time=7083.076..7083.117 rows=1000 loops=3)
--                                             Sort Key: b.film_id
--                                             Sort Method: quicksort  Memory: 126kB
--                                             Worker 0:  Sort Method: quicksort  Memory: 126kB
--                                             Worker 1:  Sort Method: quicksort  Memory: 126kB
--                                             ->  Partial HashAggregate  (cost=1222109.08..1222121.58 rows=1000 width=40) (actual time=7082.750..7082.937 rows=1000 loops=3)
--                                                   Group Key: b.film_id
--                                                   Batches: 1  Memory Usage: 577kB
--                                                   Worker 0:  Batches: 1  Memory Usage: 577kB
--                                                   Worker 1:  Batches: 1  Memory Usage: 577kB
--                                                   ->  Parallel Hash Join  (cost=5988.01..1216330.81 rows=1155653 width=13) (actual time=205.659..6880.029 rows=911062 loops=3)
--                                                         Hash Cond: (b.session_id = s.id)
--                                                         ->  Parallel Seq Scan on booking_session_seats b  (cost=0.00..1173536.57 rows=14021322 width=21) (actual time=200.079..5663.927 rows=11303142 loops=3)
--                                                               Filter: is_reserved
--                                                               Rows Removed by Filter: 6576858
--                                                         ->  Parallel Hash  (cost=5732.16..5732.16 rows=20468 width=8) (actual time=5.414..5.415 rows=16000 loops=3)
--                                                               Buckets: 65536  Batches: 1  Memory Usage: 2400kB
--                                                               ->  Parallel Bitmap Heap Scan on sessions s  (cost=683.95..5732.16 rows=20468 width=8) (actual time=2.380..10.683 rows=48000 loops=1)
-- "                                                                    Recheck Cond: ((session_at >= to_timestamp(concat((CURRENT_DATE - '7 days'::interval), ' ', '00:00:00'), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at <= to_timestamp(concat(CURRENT_DATE, ' ', '23:59:59'), 'YYYY-MM-DD HH24:MI:SS'::text)))"
--                                                                     Heap Blocks: exact=4383
--                                                                     ->  Bitmap Index Scan on sess_at_key  (cost=0.00..671.67 rows=49123 width=0) (actual time=1.932..1.932 rows=48000 loops=1)
-- "                                                                          Index Cond: ((session_at >= to_timestamp(concat((CURRENT_DATE - '7 days'::interval), ' ', '00:00:00'), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at <= to_timestamp(concat(CURRENT_DATE, ' ', '23:59:59'), 'YYYY-MM-DD HH24:MI:SS'::text)))"
-- Planning Time: 0.759 ms
-- JIT:
--   Functions: 75
-- "  Options: Inlining true, Optimization true, Expressions true, Deforming true"
-- "  Timing: Generation 2.553 ms, Inlining 225.980 ms, Optimization 169.670 ms, Emission 96.494 ms, Total 494.697 ms"
-- Execution Time: 7265.064 ms

CREATE INDEX sessions_at_idx ON sessions(session_at);

CREATE MATERIALIZED VIEW high_grossing_films AS SELECT
    f.film Фильм,
    SUM(b.price) Выручка
    FROM
    sessions s,
    booking_session_seats b,
    films f
    WHERE
    s.session_at BETWEEN
    TO_TIMESTAMP(concat(current_date - interval '7 days', ' ', '00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
    AND TO_TIMESTAMP(concat(current_date, ' ', '23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
    AND b.session_id = s.id AND s.film_id = f.id AND b.is_reserved = true
    GROUP BY
    f.id
    ORDER BY
    Выручка DESC
    LIMIT 3;

EXPLAIN ANALYSE SELECT * FROM high_grossing_films;

-- Seq Scan on high_grossing_films  (cost=0.00..12.90 rows=290 width=250) (actual time=0.345..0.345 rows=3 loops=1)
-- Planning Time: 0.178 ms
-- Execution Time: 0.353 ms




EXPLAIN ANALYSE SELECT
    min(b.price) Минимальная_цена,
    max(b.price) Максимальная_цена
FROM
    booking_session_seats b
WHERE
    b.session_id = 100 and b.is_reserved = false;

-- Aggregate  (cost=394.44..394.45 rows=1 width=64) (actual time=24.531..24.532 rows=1 loops=1)
--   ->  Index Scan using booking_session_seats_session_id_hall_id_seat_id_key on booking_session_seats b  (cost=0.56..394.26 rows=36 width=5) (actual time=9.804..24.513 rows=29 loops=1)
--         Index Cond: (session_id = 100)
--         Filter: (NOT is_reserved)
--         Rows Removed by Filter: 61
-- Planning Time: 0.385 ms
-- Execution Time: 24.558 ms

CREATE INDEX ses_price_idx ON booking_session_seats(session_id, price);

-- Result  (cost=23.02..23.03 rows=1 width=64) (actual time=1.240..1.241 rows=1 loops=1)
--   InitPlan 1 (returns $0)
--     ->  Limit  (cost=0.56..11.51 rows=1 width=5) (actual time=1.231..1.231 rows=1 loops=1)
--           ->  Index Scan using ses_price_idx on booking_session_seats b  (cost=0.56..394.50 rows=36 width=5) (actual time=1.230..1.230 rows=1 loops=1)
--                 Index Cond: ((session_id = 100) AND (price IS NOT NULL))
--                 Filter: (NOT is_reserved)
--                 Rows Removed by Filter: 6
--   InitPlan 2 (returns $1)
--     ->  Limit  (cost=0.56..11.51 rows=1 width=5) (actual time=0.005..0.006 rows=1 loops=1)
--           ->  Index Scan Backward using ses_price_idx on booking_session_seats b_1  (cost=0.56..394.50 rows=36 width=5) (actual time=0.005..0.005 rows=1 loops=1)
--                 Index Cond: ((session_id = 100) AND (price IS NOT NULL))
--                 Filter: (NOT is_reserved)
-- Planning Time: 135.482 ms
-- Execution Time: 1.258 ms




CREATE EXTENSION IF NOT EXISTS tablefunc;
EXPLAIN ANALYSE SELECT
    *
FROM
    crosstab(
            'SELECT
    st.line,st.number, b.is_reserved
FROM
    sessions s,
    halls h,
    seats st,
    booking_session_seats b
WHERE
    s.id = 2 AND s.hall_id = h.id AND st.hall_id = h.id AND b.hall_id = h.id
    AND b.session_id = s.id AND b.seat_id = st.id'
    ) AS ct (line varchar(100), A1 bool ,A2 bool,A3 bool,A4 bool,A5 bool,A6 bool,A7 bool,A8 bool,A9 bool,A10 bool,
             B1 bool,B2 bool,B3 bool,B4 bool,B5 bool,B6 bool,B7 bool,B8 bool,B9 bool,B10 bool,C1 bool,C2 bool,C3 bool,
             C4 bool,C5 bool,C6 bool,C7 bool,C8 bool,C9 bool,C10 bool);

-- Function Scan on crosstab ct  (cost=0.00..10.00 rows=1000 width=248) (actual time=1.672..1.673 rows=3 loops=1)
-- Planning Time: 0.038 ms
-- Execution Time: 1.716 ms


-- Не нужна оптимизация так как используется индекс