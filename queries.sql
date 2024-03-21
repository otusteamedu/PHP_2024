EXPLAIN ANALYSE
    SELECT id, row, place
FROM tickets where place > 10;
-- region result 4 ROWS Planning Time: 0.240 ms / Execution Time: 0.022 ms (cost=0.00..21.25 rows=300 width=16) (actual time=0.005..0.006 rows=2 loops=1)
-- Seq Scan on tickets  (cost=0.00..21.25 rows=300 width=16) (actual time=0.005..0.006 rows=2 loops=1)
--   Filter: (place > 10)
--   Rows Removed by Filter: 2
-- Planning Time: 0.240 ms
-- Execution Time: 0.022 ms
-- endregion

-- region result 10000 ROWS Planning Time: 0.040 ms / Execution Time: 1.700 ms (cost=0.00..178.50 rows=2520 width=16) (actual time=0.023..1.485 rows=7476 loops=1)
-- Seq Scan on tickets   (cost=0.00..178.50 rows=2520 width=16) (actual time=0.023..1.485 rows=7476 loops=1)
--   Filter: (place > 10)
--   Rows Removed by Filter: 2528
-- Planning Time: 0.040 ms
-- Execution Time: 1.700 ms
-- endregion

-- region result 10000000 ROWS Planning Time: 0.049 ms / Execution Time: 2454.040 ms (cost=0.00..207599.09 rows=7424113 width=16) (actual time=27.629..2033.835 rows=7508550 loops=1)
-- Seq Scan on tickets  (cost=0.00..207599.09 rows=7424113 width=16) (actual time=27.629..2033.835 rows=7508550 loops=1)
--   Filter: (place > 10)
--   Rows Removed by Filter: 2501454
-- Planning Time: 0.049 ms
-- JIT:
--   Functions: 4
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 0.673 ms, Inlining 0.000 ms, Optimization 1.913 ms, Emission 25.019 ms, Total 27.604 ms"
-- Execution Time: 2454.040 ms
-- endregion

-- region result 10000000 ROWS AFTER INDEX Planning Time: 0.049 ms / Execution Time: 2454.040 ms (cost=0.00..207599.09 rows=7424113 width=16) (actual time=27.629..2033.835 rows=7508550 loops=1)
-- Seq Scan on tickets  (cost=0.00..207599.09 rows=7424113 width=16) (actual time=27.629..2033.835 rows=7508550 loops=1)
--   Filter: (place > 10)
--   Rows Removed by Filter: 2501454
-- Planning Time: 0.049 ms
-- JIT:
--   Functions: 4
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 0.673 ms, Inlining 0.000 ms, Optimization 1.913 ms, Emission 25.019 ms, Total 27.604 ms"
-- Execution Time: 2454.040 ms
-- endregion

EXPLAIN ANALYSE
    SELECT id, row, place, session_id
FROM tickets where place > 10 ORDER BY session_id;
-- region result 4 ROWS Planning Time: 0.128 ms / Execution Time: 0.073 ms (cost=33.59..34.34 rows=300 width=24) (actual time=0.055..0.056 rows=2 loops=1)
-- Sort  (cost=33.59..34.34 rows=300 width=24) (actual time=0.055..0.056 rows=2 loops=1)
--   Sort Key: session_id
--   Sort Method: quicksort  Memory: 25kB
--   ->  Seq Scan on tickets  (cost=0.00..21.25 rows=300 width=24) (actual time=0.012..0.013 rows=2 loops=1)
--         Filter: (place > 10)
--         Rows Removed by Filter: 2
-- Planning Time: 0.128 ms
-- Execution Time: 0.073 ms
-- endregion

-- region result 10000 ROWS (cost=690.06..708.75 rows=7476 width=24) (actual time=2.435..2.792 rows=7476 loops=1)
-- Sort  (cost=690.06..708.75 rows=7476 width=24) (actual time=2.435..2.792 rows=7476 loops=1)
--   Sort Key: session_id
--   Sort Method: quicksort  Memory: 543kB
--   ->  Seq Scan on tickets  (cost=0.00..209.05 rows=7476 width=24) (actual time=0.008..1.228 rows=7476 loops=1)
--         Filter: (place > 10)
--         Rows Removed by Filter: 2528
-- Planning Time: 0.148 ms
-- Execution Time: 3.033 ms
-- endregion

-- region result 10000000 ROWS Planning Time: 0.142 ms / Execution Time: 5611.313 ms (cost=601372.61..1329887.57 rows=6243978 width=24) (actual time=3225.914..5374.812 rows=7508550 loops=1)
-- Gather Merge  (cost=601372.61..1329887.57 rows=6243978 width=24) (actual time=3225.914..5374.812 rows=7508550 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=600372.59..608177.56 rows=3121989 width=24) (actual time=3170.816..3475.531 rows=2502850 loops=3)
--         Sort Key: session_id
--         Sort Method: external merge  Disk: 90120kB
--         Worker 0:  Sort Method: external merge  Disk: 81648kB
--         Worker 1:  Sort Method: external merge  Disk: 78128kB
--         ->  Parallel Seq Scan on tickets  (cost=0.00..135552.10 rows=3121989 width=24) (actual time=226.731..1094.792 rows=2502850 loops=3)
--               Filter: (place > 10)
--               Rows Removed by Filter: 833818
-- Planning Time: 0.142 ms
-- JIT:
--   Functions: 12
-- "  Options: Inlining true, Optimization true, Expressions true, Deforming true"
-- "  Timing: Generation 2.647 ms, Inlining 414.480 ms, Optimization 105.351 ms, Emission 160.274 ms, Total 682.752 ms"
-- Execution Time: 5611.313 ms
-- endregion

