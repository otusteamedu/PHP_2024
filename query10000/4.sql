-- Поиск 3 самых прибыльных фильмов за неделю
EXPLAIN ANALYSE
SELECT movies.title, SUM(tickets.price) AS total_revenue
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN tickets ON tickets.session_id = sessions.id
WHERE tickets.date >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY movies.id
ORDER BY total_revenue DESC
    LIMIT 3;

-- Limit  (cost=409302.79..409302.80 rows=3 width=54) (actual time=5015.992..5032.062 rows=3 loops=1)
--   ->  Sort  (cost=409302.79..410296.75 rows=397586 width=54) (actual time=5004.004..5020.072 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=355153.32..404164.06 rows=397586 width=54) (actual time=3910.931..4838.543 rows=350229 loops=1)
--               Group Key: movies.id
--               ->  Gather Merge  (cost=355153.32..396709.32 rows=331322 width=54) (actual time=3910.914..4293.054 rows=350229 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=354153.30..357466.52 rows=165661 width=54) (actual time=3897.294..4016.603 rows=116743 loops=3)
--                           Group Key: movies.id
--                           ->  Sort  (cost=354153.30..354567.45 rows=165661 width=27) (actual time=3897.257..3915.994 rows=116743 loops=3)
--                                 Sort Key: movies.id
--                                 Sort Method: quicksort  Memory: 12123kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 12200kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 12256kB
--                                 ->  Nested Loop  (cost=0.87..339792.25 rows=165661 width=27) (actual time=8.466..3806.970 rows=116743 loops=3)
--                                       ->  Nested Loop  (cost=0.43..263170.27 rows=165661 width=9) (actual time=8.438..1879.971 rows=116743 loops=3)
--                                             ->  Parallel Seq Scan on tickets  (cost=0.00..146446.67 rows=165661 width=9) (actual time=8.398..947.171 rows=116743 loops=3)
--                                                   Filter: (date >= (CURRENT_DATE - '7 days'::interval))
--                                                   Rows Removed by Filter: 3216590
--                                             ->  Index Scan using sessions_pk on sessions  (cost=0.43..0.70 rows=1 width=8) (actual time=0.007..0.007 rows=1 loops=350229)
--                                                   Index Cond: (id = tickets.session_id)
--                                       ->  Index Scan using movies_pkey on movies  (cost=0.43..0.46 rows=1 width=22) (actual time=0.015..0.015 rows=1 loops=350229)
--                                             Index Cond: (id = sessions.movie_id)
-- Planning Time: 1.391 ms
-- JIT:
--   Functions: 58
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 3.215 ms, Inlining 0.000 ms, Optimization 1.468 ms, Emission 35.690 ms, Total 40.373 ms"
-- Execution Time: 5033.646 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (start_time);
CREATE INDEX ON tickets (session_id);
CREATE INDEX ON tickets (date);

-- Limit  (cost=342737.62..342737.63 rows=3 width=54) (actual time=4820.057..4843.581 rows=3 loops=1)
--   ->  Sort  (cost=342737.62..343731.58 rows=397586 width=54) (actual time=4806.528..4830.049 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=288588.15..337598.89 rows=397586 width=54) (actual time=3686.314..4644.639 rows=350229 loops=1)
--               Group Key: movies.id
--               ->  Gather Merge  (cost=288588.15..330144.15 rows=331322 width=54) (actual time=3686.299..4201.075 rows=350229 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=287588.13..290901.35 rows=165661 width=54) (actual time=3673.969..3821.985 rows=116743 loops=3)
--                           Group Key: movies.id
--                           ->  Sort  (cost=287588.13..288002.28 rows=165661 width=27) (actual time=3673.940..3693.391 rows=116743 loops=3)
--                                 Sort Key: movies.id
--                                 Sort Method: quicksort  Memory: 12791kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 12048kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 11740kB
--                                 ->  Nested Loop  (cost=3453.30..273227.08 rows=165661 width=27) (actual time=58.847..3588.491 rows=116743 loops=3)
--                                       ->  Nested Loop  (cost=3452.87..196605.10 rows=165661 width=9) (actual time=58.805..1994.133 rows=116743 loops=3)
--                                             ->  Parallel Bitmap Heap Scan on tickets  (cost=3452.43..79881.50 rows=165661 width=9) (actual time=21.860..245.394 rows=116743 loops=3)
--                                                   Recheck Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                                                   Heap Blocks: exact=25941
--                                                   ->  Bitmap Index Scan on tickets_date_idx  (cost=0.00..3353.03 rows=397586 width=0) (actual time=23.919..23.920 rows=350229 loops=1)
--                                                         Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                                             ->  Index Scan using sessions_pk on sessions  (cost=0.43..0.70 rows=1 width=8) (actual time=0.013..0.013 rows=1 loops=350229)
--                                                   Index Cond: (id = tickets.session_id)
--                                       ->  Index Scan using movies_pkey on movies  (cost=0.43..0.46 rows=1 width=22) (actual time=0.012..0.012 rows=1 loops=350229)
--                                             Index Cond: (id = sessions.movie_id)
-- Planning Time: 6.355 ms
-- JIT:
--   Functions: 61
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 3.670 ms, Inlining 0.000 ms, Optimization 2.330 ms, Emission 108.633 ms, Total 114.633 ms"
-- Execution Time: 4845.672 ms

