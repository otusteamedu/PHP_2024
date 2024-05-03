explain analyse
select f.name,
       s.start_time
from films f
         join films_sessions s on f.id = s.film_id
where s.start_time = CURRENT_DATE;


/*
Nested Loop  (cost=1000.42..16604.54 rows=1 width=50) (actual time=17.286..19.915 rows=0 loops=1)
  ->  Gather  (cost=1000.00..16596.10 rows=1 width=16) (actual time=17.285..19.914 rows=0 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Parallel Seq Scan on films_sessions s  (cost=0.00..15596.00 rows=1 width=16) (actual time=15.766..15.767 rows=0 loops=3)
              Filter: (start_time = CURRENT_DATE)
              Rows Removed by Filter: 333333
  ->  Index Scan using films_pkey on films f  (cost=0.42..8.44 rows=1 width=50) (never executed)
        Index Cond: (id = s.film_id)
Planning Time: 0.106 ms
Execution Time: 19.929 ms

*/

CREATE INDEX idx_session_start ON films_sessions (start_time);


/*
Nested Loop  (cost=0.85..16.89 rows=1 width=50) (actual time=0.011..0.012 rows=0 loops=1)
  ->  Index Scan using idx_session_start on films_sessions s  (cost=0.43..8.45 rows=1 width=16) (actual time=0.011..0.011 rows=0 loops=1)
        Index Cond: (start_time = CURRENT_DATE)
  ->  Index Scan using films_pkey on films f  (cost=0.42..8.44 rows=1 width=50) (never executed)
        Index Cond: (id = s.film_id)
Planning Time: 0.191 ms
Execution Time: 0.023 ms

*/
