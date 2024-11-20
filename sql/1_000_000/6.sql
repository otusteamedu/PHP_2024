explain analyse
select f.name       as name,
       max(t.price) as max_price,
       min(t.price) as min_price
from films_sessions s
         join films f on f.id = s.film_id
         join tickets t on t.session_id = s.id
where s.id = 202
group by f.id;


/*
GroupAggregate  (cost=14559.44..14559.48 rows=2 width=66) (actual time=13.944..15.939 rows=1 loops=1)
  Group Key: f.id
  ->  Sort  (cost=14559.44..14559.44 rows=2 width=58) (actual time=13.939..15.933 rows=2 loops=1)
        Sort Key: f.id
        Sort Method: quicksort  Memory: 25kB
        ->  Gather  (cost=1000.85..14559.43 rows=2 width=58) (actual time=9.626..15.927 rows=2 loops=1)
              Workers Planned: 2
              Workers Launched: 2
              ->  Nested Loop  (cost=0.85..13559.23 rows=1 width=58) (actual time=10.695..12.114 rows=1 loops=3)
                    ->  Parallel Seq Scan on tickets t  (cost=0.00..13542.33 rows=1 width=16) (actual time=10.681..12.095 rows=1 loops=3)
                          Filter: (session_id = 202)
                          Rows Removed by Filter: 333333
                    ->  Nested Loop  (cost=0.85..16.89 rows=1 width=58) (actual time=0.024..0.025 rows=1 loops=2)
                          ->  Index Scan using films_sessions_pkey on films_sessions s  (cost=0.42..8.44 rows=1 width=16) (actual time=0.015..0.016 rows=1 loops=2)
                                Index Cond: (id = 202)
                          ->  Index Scan using films_pkey on films f  (cost=0.42..8.44 rows=1 width=50) (actual time=0.007..0.007 rows=1 loops=2)
                                Index Cond: (id = s.film_id)
Planning Time: 0.233 ms
Execution Time: 15.962 ms


*/

CREATE INDEX idx_ticket_session_id ON tickets (session_id);


/*

GroupAggregate  (cost=29.37..29.41 rows=2 width=66) (actual time=0.039..0.040 rows=1 loops=1)
  Group Key: f.id
  ->  Sort  (cost=29.37..29.38 rows=2 width=58) (actual time=0.035..0.036 rows=2 loops=1)
        Sort Key: f.id
        Sort Method: quicksort  Memory: 25kB
        ->  Nested Loop  (cost=1.27..29.36 rows=2 width=58) (actual time=0.030..0.032 rows=2 loops=1)
              ->  Nested Loop  (cost=0.85..16.89 rows=1 width=58) (actual time=0.013..0.014 rows=1 loops=1)
                    ->  Index Scan using films_sessions_pkey on films_sessions s  (cost=0.42..8.44 rows=1 width=16) (actual time=0.006..0.006 rows=1 loops=1)
                          Index Cond: (id = 202)
                    ->  Index Scan using films_pkey on films f  (cost=0.42..8.44 rows=1 width=50) (actual time=0.005..0.005 rows=1 loops=1)
                          Index Cond: (id = s.film_id)
              ->  Index Scan using idx_ticket_session_id on tickets t  (cost=0.42..12.46 rows=2 width=16) (actual time=0.016..0.018 rows=2 loops=1)
                    Index Cond: (session_id = 202)
Planning Time: 0.199 ms
Execution Time: 0.060 ms


*/
