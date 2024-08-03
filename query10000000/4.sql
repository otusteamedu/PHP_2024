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

-- Limit  (cost=361355.08..361355.09 rows=3 width=54) (actual time=6216.566..6239.481 rows=3 loops=1)
--   ->  Sort  (cost=361355.08..362430.42 rows=430138 width=54) (actual time=6204.776..6227.690 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=302772.27..355795.63 rows=430138 width=54) (actual time=4999.017..6034.548 rows=397265 loops=1)
--               Group Key: movies.id
--               ->  Gather Merge  (cost=302772.27..347730.54 rows=358448 width=54) (actual time=4998.992..5536.220 rows=397265 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=301772.24..305356.72 rows=179224 width=54) (actual time=4986.177..5144.634 rows=132422 loops=3)
--                           Group Key: movies.id
--                           ->  Sort  (cost=301772.24..302220.30 rows=179224 width=27) (actual time=4986.138..5007.045 rows=132422 loops=3)
--                                 Sort Key: movies.id
--                                 Sort Method: quicksort  Memory: 14553kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 13151kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 13259kB
--                                 ->  Nested Loop  (cost=3712.18..286133.69 rows=179224 width=27) (actual time=43.449..4906.980 rows=132422 loops=3)
--                                       ->  Nested Loop  (cost=3711.74..203238.51 rows=179224 width=9) (actual time=40.814..3143.525 rows=132422 loops=3)
--                                             ->  Parallel Bitmap Heap Scan on tickets  (cost=3711.31..80377.73 rows=179224 width=9) (actual time=23.585..420.736 rows=132422 loops=3)
--                                                   Recheck Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                                                   Heap Blocks: exact=25428
--                                                   ->  Bitmap Index Scan on tickets_date_idx2  (cost=0.00..3603.77 rows=430138 width=0) (actual time=23.394..23.394 rows=397265 loops=1)
--                                                         Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                                             ->  Index Scan using sessions_pk on sessions  (cost=0.43..0.69 rows=1 width=8) (actual time=0.019..0.019 rows=1 loops=397265)
--                                                   Index Cond: (id = tickets.session_id)
--                                       ->  Index Scan using movies_pkey on movies  (cost=0.43..0.46 rows=1 width=22) (actual time=0.012..0.012 rows=1 loops=397265)
--                                             Index Cond: (id = sessions.movie_id)
-- Planning Time: 9.518 ms
-- JIT:
--   Functions: 61
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 4.292 ms, Inlining 0.000 ms, Optimization 1.454 ms, Emission 34.586 ms, Total 40.332 ms"
-- Execution Time: 6241.424 ms



CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (start_time);
CREATE INDEX ON tickets (session_id);
CREATE INDEX ON tickets (date);

-- Limit  (cost=361355.08..361355.09 rows=3 width=54) (actual time=6056.253..6082.703 rows=3 loops=1)
--   ->  Sort  (cost=361355.08..362430.42 rows=430138 width=54) (actual time=6040.169..6066.618 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=302772.27..355795.63 rows=430138 width=54) (actual time=4751.229..5904.093 rows=397265 loops=1)
--               Group Key: movies.id
--               ->  Gather Merge  (cost=302772.27..347730.54 rows=358448 width=54) (actual time=4751.215..5302.643 rows=397265 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=301772.24..305356.72 rows=179224 width=54) (actual time=4738.052..4891.932 rows=132422 loops=3)
--                           Group Key: movies.id
--                           ->  Sort  (cost=301772.24..302220.30 rows=179224 width=27) (actual time=4738.020..4759.984 rows=132422 loops=3)
--                                 Sort Key: movies.id
--                                 Sort Method: quicksort  Memory: 14745kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 12950kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 13268kB
--                                 ->  Nested Loop  (cost=3712.18..286133.69 rows=179224 width=27) (actual time=100.507..4600.548 rows=132422 loops=3)
--                                       ->  Nested Loop  (cost=3711.74..203238.51 rows=179224 width=9) (actual time=96.437..2449.030 rows=132422 loops=3)
--                                             ->  Parallel Bitmap Heap Scan on tickets  (cost=3711.31..80377.73 rows=179224 width=9) (actual time=89.178..935.806 rows=132422 loops=3)
--                                                   Recheck Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                                                   Heap Blocks: exact=25820
--                                                   ->  Bitmap Index Scan on tickets_date_idx2  (cost=0.00..3603.77 rows=430138 width=0) (actual time=90.891..90.891 rows=397265 loops=1)
--                                                         Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                                             ->  Index Scan using sessions_pk on sessions  (cost=0.43..0.69 rows=1 width=8) (actual time=0.010..0.010 rows=1 loops=397265)
--                                                   Index Cond: (id = tickets.session_id)
--                                       ->  Index Scan using movies_pkey on movies  (cost=0.43..0.46 rows=1 width=22) (actual time=0.015..0.015 rows=1 loops=397265)
--                                             Index Cond: (id = sessions.movie_id)
-- Planning Time: 6.910 ms
-- JIT:
--   Functions: 61
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 10.721 ms, Inlining 0.000 ms, Optimization 3.661 ms, Emission 33.950 ms, Total 48.331 ms"
-- Execution Time: 6089.359 ms