-- region result 10000000 ROWS AFTER INDEX Planning Time: 0.069 ms / Execution Time: 3038.305 ms (cost=0.43..538562.29 rows=7492822 width=24) (actual time=31.228..2829.602 rows=7508550 loops=1)
-- Index Scan using indx_tickets_session_id on tickets  (cost=0.43..538562.29 rows=7492822 width=24) (actual time=31.228..2829.602 rows=7508550 loops=1)
--   Filter: (place > 10)
--   Rows Removed by Filter: 2501454
-- Planning Time: 0.069 ms
-- JIT:
--   Functions: 4
-- "  Options: Inlining true, Optimization true, Expressions true, Deforming true"
-- "  Timing: Generation 0.812 ms, Inlining 1.646 ms, Optimization 13.706 ms, Emission 15.520 ms, Total 31.684 ms"
-- Execution Time: 3038.305 ms
-- endregion

EXPLAIN ANALYSE
    SELECT session_id, count(id)
FROM tickets GROUP BY session_id;
-- region result 4 ROWS Planning Time: 0.067 ms / Execution Time: 0.050 ms (cost=23.50..25.50 rows=200 width=16) (actual time=0.012..0.013 rows=3 loops=1)
-- HashAggregate  (cost=23.50..25.50 rows=200 width=16) (actual time=0.012..0.013 rows=3 loops=1)
--   Group Key: session_id
--   Batches: 1  Memory Usage: 40kB
--   ->  Seq Scan on tickets  (cost=0.00..19.00 rows=900 width=16) (actual time=0.003..0.004 rows=4 loops=1)
-- Planning Time: 0.067 ms
-- Execution Time: 0.050 ms
-- endregion

-- region result 10000 ROWS Planning Time: 0.057 ms / Execution Time: 2.515 ms (cost=234.06..234.14 rows=8 width=16) (actual time=2.486..2.488 rows=8 loops=1)
-- HashAggregate  (cost=234.06..234.14 rows=8 width=16) (actual time=2.486..2.488 rows=8 loops=1)
--   Group Key: session_id
--   Batches: 1  Memory Usage: 24kB
--   ->  Seq Scan on tickets  (cost=0.00..184.04 rows=10004 width=16) (actual time=0.006..0.727 rows=10004 loops=1)
-- Planning Time: 0.057 ms
-- Execution Time: 2.515 ms
-- endregion

