explain analyse
select f.name,
       s.start_time
from films f
         join films_sessions s on f.id = s.film_id
where s.start_time = CURRENT_DATE;


/*
Nested Loop  (cost=0.29..252.30 rows=1 width=50) (actual time=0.464..0.464 rows=0 loops=1)
  ->  Seq Scan on films_sessions s  (cost=0.00..244.00 rows=1 width=16) (actual time=0.463..0.463 rows=0 loops=1)
        Filter: (start_time = CURRENT_DATE)
        Rows Removed by Filter: 10000
  ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=50) (never executed)
        Index Cond: (id = s.film_id)
Planning Time: 0.113 ms
Execution Time: 0.475 ms

*/

CREATE INDEX idx_session_start ON films_sessions (start_time);


/*
Nested Loop  (cost=0.57..16.61 rows=1 width=50) (actual time=0.027..0.027 rows=0 loops=1)
  ->  Index Scan using idx_session_start on films_sessions s  (cost=0.29..8.30 rows=1 width=16) (actual time=0.027..0.027 rows=0 loops=1)
        Index Cond: (start_time = CURRENT_DATE)
  ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=50) (never executed)
        Index Cond: (id = s.film_id)
Planning Time: 0.259 ms
Execution Time: 0.042 ms

*/
