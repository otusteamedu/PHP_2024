SELECT m.title, m.release_year, s.start_time
FROM db.movies m
         JOIN db.sessions s ON m.id = s.movie_id
WHERE DATE(s.start_time) = CURRENT_DATE
ORDER BY s.start_time;

/*
10000
Sort Method: quicksort  Memory: 46kB
  ->  Merge Join  (cost=501.61..505.89 rows=100 width=21) (actual time=2.064..2.139 rows=449 loops=1)
        Merge Cond: (m.id = s.movie_id)
        ->  Index Scan using movies_pkey on movies m  (cost=0.29..337.29 rows=10000 width=17) (actual time=0.006..0.015 rows=78 loops=1)
        ->  Sort  (cost=501.32..501.57 rows=100 width=12) (actual time=2.053..2.067 rows=449 loops=1)
              Sort Key: s.movie_id
              Sort Method: quicksort  Memory: 42kB
              ->  Seq Scan on sessions s  (cost=0.00..498.00 rows=100 width=12) (actual time=0.014..1.995 rows=449 loops=1)
                    Filter: (date(start_time) = CURRENT_DATE)
                    Rows Removed by Filter: 19551
Planning Time: 0.202 ms
Execution Time: 2.248 ms

10000000
Gather Merge  (cost=149285.39..154146.77 rows=41666 width=21) (actual time=420.244..471.668 rows=237001 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=148285.37..148337.45 rows=20833 width=21) (actual time=386.539..395.990 rows=79000 loops=3)
        Sort Key: s.start_time
        Sort Method: external merge  Disk: 2928kB
        Worker 0:  Sort Method: external merge  Disk: 2544kB
        Worker 1:  Sort Method: external merge  Disk: 2440kB
        ->  Hash Join  (cost=289.00..146790.96 rows=20833 width=21) (actual time=13.226..360.339 rows=79000 loops=3)
              Hash Cond: (s.movie_id = m.id)
              ->  Parallel Seq Scan on sessions s  (cost=0.00..146447.25 rows=20833 width=12) (actual time=10.408..331.689 rows=79000 loops=3)
                    Filter: (date(start_time) = CURRENT_DATE)
                    Rows Removed by Filter: 3254333
              ->  Hash  (cost=164.00..164.00 rows=10000 width=17) (actual time=2.663..2.665 rows=10000 loops=3)
                    Buckets: 16384  Batches: 1  Memory Usage: 636kB
                    ->  Seq Scan on movies m  (cost=0.00..164.00 rows=10000 width=17) (actual time=0.070..1.013 rows=10000 loops=3)
Planning Time: 0.173 ms
JIT:
  Functions: 39
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 1.683 ms, Inlining 0.000 ms, Optimization 1.339 ms, Emission 29.785 ms, Total 32.806 ms
Execution Time: 479.466 ms

 Добавление индекса CREATE INDEX idx_sessions_start_time ON db.sessions (start_time);
изменение запроса, чтобы использовался индекс
SELECT m.title, m.release_year, s.start_time
FROM db.movies m
         JOIN db.sessions s ON m.id = s.movie_id
WHERE s.start_time >= CURRENT_DATE AND s.start_time < CURRENT_DATE + INTERVAL '1 day'
ORDER BY s.start_time;

Итог:
Nested Loop  (cost=0.44..117106.00 rows=261271 width=21) (actual time=3.138..49.487 rows=237001 loops=1)
  ->  Seq Scan on movies m  (cost=0.00..164.00 rows=10000 width=17) (actual time=0.009..0.548 rows=10000 loops=1)
  ->  Index Only Scan using idx_sessions_start_time on sessions s  (cost=0.44..9.08 rows=261 width=12) (actual time=0.001..0.003 rows=24 loops=10000)
        Index Cond: ((movie_id = m.id) AND (start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
        Heap Fetches: 0
Planning Time: 0.207 ms
JIT:
  Functions: 6
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 0.268 ms, Inlining 0.000 ms, Optimization 0.177 ms, Emission 2.869 ms, Total 3.314 ms
Execution Time: 56.111 ms
*/
