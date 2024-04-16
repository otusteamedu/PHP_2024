SELECT s.id AS session_id, MIN(t.price) AS min_price, MAX(t.price) AS max_price
FROM db.sessions s
         JOIN db.tickets t ON s.id = t.session_id
WHERE s.id = 131944
GROUP BY s.id;

/*
 10000
 GroupAggregate  (cost=0.29..203.33 rows=1 width=68) (actual time=0.592..0.593 rows=1 loops=1)
  ->  Nested Loop  (cost=0.29..203.31 rows=1 width=10) (actual time=0.131..0.588 rows=1 loops=1)
        ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.29..4.30 rows=1 width=4) (actual time=0.017..0.019 rows=1 loops=1)
              Index Cond: (id = 131944)
              Heap Fetches: 0
        ->  Seq Scan on tickets t  (cost=0.00..199.00 rows=1 width=10) (actual time=0.114..0.567 rows=1 loops=1)
              Filter: (session_id = 131944)
              Rows Removed by Filter: 9999
Planning Time: 0.113 ms
Execution Time: 0.632 ms

 10000000
GroupAggregate  (cost=1000.43..126617.31 rows=1 width=68) (actual time=186.807..190.917 rows=1 loops=1)
  ->  Nested Loop  (cost=1000.43..126617.29 rows=1 width=10) (actual time=7.334..190.872 rows=1 loops=1)
        ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.028..0.033 rows=1 loops=1)
              Index Cond: (id = 171720)
              Heap Fetches: 0
        ->  Gather  (cost=1000.00..126612.83 rows=1 width=10) (actual time=7.298..190.829 rows=1 loops=1)
              Workers Planned: 2
              Workers Launched: 2
              ->  Parallel Seq Scan on tickets t  (cost=0.00..125612.73 rows=1 width=10) (actual time=112.821..172.560 rows=0 loops=3)
                    Filter: (session_id = 171720)
                    Rows Removed by Filter: 3333333
Planning Time: 0.137 ms
JIT:
  Functions: 16
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 1.030 ms, Inlining 0.000 ms, Optimization 0.561 ms, Emission 11.081 ms, Total 12.672 ms
Execution Time: 191.500 ms

   Добавление индекса CREATE INDEX idx_tickets_session_seat ON db.tickets (session_id, seat_id);

 Итог:
 GroupAggregate  (cost=0.87..12.93 rows=1 width=68) (actual time=0.010..0.011 rows=0 loops=1)
  ->  Nested Loop  (cost=0.87..12.91 rows=1 width=10) (actual time=0.010..0.010 rows=0 loops=1)
        ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.009..0.010 rows=0 loops=1)
              Index Cond: (id = 131944)
              Heap Fetches: 0
        ->  Index Scan using indx_tickets_session_seat on tickets t  (cost=0.43..8.45 rows=1 width=10) (never executed)
              Index Cond: (session_id = 131944)
Planning Time: 0.180 ms
Execution Time: 0.035 ms
 */