-- region result 10000000 ROWS Planning Time: 1.646 ms  / Execution Time: 2230.681 ms (cost=146979.35..146981.37 rows=8 width=16) (actual time=2224.104..2228.815 rows=8 loops=1)
-- Finalize GroupAggregate  (cost=146979.35..146981.37 rows=8 width=16) (actual time=2224.104..2228.815 rows=8 loops=1)
--   Group Key: session_id
--   ->  Gather Merge  (cost=146979.35..146981.21 rows=16 width=16) (actual time=2224.094..2228.802 rows=24 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Sort  (cost=145979.32..145979.34 rows=8 width=16) (actual time=2192.529..2192.530 rows=8 loops=3)
--               Sort Key: session_id
--               Sort Method: quicksort  Memory: 25kB
--               Worker 0:  Sort Method: quicksort  Memory: 25kB
--               Worker 1:  Sort Method: quicksort  Memory: 25kB
--               ->  Partial HashAggregate  (cost=145979.12..145979.20 rows=8 width=16) (actual time=2192.457..2192.458 rows=8 loops=3)
--                     Group Key: session_id
--                     Batches: 1  Memory Usage: 24kB
--                     Worker 0:  Batches: 1  Memory Usage: 24kB
--                     Worker 1:  Batches: 1  Memory Usage: 24kB
--                     ->  Parallel Seq Scan on tickets  (cost=0.00..125125.08 rows=4170808 width=16) (actual time=0.710..1399.168 rows=3336668 loops=3)
-- Planning Time: 1.646 ms
-- JIT:
--   Functions: 24
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 4.818 ms, Inlining 0.000 ms, Optimization 2.213 ms, Emission 19.852 ms, Total 26.883 ms"
-- Execution Time: 2230.681 ms
-- endregion

-- region result 10000000 ROWS AFTER INDEX Planning Time: 0.125 ms / Execution Time: 1871.592 ms (cost=146979.75..146981.78 rows=8 width=16) (actual time=1863.179..1870.095 rows=8 loops=1)
-- Finalize GroupAggregate  (cost=146979.75..146981.78 rows=8 width=16) (actual time=1863.179..1870.095 rows=8 loops=1)
--   Group Key: session_id
--   ->  Gather Merge  (cost=146979.75..146981.62 rows=16 width=16) (actual time=1863.169..1870.082 rows=24 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Sort  (cost=145979.72..145979.74 rows=8 width=16) (actual time=1844.047..1844.048 rows=8 loops=3)
--               Sort Key: session_id
--               Sort Method: quicksort  Memory: 25kB
--               Worker 0:  Sort Method: quicksort  Memory: 25kB
--               Worker 1:  Sort Method: quicksort  Memory: 25kB
--               ->  Partial HashAggregate  (cost=145979.52..145979.60 rows=8 width=16) (actual time=1844.025..1844.027 rows=8 loops=3)
--                     Group Key: session_id
--                     Batches: 1  Memory Usage: 24kB
--                     Worker 0:  Batches: 1  Memory Usage: 24kB
--                     Worker 1:  Batches: 1  Memory Usage: 24kB
--                     ->  Parallel Seq Scan on tickets  (cost=0.00..125125.35 rows=4170835 width=16) (actual time=0.030..734.797 rows=3336668 loops=3)
-- Planning Time: 0.125 ms
-- JIT:
--   Functions: 24
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.508 ms, Inlining 0.000 ms, Optimization 0.804 ms, Emission 30.439 ms, Total 33.751 ms"
-- Execution Time: 1871.592 ms

-- endregion


EXPLAIN ANALYSE
    SELECT m.name, p.price as sum
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE p.price > 100 and z.number_of_seats > 40;
-- region result 4 ROWS Planning Time: 0.981 ms / Execution Time: 0.182 ms (cost=77.63..118.27 rows=78 width=530) (actual time=0.099..0.113 rows=6 loops=1)
-- Hash Left Join  (cost=77.63..118.27 rows=78 width=530) (actual time=0.099..0.113 rows=6 loops=1)
--   Hash Cond: (s.movie_id = m.id)
--   ->  Nested Loop Left Join  (cost=64.48..104.91 rows=78 width=22) (actual time=0.081..0.093 rows=6 loops=1)
--         ->  Hash Join  (cost=64.33..87.49 rows=78 width=22) (actual time=0.067..0.071 rows=6 loops=1)
--               Hash Cond: (tickets.zone_id = z.id)
--               ->  Seq Scan on tickets  (cost=0.00..19.00 rows=900 width=16) (actual time=0.007..0.007 rows=4 loops=1)
--               ->  Hash  (cost=62.61..62.61 rows=137 width=30) (actual time=0.040..0.042 rows=4 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Hash Join  (cost=36.16..62.61 rows=137 width=30) (actual time=0.034..0.038 rows=4 loops=1)
--                           Hash Cond: (p.zone_id = z.id)
--                           ->  Seq Scan on prices p  (cost=0.00..25.38 rows=410 width=22) (actual time=0.006..0.008 rows=6 loops=1)
--                                 Filter: (price > '100'::numeric)
--                           ->  Hash  (cost=29.62..29.62 rows=523 width=8) (actual time=0.011..0.011 rows=3 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Seq Scan on zones z  (cost=0.00..29.62 rows=523 width=8) (actual time=0.004..0.006 rows=3 loops=1)
--                                       Filter: (number_of_seats > 40)
--                                       Rows Removed by Filter: 3
--         ->  Index Scan using sessions_pkey on sessions s  (cost=0.15..0.22 rows=1 width=16) (actual time=0.003..0.003 rows=1 loops=6)
--               Index Cond: (id = tickets.session_id)
--   ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.006..0.006 rows=4 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.002..0.003 rows=4 loops=1)
-- Planning Time: 0.981 ms
-- Execution Time: 0.182 ms
-- endregion

-- region result 10000 ROWS Planning Time: 0.420 ms / Execution Time: 5.941 ms (cost=77.64..333.39 rows=870 width=530) (actual time=0.041..5.714 rows=6788 loops=1)
-- Hash Left Join  (cost=77.64..333.39 rows=870 width=530) (actual time=0.041..5.714 rows=6788 loops=1)
--   Hash Cond: (s.movie_id = m.id)
--   ->  Nested Loop Left Join  (cost=64.49..317.91 rows=870 width=22) (actual time=0.035..4.566 rows=6788 loops=1)
--         ->  Hash Join  (cost=64.33..294.61 rows=870 width=22) (actual time=0.027..2.303 rows=6788 loops=1)
--               Hash Cond: (tickets.zone_id = z.id)
--               ->  Seq Scan on tickets  (cost=0.00..184.04 rows=10004 width=16) (actual time=0.005..0.583 rows=10004 loops=1)
--               ->  Hash  (cost=62.61..62.61 rows=137 width=30) (actual time=0.016..0.018 rows=4 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Hash Join  (cost=36.16..62.61 rows=137 width=30) (actual time=0.012..0.016 rows=4 loops=1)
--                           Hash Cond: (p.zone_id = z.id)
--                           ->  Seq Scan on prices p  (cost=0.00..25.38 rows=410 width=22) (actual time=0.004..0.005 rows=6 loops=1)
--                                 Filter: (price > '100'::numeric)
--                           ->  Hash  (cost=29.62..29.62 rows=523 width=8) (actual time=0.005..0.006 rows=3 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Seq Scan on zones z  (cost=0.00..29.62 rows=523 width=8) (actual time=0.002..0.003 rows=3 loops=1)
--                                       Filter: (number_of_seats > 40)
--                                       Rows Removed by Filter: 3
--         ->  Memoize  (cost=0.16..0.18 rows=1 width=16) (actual time=0.000..0.000 rows=1 loops=6788)
--               Cache Key: tickets.session_id
--               Cache Mode: logical
--               Hits: 6780  Misses: 8  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--               ->  Index Scan using sessions_pkey on sessions s  (cost=0.15..0.17 rows=1 width=16) (actual time=0.001..0.001 rows=1 loops=8)
--                     Index Cond: (id = tickets.session_id)
--   ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.003..0.004 rows=4 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.002..0.002 rows=4 loops=1)
-- Planning Time: 0.420 ms
-- Execution Time: 5.941 ms
-- endregion

-- region result 10000000 ROWS Planning Time: 1.363 ms / Execution Time: 8020.226 ms (cost=140.64..374495.51 rows=10009940 width=530) (actual time=15.892..7621.231 rows=15015171 loops=1)
-- Hash Left Join  (cost=140.64..374495.51 rows=10009940 width=530) (actual time=15.892..7621.231 rows=15015171 loops=1)
--   Hash Cond: (s.movie_id = m.id)
--   ->  Hash Left Join  (cost=127.49..347649.46 rows=10009940 width=22) (actual time=15.615..5275.843 rows=15015171 loops=1)
--         Hash Cond: (tickets.session_id = s.id)
--         ->  Hash Left Join  (cost=90.49..321243.56 rows=10009940 width=22) (actual time=15.591..3022.838 rows=15015171 loops=1)
--               Hash Cond: (tickets.zone_id = z.id)
--               ->  Seq Scan on tickets  (cost=0.00..183516.40 rows=10009940 width=16) (actual time=0.020..733.638 rows=10010004 loops=1)
--               ->  Hash  (cost=70.86..70.86 rows=1570 width=22) (actual time=15.560..15.563 rows=9 loops=1)
--                     Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                     ->  Hash Right Join  (cost=45.33..70.86 rows=1570 width=22) (actual time=15.548..15.557 rows=9 loops=1)
--                           Hash Cond: (p.zone_id = z.id)
--                           ->  Seq Scan on prices p  (cost=0.00..22.30 rows=1230 width=22) (actual time=0.703..0.704 rows=6 loops=1)
--                           ->  Hash  (cost=25.70..25.70 rows=1570 width=8) (actual time=14.824..14.825 rows=6 loops=1)
--                                 Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                 ->  Seq Scan on zones z  (cost=0.00..25.70 rows=1570 width=8) (actual time=14.805..14.808 rows=6 loops=1)
--         ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.011..0.011 rows=8 loops=1)
--               Buckets: 2048  Batches: 1  Memory Usage: 17kB
--               ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.007..0.008 rows=8 loops=1)
--   ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.269..0.269 rows=4 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.264..0.265 rows=4 loops=1)
-- Planning Time: 1.363 ms
-- JIT:
--   Functions: 36
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 1.266 ms, Inlining 0.000 ms, Optimization 0.643 ms, Emission 14.194 ms, Total 16.103 ms"
-- Execution Time: 8020.226 ms
-- endregion

-- region result 10000000 ROWS ROWS AFTER INDEX Planning Time: 0.379 ms / Execution Time: 4385.519 ms (cost=52.34..243701.59 rows=1112223 width=530) (actual time=15.815..4205.920 rows=6678576 loops=1)
-- Hash Left Join  (cost=52.34..243701.59 rows=1112223 width=530) (actual time=15.815..4205.920 rows=6678576 loops=1)
--   Hash Cond: (s.movie_id = m.id)
--   ->  Hash Left Join  (cost=39.19..240706.99 rows=1112223 width=22) (actual time=15.795..3167.027 rows=6678576 loops=1)
--         Hash Cond: (tickets.session_id = s.id)
--         ->  Hash Join  (cost=2.19..237740.09 rows=1112223 width=22) (actual time=15.772..2158.149 rows=6678576 loops=1)
--               Hash Cond: (tickets.zone_id = z.id)
--               ->  Seq Scan on tickets  (cost=0.00..183517.04 rows=10010004 width=16) (actual time=0.056..656.876 rows=10010004 loops=1)
--               ->  Hash  (cost=2.18..2.18 rows=1 width=30) (actual time=15.705..15.708 rows=4 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Hash Join  (cost=1.10..2.18 rows=1 width=30) (actual time=15.699..15.704 rows=4 loops=1)
--                           Hash Cond: (p.zone_id = z.id)
--                           ->  Seq Scan on prices p  (cost=0.00..1.07 rows=2 width=22) (actual time=15.631..15.633 rows=6 loops=1)
--                                 Filter: (price > '100'::numeric)
--                           ->  Hash  (cost=1.07..1.07 rows=2 width=8) (actual time=0.048..0.049 rows=3 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Seq Scan on zones z  (cost=0.00..1.07 rows=2 width=8) (actual time=0.043..0.043 rows=3 loops=1)
--                                       Filter: (number_of_seats > 40)
--                                       Rows Removed by Filter: 3
--         ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.014..0.015 rows=8 loops=1)
--               Buckets: 2048  Batches: 1  Memory Usage: 17kB
--               ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.010..0.011 rows=8 loops=1)
--   ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.012..0.012 rows=4 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.008..0.009 rows=4 loops=1)
-- Planning Time: 0.379 ms
-- JIT:
--   Functions: 40
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 1.076 ms, Inlining 0.000 ms, Optimization 0.533 ms, Emission 15.111 ms, Total 16.720 ms"
-- Execution Time: 4385.519 ms
-- endregion

