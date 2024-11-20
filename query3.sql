SELECT m.title, s.start_time
FROM db.movies m
         JOIN db.sessions s ON m.id = s.movie_id
WHERE DATE(s.start_time) = CURRENT_DATE;

/*
 10000
 Merge Join  (cost=501.61..505.89 rows=100 width=17) (actual time=2.252..2.325 rows=449 loops=1)
  Merge Cond: (m.id = s.movie_id)
  ->  Index Scan using movies_pkey on movies m  (cost=0.29..337.29 rows=10000 width=13) (actual time=0.091..0.101 rows=78 loops=1)
  ->  Sort  (cost=501.32..501.57 rows=100 width=12) (actual time=2.116..2.132 rows=449 loops=1)
        Sort Key: s.movie_id
        Sort Method: quicksort  Memory: 42kB
        ->  Seq Scan on sessions s  (cost=0.00..498.00 rows=100 width=12) (actual time=0.019..1.997 rows=449 loops=1)
              Filter: (date(start_time) = CURRENT_DATE)
              Rows Removed by Filter: 19551
Planning Time: 0.624 ms
Execution Time: 2.429 ms

 10000000
 Nested Loop  (cost=1000.29..154007.49 rows=50000 width=17) (actual time=13.284..359.985 rows=237001 loops=1)
  ->  Gather  (cost=1000.00..152447.25 rows=50000 width=12) (actual time=6.065..270.301 rows=237001 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Parallel Seq Scan on sessions s  (cost=0.00..146447.25 rows=20833 width=12) (actual time=4.010..298.747 rows=79000 loops=3)
              Filter: (date(start_time) = CURRENT_DATE)
              Rows Removed by Filter: 3254333
  ->  Memoize  (cost=0.30..0.32 rows=1 width=13) (actual time=0.000..0.000 rows=1 loops=237001)
        Cache Key: s.movie_id
        Cache Mode: logical
        Hits: 236001  Misses: 1000  Evictions: 0  Overflows: 0  Memory Usage: 113kB
        ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.31 rows=1 width=13) (actual time=0.008..0.008 rows=1 loops=1000)
              Index Cond: (id = s.movie_id)
Planning Time: 0.150 ms
JIT:
  Functions: 22
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 0.913 ms, Inlining 0.000 ms, Optimization 0.535 ms, Emission 11.313 ms, Total 12.761 ms
Execution Time: 367.689 ms

 Добавление индекса CREATE INDEX idx_sessions_start_time ON db.sessions (start_time);
 изменеине запроса, чтобы индекс работал
 SELECT m.title, s.start_time
FROM db.movies m
JOIN db.sessions s ON m.id = s.movie_id
WHERE s.start_time >= CURRENT_DATE AND s.start_time < CURRENT_DATE + INTERVAL '1 day';

 Итог:
 Nested Loop  (cost=0.44..117106.00 rows=261271 width=17) (actual time=3.093..49.812 rows=237001 loops=1)
  ->  Seq Scan on movies m  (cost=0.00..164.00 rows=10000 width=13) (actual time=0.007..0.570 rows=10000 loops=1)
  ->  Index Only Scan using idx_sessions_start_time on sessions s  (cost=0.44..9.08 rows=261 width=12) (actual time=0.001..0.003 rows=24 loops=10000)
        Index Cond: ((movie_id = m.id) AND (start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
        Heap Fetches: 0
Planning Time: 0.206 ms
JIT:
  Functions: 6
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 0.281 ms, Inlining 0.000 ms, Optimization 0.150 ms, Emission 2.886 ms, Total 3.317 ms
Execution Time: 56.454 ms
 */
