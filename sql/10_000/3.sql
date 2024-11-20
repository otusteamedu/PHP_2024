explain analyse
select f.name as films_name,
       h.name as hall_name,
       s.start_time,
       s.end_time
from films f
         join films_sessions s on f.id = s.film_id
         join halls h on s.hall_id = h.id
where s.start_time = CURRENT_DATE
order by h.name,
         s.start_time;


/*
Sort  (cost=260.59..260.60 rows=1 width=574) (actual time=0.552..0.553 rows=0 loops=1)
  Sort Key: h.name
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=0.43..260.58 rows=1 width=574) (actual time=0.548..0.549 rows=0 loops=1)
        ->  Nested Loop  (cost=0.29..252.30 rows=1 width=66) (actual time=0.548..0.548 rows=0 loops=1)
              ->  Seq Scan on films_sessions s  (cost=0.00..244.00 rows=1 width=32) (actual time=0.548..0.548 rows=0 loops=1)
                    Filter: (start_time = CURRENT_DATE)
                    Rows Removed by Filter: 10000
              ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=50) (never executed)
                    Index Cond: (id = s.film_id)
        ->  Index Scan using halls_pkey on halls h  (cost=0.14..8.16 rows=1 width=524) (never executed)
              Index Cond: (id = s.hall_id)
Planning Time: 0.167 ms
Execution Time: 0.570 ms


*/

CREATE INDEX idx_session_start ON films_sessions (start_time);


/*
Sort  (cost=24.90..24.90 rows=1 width=574) (actual time=0.009..0.009 rows=0 loops=1)
  Sort Key: h.name
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=0.72..24.89 rows=1 width=574) (actual time=0.005..0.006 rows=0 loops=1)
        ->  Nested Loop  (cost=0.57..16.61 rows=1 width=66) (actual time=0.005..0.005 rows=0 loops=1)
              ->  Index Scan using idx_session_start on films_sessions s  (cost=0.29..8.30 rows=1 width=32) (actual time=0.005..0.005 rows=0 loops=1)
                    Index Cond: (start_time = CURRENT_DATE)
              ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=50) (never executed)
                    Index Cond: (id = s.film_id)
        ->  Index Scan using halls_pkey on halls h  (cost=0.14..8.16 rows=1 width=524) (never executed)
              Index Cond: (id = s.hall_id)
Planning Time: 0.134 ms
Execution Time: 0.023 ms

*/