EXPLAIN ANALYSE
    SELECT m.name, p.price
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE p.price > 300 ORDER BY p.price;
-- region result 4 ROWS (cost=162.28..162.86 rows=235 width=530) (actual time=0.089..0.091 rows=2 loops=1)
-- Sort  (cost=162.28..162.86 rows=235 width=530) (actual time=0.089..0.091 rows=2 loops=1)
--   Sort Key: p.price
--   Sort Method: quicksort  Memory: 25kB
--   ->  Hash Left Join  (cost=127.05..153.02 rows=235 width=530) (actual time=0.066..0.070 rows=2 loops=1)
--         Hash Cond: (s.movie_id = m.id)
--         ->  Hash Left Join  (cost=113.90..139.24 rows=235 width=22) (actual time=0.041..0.045 rows=2 loops=1)
--               Hash Cond: (tickets.session_id = s.id)
--               ->  Hash Join  (cost=76.90..101.63 rows=235 width=22) (actual time=0.030..0.032 rows=2 loops=1)
--                     Hash Cond: (tickets.zone_id = z.id)
--                     ->  Seq Scan on tickets  (cost=0.00..19.00 rows=900 width=16) (actual time=0.005..0.005 rows=4 loops=1)
--                     ->  Hash  (cost=71.78..71.78 rows=410 width=30) (actual time=0.019..0.020 rows=2 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Hash Join  (cost=45.33..71.78 rows=410 width=30) (actual time=0.015..0.018 rows=2 loops=1)
--                                 Hash Cond: (p.zone_id = z.id)
--                                 ->  Seq Scan on prices p  (cost=0.00..25.38 rows=410 width=22) (actual time=0.004..0.005 rows=2 loops=1)
--                                       Filter: (price > '300'::numeric)
--                                       Rows Removed by Filter: 4
--                                 ->  Hash  (cost=25.70..25.70 rows=1570 width=8) (actual time=0.006..0.007 rows=6 loops=1)
--                                       Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                       ->  Seq Scan on zones z  (cost=0.00..25.70 rows=1570 width=8) (actual time=0.002..0.003 rows=6 loops=1)
--               ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.007..0.007 rows=8 loops=1)
--                     Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                     ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.002..0.003 rows=8 loops=1)
--         ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.006..0.006 rows=4 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.002..0.003 rows=4 loops=1)
-- Planning Time: 0.522 ms
-- Execution Time: 0.140 ms
-- endregion

