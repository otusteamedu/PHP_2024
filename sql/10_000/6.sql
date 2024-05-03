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
GroupAggregate  (cost=391.64..391.68 rows=2 width=66) (actual time=0.477..0.479 rows=1 loops=1)
  Group Key: f.id
  ->  Sort  (cost=391.64..391.64 rows=2 width=58) (actual time=0.473..0.474 rows=3 loops=1)
        Sort Key: f.id
        Sort Method: quicksort  Memory: 25kB
        ->  Nested Loop  (cost=0.57..391.63 rows=2 width=58) (actual time=0.284..0.469 rows=3 loops=1)
              ->  Nested Loop  (cost=0.57..16.61 rows=1 width=58) (actual time=0.012..0.014 rows=1 loops=1)
                    ->  Index Scan using films_sessions_pkey on films_sessions s  (cost=0.29..8.30 rows=1 width=16) (actual time=0.006..0.008 rows=1 loops=1)
                          Index Cond: (id = 202)
                    ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=50) (actual time=0.003..0.003 rows=1 loops=1)
                          Index Cond: (id = s.film_id)
              ->  Seq Scan on tickets t  (cost=0.00..375.00 rows=2 width=16) (actual time=0.271..0.453 rows=3 loops=1)
                    Filter: (session_id = 202)
                    Rows Removed by Filter: 9997
Planning Time: 0.139 ms
Execution Time: 0.504 ms

*/

CREATE INDEX idx_ticket_session_id ON tickets (session_id);


/*

GroupAggregate  (cost=28.43..28.47 rows=2 width=66) (actual time=0.034..0.035 rows=1 loops=1)
  Group Key: f.id
  ->  Sort  (cost=28.43..28.43 rows=2 width=58) (actual time=0.030..0.030 rows=3 loops=1)
        Sort Key: f.id
        Sort Method: quicksort  Memory: 25kB
        ->  Nested Loop  (cost=4.87..28.42 rows=2 width=58) (actual time=0.022..0.025 rows=3 loops=1)
              ->  Nested Loop  (cost=0.57..16.61 rows=1 width=58) (actual time=0.012..0.012 rows=1 loops=1)
                    ->  Index Scan using films_sessions_pkey on films_sessions s  (cost=0.29..8.30 rows=1 width=16) (actual time=0.006..0.007 rows=1 loops=1)
                          Index Cond: (id = 202)
                    ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=50) (actual time=0.003..0.003 rows=1 loops=1)
                          Index Cond: (id = s.film_id)
              ->  Bitmap Heap Scan on tickets t  (cost=4.30..11.79 rows=2 width=16) (actual time=0.009..0.011 rows=3 loops=1)
                    Recheck Cond: (session_id = 202)
                    Heap Blocks: exact=3
                    ->  Bitmap Index Scan on idx_ticket_session_id  (cost=0.00..4.30 rows=2 width=0) (actual time=0.006..0.006 rows=3 loops=1)
                          Index Cond: (session_id = 202)
Planning Time: 0.124 ms
Execution Time: 0.057 ms

*/
