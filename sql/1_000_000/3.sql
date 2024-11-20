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
Nested Loop  (cost=1000.57..16656.89 rows=1 width=574) (actual time=18.135..20.737 rows=0 loops=1)
  Join Filter: (h.id = s.hall_id)
  ->  Index Scan using halls_name_key on halls h  (cost=0.14..50.25 rows=140 width=524) (actual time=0.014..0.018 rows=5 loops=1)
  ->  Materialize  (cost=1000.42..16604.55 rows=1 width=66) (actual time=3.623..4.143 rows=0 loops=5)
        ->  Nested Loop  (cost=1000.42..16604.54 rows=1 width=66) (actual time=18.114..20.715 rows=0 loops=1)
              ->  Gather  (cost=1000.00..16596.10 rows=1 width=32) (actual time=18.114..20.715 rows=0 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Parallel Seq Scan on films_sessions s  (cost=0.00..15596.00 rows=1 width=32) (actual time=16.248..16.248 rows=0 loops=3)
                          Filter: (start_time = CURRENT_DATE)
                          Rows Removed by Filter: 333333
              ->  Index Scan using films_pkey on films f  (cost=0.42..8.44 rows=1 width=50) (never executed)
                    Index Cond: (id = s.film_id)
Planning Time: 0.319 ms
Execution Time: 20.754 ms



*/

CREATE INDEX idx_session_start ON films_sessions (start_time);


/*
Sort  (cost=25.17..25.18 rows=1 width=574) (actual time=0.022..0.022 rows=0 loops=1)
  Sort Key: h.name
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=1.00..25.16 rows=1 width=574) (actual time=0.013..0.014 rows=0 loops=1)
        ->  Nested Loop  (cost=0.85..16.89 rows=1 width=66) (actual time=0.013..0.013 rows=0 loops=1)
              ->  Index Scan using idx_session_start on films_sessions s  (cost=0.43..8.45 rows=1 width=32) (actual time=0.013..0.013 rows=0 loops=1)
                    Index Cond: (start_time = CURRENT_DATE)
              ->  Index Scan using films_pkey on films f  (cost=0.42..8.44 rows=1 width=50) (never executed)
                    Index Cond: (id = s.film_id)
        ->  Index Scan using halls_pkey on halls h  (cost=0.14..8.16 rows=1 width=524) (never executed)
              Index Cond: (id = s.hall_id)
Planning Time: 0.248 ms
Execution Time: 0.039 ms


*/