-- region result 10000 ROWS Planning Time: 0.551 ms / Execution Time: 4.537 ms (cost=536.93..543.46 rows=2613 width=530) (actual time=4.275..4.394 rows=3338 loops=1)
-- Sort  (cost=536.93..543.46 rows=2613 width=530) (actual time=4.275..4.394 rows=3338 loops=1)
--   Sort Key: p.price
--   Sort Method: quicksort  Memory: 259kB
--   ->  Hash Left Join  (cost=127.05..388.62 rows=2613 width=530) (actual time=0.079..3.344 rows=3338 loops=1)
--         Hash Cond: (s.movie_id = m.id)
--         ->  Hash Left Join  (cost=113.90..368.47 rows=2613 width=22) (actual time=0.066..2.718 rows=3338 loops=1)
--               Hash Cond: (tickets.session_id = s.id)
--               ->  Hash Join  (cost=76.90..324.59 rows=2613 width=22) (actual time=0.051..2.056 rows=3338 loops=1)
--                     Hash Cond: (tickets.zone_id = z.id)
--                     ->  Seq Scan on tickets  (cost=0.00..184.04 rows=10004 width=16) (actual time=0.014..0.657 rows=10004 loops=1)
--                     ->  Hash  (cost=71.78..71.78 rows=410 width=30) (actual time=0.029..0.031 rows=2 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Hash Join  (cost=45.33..71.78 rows=410 width=30) (actual time=0.025..0.029 rows=2 loops=1)
--                                 Hash Cond: (p.zone_id = z.id)
--                                 ->  Seq Scan on prices p  (cost=0.00..25.38 rows=410 width=22) (actual time=0.008..0.009 rows=2 loops=1)
--                                       Filter: (price > '300'::numeric)
--                                       Rows Removed by Filter: 4
--                                 ->  Hash  (cost=25.70..25.70 rows=1570 width=8) (actual time=0.010..0.010 rows=6 loops=1)
--                                       Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                       ->  Seq Scan on zones z  (cost=0.00..25.70 rows=1570 width=8) (actual time=0.004..0.005 rows=6 loops=1)
--               ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.009..0.009 rows=8 loops=1)
--                     Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                     ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.005..0.006 rows=8 loops=1)
--         ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.006..0.007 rows=4 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.003..0.004 rows=4 loops=1)
-- Planning Time: 0.551 ms
-- Execution Time: 4.537 ms
-- endregion

-- region result 10000000 ROWS 0.561/5830.678 ms (cost=788990.34..1043152.88 rows=2178384 width=530) (actual time=4569.082..5736.308 rows=3336285 loops=1)
-- Gather Merge  (cost=788990.34..1043152.88 rows=2178384 width=530) (actual time=4569.082..5736.308 rows=3336285 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=787990.32..790713.30 rows=1089192 width=530) (actual time=4542.113..4690.074 rows=1112095 loops=3)
--         Sort Key: p.price
--         Sort Method: external merge  Disk: 37304kB
--         Worker 0:  Sort Method: external merge  Disk: 32240kB
--         Worker 1:  Sort Method: external merge  Disk: 33360kB
--         ->  Hash Left Join  (cost=127.05..157573.53 rows=1089192 width=530) (actual time=740.659..3357.017 rows=1112095 loops=3)
--               Hash Cond: (s.movie_id = m.id)
--               ->  Hash Left Join  (cost=113.90..154640.67 rows=1089192 width=22) (actual time=740.644..2736.891 rows=1112095 loops=3)
--                     Hash Cond: (tickets.session_id = s.id)
--                     ->  Hash Join  (cost=76.90..151734.43 rows=1089192 width=22) (actual time=740.625..2257.834 rows=1112095 loops=3)
--                           Hash Cond: (tickets.zone_id = z.id)
--                           ->  Parallel Seq Scan on tickets  (cost=0.00..125125.08 rows=4170808 width=16) (actual time=0.039..655.703 rows=3336668 loops=3)
--                           ->  Hash  (cost=71.78..71.78 rows=410 width=30) (actual time=740.517..740.520 rows=2 loops=3)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Hash Join  (cost=45.33..71.78 rows=410 width=30) (actual time=740.513..740.516 rows=2 loops=3)
--                                       Hash Cond: (p.zone_id = z.id)
--                                       ->  Seq Scan on prices p  (cost=0.00..25.38 rows=410 width=22) (actual time=740.462..740.463 rows=2 loops=3)
--                                             Filter: (price > '300'::numeric)
--                                             Rows Removed by Filter: 4
--                                       ->  Hash  (cost=25.70..25.70 rows=1570 width=8) (actual time=0.033..0.034 rows=6 loops=3)
--                                             Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                             ->  Seq Scan on zones z  (cost=0.00..25.70 rows=1570 width=8) (actual time=0.028..0.029 rows=6 loops=3)
--                     ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.011..0.012 rows=8 loops=3)
--                           Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                           ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.008..0.009 rows=8 loops=3)
--               ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.008..0.008 rows=4 loops=3)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.005..0.006 rows=4 loops=3)
-- Planning Time: 0.561 ms
-- JIT:
--   Functions: 114
-- "  Options: Inlining true, Optimization true, Expressions true, Deforming true"
-- "  Timing: Generation 8.120 ms, Inlining 311.020 ms, Optimization 1135.609 ms, Emission 774.741 ms, Total 2229.490 ms"
-- Execution Time: 5830.678 ms
-- endregion

