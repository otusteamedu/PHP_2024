SELECT s.row_number, s.seat_number, t.id
FROM db.halls h
         JOIN db.sessions ses on ses.hall_id = h.id
         JOIN db.seats s ON s.hall_id = h.id
         LEFT JOIN db.tickets t ON t.seat_id = s.id and t.seat_id = ses.id
WHERE ses.id = 131944
ORDER BY h.id, s.row_number, s.seat_number

/*
 10000
 Sort  (cost=2464.88..2464.96 rows=30 width=16) (actual time=4.764..4.767 rows=30 loops=1)
  Sort Key: h.id, s.row_number, s.seat_number
  Sort Method: quicksort  Memory: 26kB
  ->  Nested Loop Left Join  (cost=0.99..2464.15 rows=30 width=16) (actual time=0.671..4.748 rows=30 loops=1)
        Join Filter: (t.seat_id = s.id)
        ->  Nested Loop  (cost=0.99..2264.69 rows=30 width=20) (actual time=0.095..4.162 rows=30 loops=1)
              Join Filter: (s.hall_id = ses.hall_id)
              ->  Nested Loop  (cost=0.57..12.61 rows=1 width=12) (actual time=0.022..0.025 rows=1 loops=1)
                    ->  Index Scan using sessions_pkey on sessions ses  (cost=0.29..8.30 rows=1 width=8) (actual time=0.013..0.015 rows=1 loops=1)
                          Index Cond: (id = 131944)
                    ->  Index Only Scan using halls_pkey on halls h  (cost=0.29..4.30 rows=1 width=4) (actual time=0.005..0.005 rows=1 loops=1)
                          Index Cond: (id = ses.hall_id)
                          Heap Fetches: 0
              ->  Index Scan using seat_number_hall_id on seats s  (cost=0.42..2251.71 rows=30 width=16) (actual time=0.070..4.125 rows=30 loops=1)
                    Index Cond: (hall_id = h.id)
        ->  Materialize  (cost=0.00..199.00 rows=1 width=8) (actual time=0.019..0.019 rows=0 loops=30)
              ->  Seq Scan on tickets t  (cost=0.00..199.00 rows=1 width=8) (actual time=0.572..0.572 rows=0 loops=1)
                    Filter: (seat_id = 131944)
                    Rows Removed by Filter: 10000
Planning Time: 0.870 ms
Execution Time: 4.819 ms

 10000000
Incremental Sort  (cost=129188.10..129188.50 rows=30 width=16) (actual time=216.343..216.419 rows=30 loops=1)
  Sort Key: h.id, s.row_number, s.seat_number
  Presorted Key: h.id
  Full-sort Groups: 1  Sort Method: quicksort  Average Memory: 26kB  Peak Memory: 26kB
  ->  Nested Loop Left Join  (cost=1009.17..129187.36 rows=30 width=16) (actual time=212.207..216.397 rows=30 loops=1)
        Join Filter: (t.seat_id = s.id)
        ->  Nested Loop  (cost=9.17..2555.85 rows=30 width=20) (actual time=9.900..14.004 rows=30 loops=1)
              Join Filter: (s.hall_id = ses.hall_id)
              ->  Merge Join  (cost=8.75..303.76 rows=1 width=12) (actual time=9.811..9.818 rows=1 loops=1)
                    Merge Cond: (h.id = ses.hall_id)
                    ->  Index Only Scan using halls_pkey on halls h  (cost=0.29..270.29 rows=10000 width=4) (actual time=0.016..0.448 rows=5489 loops=1)
                          Heap Fetches: 0
                    ->  Sort  (cost=8.46..8.47 rows=1 width=8) (actual time=0.048..0.050 rows=1 loops=1)
                          Sort Key: ses.hall_id
                          Sort Method: quicksort  Memory: 25kB
                          ->  Index Scan using sessions_pkey on sessions ses  (cost=0.43..8.45 rows=1 width=8) (actual time=0.033..0.034 rows=1 loops=1)
                                Index Cond: (id = 171720)
              ->  Index Scan using seat_number_hall_id on seats s  (cost=0.42..2251.71 rows=30 width=16) (actual time=0.081..4.168 rows=30 loops=1)
                    Index Cond: (hall_id = h.id)
        ->  Materialize  (cost=1000.00..126616.30 rows=34 width=8) (actual time=6.742..6.745 rows=0 loops=30)
              ->  Gather  (cost=1000.00..126616.13 rows=34 width=8) (actual time=202.267..202.340 rows=0 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Parallel Seq Scan on tickets t  (cost=0.00..125612.73 rows=14 width=8) (actual time=189.565..189.565 rows=0 loops=3)
                          Filter: (seat_id = 171720)
                          Rows Removed by Filter: 3333333
Planning Time: 0.294 ms
JIT:
  Functions: 32
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 1.158 ms, Inlining 0.000 ms, Optimization 0.594 ms, Emission 14.212 ms, Total 15.964 ms
Execution Time: 217.169 ms

  Добавление индекса CREATE INDEX idx_tickets_session_seat ON db.tickets (session_id, seat_id);

 Итог:
 Sort  (cost=2274.48..2274.56 rows=30 width=16) (actual time=3.759..3.762 rows=30 loops=1)
  Sort Key: h.id, s.row_number, s.seat_number
  Sort Method: quicksort  Memory: 26kB
  ->  Nested Loop Left Join  (cost=1.58..2273.75 rows=30 width=16) (actual time=0.112..3.743 rows=30 loops=1)
        Join Filter: (t.seat_id = s.id)
        Rows Removed by Join Filter: 30
        ->  Nested Loop  (cost=1.14..2264.84 rows=30 width=20) (actual time=0.088..3.702 rows=30 loops=1)
              Join Filter: (s.hall_id = ses.hall_id)
              ->  Nested Loop  (cost=0.72..12.76 rows=1 width=12) (actual time=0.017..0.020 rows=1 loops=1)
                    ->  Index Scan using sessions_pkey on sessions ses  (cost=0.43..8.45 rows=1 width=8) (actual time=0.011..0.013 rows=1 loops=1)
                          Index Cond: (id = 171720)
                    ->  Index Only Scan using halls_pkey on halls h  (cost=0.29..4.30 rows=1 width=4) (actual time=0.004..0.004 rows=1 loops=1)
                          Index Cond: (id = ses.hall_id)
                          Heap Fetches: 0
              ->  Index Scan using seat_number_hall_id on seats s  (cost=0.42..2251.71 rows=30 width=16) (actual time=0.070..3.670 rows=30 loops=1)
                    Index Cond: (hall_id = h.id)
        ->  Materialize  (cost=0.43..8.46 rows=1 width=12) (actual time=0.001..0.001 rows=1 loops=30)
              ->  Index Scan using idx_tickets_session_seat on tickets t  (cost=0.43..8.45 rows=1 width=12) (actual time=0.019..0.020 rows=1 loops=1)
                    Index Cond: (session_id = 171720)
Planning Time: 0.596 ms
Execution Time: 3.799 ms
 */
