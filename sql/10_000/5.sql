explain analyse
select s.row_number,
       s.seat_number,
       CASE WHEN t.id is null THEN 0 ELSE 1 END AS busy
from seats s
         left join tickets t
                   on (s.id = t.seat_id and t.session_id = 46)
order by s.row_number, s.seat_number;

/*
Sort  (cost=383.33..383.58 rows=100 width=12) (actual time=0.426..0.429 rows=100 loops=1)
"  Sort Key: s.row_number, s.seat_number"
  Sort Method: quicksort  Memory: 28kB
  ->  Nested Loop Left Join  (cost=0.00..380.00 rows=100 width=12) (actual time=0.387..0.411 rows=100 loops=1)
        Join Filter: (s.id = t.seat_id)
        Rows Removed by Join Filter: 99
        ->  Seq Scan on seats s  (cost=0.00..2.00 rows=100 width=16) (actual time=0.004..0.007 rows=100 loops=1)
        ->  Materialize  (cost=0.00..375.01 rows=2 width=16) (actual time=0.002..0.004 rows=1 loops=100)
              ->  Seq Scan on tickets t  (cost=0.00..375.00 rows=2 width=16) (actual time=0.220..0.381 rows=1 loops=1)
                    Filter: (session_id = 46)
                    Rows Removed by Filter: 9999
Planning Time: 0.101 ms
Execution Time: 0.443 ms

*/


CREATE INDEX idx_ticket_session_id ON tickets (session_id);


/*
Sort  (cost=17.66..17.91 rows=100 width=12) (actual time=0.085..0.090 rows=100 loops=1)
"  Sort Key: s.row_number, s.seat_number"
  Sort Method: quicksort  Memory: 28kB
  ->  Hash Left Join  (cost=11.81..14.33 rows=100 width=12) (actual time=0.045..0.064 rows=100 loops=1)
        Hash Cond: (s.id = t.seat_id)
        ->  Seq Scan on seats s  (cost=0.00..2.00 rows=100 width=16) (actual time=0.004..0.008 rows=100 loops=1)
        ->  Hash  (cost=11.79..11.79 rows=2 width=16) (actual time=0.030..0.031 rows=1 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Bitmap Heap Scan on tickets t  (cost=4.30..11.79 rows=2 width=16) (actual time=0.028..0.029 rows=1 loops=1)
                    Recheck Cond: (session_id = 46)
                    Heap Blocks: exact=1
                    ->  Bitmap Index Scan on idx_ticket_session_id  (cost=0.00..4.30 rows=2 width=0) (actual time=0.024..0.024 rows=1 loops=1)
                          Index Cond: (session_id = 46)
Planning Time: 0.224 ms
Execution Time: 0.112 ms


*/