-- region result 10000000 ROWS ROWS AFTER INDEX Planning Time: 0.531 ms / Execution Time: 5919.546 ms (cost=970239.96..1294660.81 rows=2780556 width=530) (actual time=4615.500..5822.594 rows=3336285 loops=1)
-- Gather Merge  (cost=970239.96..1294660.81 rows=2780556 width=530) (actual time=4615.500..5822.594 rows=3336285 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=969239.93..972715.63 rows=1390278 width=530) (actual time=4581.544..4734.764 rows=1112095 loops=3)
--         Sort Key: p.price
--         Sort Method: external merge  Disk: 33760kB
--         Worker 0:  Sort Method: external merge  Disk: 35600kB
--         Worker 1:  Sort Method: external merge  Disk: 33552kB
--         ->  Hash Left Join  (cost=52.38..162110.32 rows=1390278 width=530) (actual time=708.379..3308.338 rows=1112095 loops=3)
--               Hash Cond: (s.movie_id = m.id)
--               ->  Hash Left Join  (cost=39.23..158370.36 rows=1390278 width=22) (actual time=708.362..2900.441 rows=1112095 loops=3)
--                     Hash Cond: (tickets.session_id = s.id)
--                     ->  Hash Join  (cost=2.23..154670.99 rows=1390278 width=22) (actual time=708.323..2462.795 rows=1112095 loops=3)
--                           Hash Cond: (tickets.zone_id = z.id)
--                           ->  Parallel Seq Scan on tickets  (cost=0.00..125125.35 rows=4170835 width=16) (actual time=0.098..1049.516 rows=3336668 loops=3)
--                           ->  Hash  (cost=2.20..2.20 rows=2 width=30) (actual time=708.168..708.171 rows=2 loops=3)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Hash Join  (cost=1.10..2.20 rows=2 width=30) (actual time=708.163..708.167 rows=2 loops=3)
--                                       Hash Cond: (z.id = p.zone_id)
--                                       ->  Seq Scan on zones z  (cost=0.00..1.06 rows=6 width=8) (actual time=0.010..0.011 rows=6 loops=3)
--                                       ->  Hash  (cost=1.07..1.07 rows=2 width=22) (actual time=708.129..708.130 rows=2 loops=3)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                             ->  Seq Scan on prices p  (cost=0.00..1.07 rows=2 width=22) (actual time=708.120..708.122 rows=2 loops=3)
--                                                   Filter: (price > '300'::numeric)
--                                                   Rows Removed by Filter: 4
--                     ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.027..0.027 rows=8 loops=3)
--                           Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                           ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.023..0.024 rows=8 loops=3)
--               ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.010..0.010 rows=4 loops=3)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.007..0.007 rows=4 loops=3)
-- Planning Time: 0.531 ms
-- JIT:
--   Functions: 114
-- "  Options: Inlining true, Optimization true, Expressions true, Deforming true"
-- "  Timing: Generation 5.247 ms, Inlining 321.304 ms, Optimization 1097.934 ms, Emission 705.132 ms, Total 2129.618 ms"
-- Execution Time: 5919.546 ms
-- endregion


EXPLAIN ANALYSE
    SELECT m.name, sum(p.price) as sum
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
GROUP BY m.id
ORDER BY sum DESC;
-- region result 4 ROWS  (cost=178.08..178.43 rows=140 width=556) (actual time=0.056..0.063 rows=3 loops=1)
-- Sort  (cost=178.08..178.43 rows=140 width=556) (actual time=0.056..0.063 rows=3 loops=1)
--   Sort Key: (sum(p.price)) DESC
--   Sort Method: quicksort  Memory: 25kB
--   ->  HashAggregate  (cost=171.34..173.09 rows=140 width=556) (actual time=0.049..0.057 rows=3 loops=1)
--         Group Key: m.id
--         Batches: 1  Memory Usage: 40kB
--         ->  Hash Left Join  (cost=128.10..166.84 rows=900 width=538) (actual time=0.034..0.048 rows=8 loops=1)
--               Hash Cond: (s.movie_id = m.id)
--               ->  Hash Left Join  (cost=114.95..151.28 rows=900 width=22) (actual time=0.027..0.039 rows=8 loops=1)
--                     Hash Cond: (tickets.session_id = s.id)
--                     ->  Hash Right Join  (cost=77.95..111.91 rows=900 width=22) (actual time=0.020..0.025 rows=8 loops=1)
--                           Hash Cond: (p.zone_id = z.id)
--                           ->  Seq Scan on prices p  (cost=0.00..22.30 rows=1230 width=22) (actual time=0.001..0.002 rows=6 loops=1)
--                           ->  Hash  (cost=66.70..66.70 rows=900 width=16) (actual time=0.015..0.016 rows=4 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Hash Left Join  (cost=45.33..66.70 rows=900 width=16) (actual time=0.013..0.015 rows=4 loops=1)
--                                       Hash Cond: (tickets.zone_id = z.id)
--                                       ->  Seq Scan on tickets  (cost=0.00..19.00 rows=900 width=16) (actual time=0.003..0.004 rows=4 loops=1)
--                                       ->  Hash  (cost=25.70..25.70 rows=1570 width=8) (actual time=0.005..0.005 rows=6 loops=1)
--                                             Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                             ->  Seq Scan on zones z  (cost=0.00..25.70 rows=1570 width=8) (actual time=0.002..0.003 rows=6 loops=1)
--                     ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.004..0.009 rows=8 loops=1)
--                           Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                           ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.002..0.003 rows=8 loops=1)
--               ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.004..0.005 rows=4 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.001..0.002 rows=4 loops=1)
-- Planning Time: 0.274 ms
-- Execution Time: 0.099 ms
-- endregion

-- region result 10000 ROWS Planning Time: 0.337 ms / Execution Time: 11.700 ms (cost=572.16..572.51 rows=140 width=556) (actual time=11.635..11.641 rows=4 loops=1)
-- Sort  (cost=572.16..572.51 rows=140 width=556) (actual time=11.635..11.641 rows=4 loops=1)
--   Sort Key: (sum(p.price)) DESC
--   Sort Method: quicksort  Memory: 25kB
--   ->  HashAggregate  (cost=565.42..567.17 rows=140 width=556) (actual time=11.625..11.631 rows=4 loops=1)
--         Group Key: m.id
--         Batches: 1  Memory Usage: 40kB
--         ->  Hash Left Join  (cost=140.64..515.40 rows=10004 width=538) (actual time=0.072..8.974 rows=15018 loops=1)
--               Hash Cond: (s.movie_id = m.id)
--               ->  Hash Left Join  (cost=127.49..475.43 rows=10004 width=22) (actual time=0.051..6.420 rows=15018 loops=1)
--                     Hash Cond: (tickets.session_id = s.id)
--                     ->  Hash Left Join  (cost=90.49..412.08 rows=10004 width=22) (actual time=0.040..3.624 rows=15018 loops=1)
--                           Hash Cond: (tickets.zone_id = z.id)
--                           ->  Seq Scan on tickets  (cost=0.00..184.04 rows=10004 width=16) (actual time=0.006..0.648 rows=10004 loops=1)
--                           ->  Hash  (cost=70.86..70.86 rows=1570 width=22) (actual time=0.028..0.031 rows=9 loops=1)
--                                 Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                 ->  Hash Right Join  (cost=45.33..70.86 rows=1570 width=22) (actual time=0.017..0.027 rows=9 loops=1)
--                                       Hash Cond: (p.zone_id = z.id)
--                                       ->  Seq Scan on prices p  (cost=0.00..22.30 rows=1230 width=22) (actual time=0.002..0.002 rows=6 loops=1)
--                                       ->  Hash  (cost=25.70..25.70 rows=1570 width=8) (actual time=0.009..0.009 rows=6 loops=1)
--                                             Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                             ->  Seq Scan on zones z  (cost=0.00..25.70 rows=1570 width=8) (actual time=0.004..0.005 rows=6 loops=1)
--                     ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.006..0.007 rows=8 loops=1)
--                           Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                           ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.003..0.004 rows=8 loops=1)
--               ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.005..0.005 rows=4 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.002..0.003 rows=4 loops=1)
-- Planning Time: 0.337 ms
-- Execution Time: 11.700 ms
-- endregion

-- region result 10000000 ROWS 1.754/10264.007 ms (cost=226684.06..226684.41 rows=140 width=556) (actual time=10253.073..10258.011 rows=4 loops=1)
-- Sort  (cost=226684.06..226684.41 rows=140 width=556) (actual time=10253.073..10258.011 rows=4 loops=1)
--   Sort Key: (sum(p.price)) DESC
--   Sort Method: quicksort  Memory: 25kB
--   ->  Finalize GroupAggregate  (cost=226642.55..226679.07 rows=140 width=556) (actual time=10253.055..10258.003 rows=4 loops=1)
--         Group Key: m.id
--         ->  Gather Merge  (cost=226642.55..226675.22 rows=280 width=556) (actual time=10253.033..10257.975 rows=12 loops=1)
--               Workers Planned: 2
--               Workers Launched: 2
--               ->  Sort  (cost=225642.53..225642.88 rows=140 width=556) (actual time=10232.315..10232.321 rows=4 loops=3)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 25kB
--                     Worker 0:  Sort Method: quicksort  Memory: 25kB
--                     Worker 1:  Sort Method: quicksort  Memory: 25kB
--                     ->  Partial HashAggregate  (cost=225635.79..225637.54 rows=140 width=556) (actual time=10232.285..10232.294 rows=4 loops=3)
--                           Group Key: m.id
--                           Batches: 1  Memory Usage: 40kB
--                           Worker 0:  Batches: 1  Memory Usage: 40kB
--                           Worker 1:  Batches: 1  Memory Usage: 40kB
--                           ->  Hash Left Join  (cost=140.64..204781.75 rows=4170808 width=538) (actual time=27.072..8140.426 rows=5005057 loops=3)
--                                 Hash Cond: (s.movie_id = m.id)
--                                 ->  Hash Left Join  (cost=127.49..193588.22 rows=4170808 width=22) (actual time=27.049..5415.573 rows=5005057 loops=3)
--                                       Hash Cond: (tickets.session_id = s.id)
--                                       ->  Hash Left Join  (cost=90.49..182564.18 rows=4170808 width=22) (actual time=27.018..3193.223 rows=5005057 loops=3)
--                                             Hash Cond: (tickets.zone_id = z.id)
--                                             ->  Parallel Seq Scan on tickets  (cost=0.00..125125.08 rows=4170808 width=16) (actual time=0.024..811.741 rows=3336668 loops=3)
--                                             ->  Hash  (cost=70.86..70.86 rows=1570 width=22) (actual time=26.973..26.975 rows=9 loops=3)
--                                                   Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                                   ->  Hash Right Join  (cost=45.33..70.86 rows=1570 width=22) (actual time=26.959..26.968 rows=9 loops=3)
--                                                         Hash Cond: (p.zone_id = z.id)
--                                                         ->  Seq Scan on prices p  (cost=0.00..22.30 rows=1230 width=22) (actual time=0.027..0.028 rows=6 loops=3)
--                                                         ->  Hash  (cost=25.70..25.70 rows=1570 width=8) (actual time=26.909..26.910 rows=6 loops=3)
--                                                               Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                                               ->  Seq Scan on zones z  (cost=0.00..25.70 rows=1570 width=8) (actual time=26.884..26.889 rows=6 loops=3)
--                                       ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.017..0.017 rows=8 loops=3)
--                                             Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                             ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.011..0.013 rows=8 loops=3)
--                                 ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.012..0.013 rows=4 loops=3)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                       ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.008..0.008 rows=4 loops=3)
-- Planning Time: 1.754 ms
-- JIT:
--   Functions: 126
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 9.639 ms, Inlining 0.000 ms, Optimization 2.527 ms, Emission 78.304 ms, Total 90.470 ms"
-- Execution Time: 10264.007 ms
-- endregion

-- region result 10000000 ROWS ROWS AFTER INDEX Planning Time: 0.342 ms / Execution Time: 10165.813 ms  (cost=226596.78..226597.13 rows=140 width=556) (actual time=10156.797..10163.808 rows=4 loops=1)
-- Sort  (cost=226596.78..226597.13 rows=140 width=556) (actual time=10156.797..10163.808 rows=4 loops=1)
--   Sort Key: (sum(p.price)) DESC
--   Sort Method: quicksort  Memory: 25kB
--   ->  Finalize GroupAggregate  (cost=226555.27..226591.79 rows=140 width=556) (actual time=10156.779..10163.799 rows=4 loops=1)
--         Group Key: m.id
--         ->  Gather Merge  (cost=226555.27..226587.94 rows=280 width=556) (actual time=10156.756..10163.768 rows=12 loops=1)
--               Workers Planned: 2
--               Workers Launched: 2
--               ->  Sort  (cost=225555.25..225555.60 rows=140 width=556) (actual time=10142.665..10142.671 rows=4 loops=3)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 25kB
--                     Worker 0:  Sort Method: quicksort  Memory: 25kB
--                     Worker 1:  Sort Method: quicksort  Memory: 25kB
--                     ->  Partial HashAggregate  (cost=225548.51..225550.26 rows=140 width=556) (actual time=10142.644..10142.652 rows=4 loops=3)
--                           Group Key: m.id
--                           Batches: 1  Memory Usage: 40kB
--                           Worker 0:  Batches: 1  Memory Usage: 40kB
--                           Worker 1:  Batches: 1  Memory Usage: 40kB
--                           ->  Hash Left Join  (cost=52.45..204694.33 rows=4170835 width=538) (actual time=22.096..8015.881 rows=5005057 loops=3)
--                                 Hash Cond: (s.movie_id = m.id)
--                                 ->  Hash Left Join  (cost=39.30..193500.74 rows=4170835 width=22) (actual time=21.990..5643.160 rows=5005057 loops=3)
--                                       Hash Cond: (tickets.session_id = s.id)
--                                       ->  Hash Left Join  (cost=2.30..182476.63 rows=4170835 width=22) (actual time=21.969..3337.854 rows=5005057 loops=3)
--                                             Hash Cond: (tickets.zone_id = z.id)
--                                             ->  Parallel Seq Scan on tickets  (cost=0.00..125125.35 rows=4170835 width=16) (actual time=0.477..961.974 rows=3336668 loops=3)
--                                             ->  Hash  (cost=2.22..2.22 rows=6 width=22) (actual time=21.475..21.477 rows=9 loops=3)
--                                                   Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                                   ->  Hash Right Join  (cost=1.14..2.22 rows=6 width=22) (actual time=21.466..21.472 rows=9 loops=3)
--                                                         Hash Cond: (p.zone_id = z.id)
--                                                         ->  Seq Scan on prices p  (cost=0.00..1.06 rows=6 width=22) (actual time=0.018..0.018 rows=6 loops=3)
--                                                         ->  Hash  (cost=1.06..1.06 rows=6 width=8) (actual time=21.434..21.435 rows=6 loops=3)
--                                                               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                                               ->  Seq Scan on zones z  (cost=0.00..1.06 rows=6 width=8) (actual time=21.414..21.419 rows=6 loops=3)
--                                       ->  Hash  (cost=22.00..22.00 rows=1200 width=16) (actual time=0.010..0.010 rows=8 loops=3)
--                                             Buckets: 2048  Batches: 1  Memory Usage: 17kB
--                                             ->  Seq Scan on sessions s  (cost=0.00..22.00 rows=1200 width=16) (actual time=0.006..0.007 rows=8 loops=3)
--                                 ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.013..0.013 rows=4 loops=3)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                       ->  Seq Scan on movies m  (cost=0.00..11.40 rows=140 width=524) (actual time=0.009..0.009 rows=4 loops=3)
-- Planning Time: 0.342 ms
-- JIT:
--   Functions: 126
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 4.122 ms, Inlining 0.000 ms, Optimization 2.209 ms, Emission 62.150 ms, Total 68.481 ms"
-- Execution Time: 10165.813 ms
-- endregion

DROP index indx_tickets_place;
DROP index indx_tickets_session_id;
DROP index indx_tickets_zone_id;

CREATE INDEX indx_tickets_place ON tickets (place);
CREATE INDEX indx_tickets_session_id ON tickets (session_id);
CREATE INDEX indx_tickets_zone_id ON tickets (zone_id);