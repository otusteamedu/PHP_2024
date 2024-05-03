explain analyse
select s.row_number,
       s.seat_number,
       CASE WHEN t.id is null THEN 0 ELSE 1 END AS busy
from seats s
         left join tickets t
                   on (s.id = t.seat_id and t.session_id = 46)
order by s.row_number, s.seat_number;

/*
Sort  (cost=14549.11..14549.36 rows=100 width=12) (actual time=14.757..16.718 rows=100 loops=1)
"  Sort Key: s.row_number, s.seat_number"
  Sort Method: quicksort  Memory: 28kB
  ->  Hash Right Join  (cost=1003.25..14545.79 rows=100 width=12) (actual time=6.113..16.699 rows=100 loops=1)
        Hash Cond: (t.seat_id = s.id)
        ->  Gather  (cost=1000.00..14542.53 rows=2 width=16) (actual time=6.085..16.657 rows=2 loops=1)
              Workers Planned: 2
              Workers Launched: 2
              ->  Parallel Seq Scan on tickets t  (cost=0.00..13542.33 rows=1 width=16) (actual time=9.241..13.036 rows=1 loops=3)
                    Filter: (session_id = 46)
                    Rows Removed by Filter: 333333
        ->  Hash  (cost=2.00..2.00 rows=100 width=16) (actual time=0.021..0.022 rows=100 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 13kB
              ->  Seq Scan on seats s  (cost=0.00..2.00 rows=100 width=16) (actual time=0.005..0.011 rows=100 loops=1)
Planning Time: 0.278 ms
Execution Time: 16.739 ms


*/


CREATE INDEX idx_ticket_session_id ON tickets (session_id);


/*
Sort  (cost=18.33..18.58 rows=100 width=12) (actual time=0.060..0.063 rows=100 loops=1)
"  Sort Key: s.row_number, s.seat_number"
  Sort Method: quicksort  Memory: 28kB
  ->  Hash Left Join  (cost=12.48..15.00 rows=100 width=12) (actual time=0.030..0.044 rows=100 loops=1)
        Hash Cond: (s.id = t.seat_id)
        ->  Seq Scan on seats s  (cost=0.00..2.00 rows=100 width=16) (actual time=0.003..0.007 rows=100 loops=1)
        ->  Hash  (cost=12.46..12.46 rows=2 width=16) (actual time=0.024..0.024 rows=2 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Index Scan using idx_ticket_session_id on tickets t  (cost=0.42..12.46 rows=2 width=16) (actual time=0.021..0.022 rows=2 loops=1)
                    Index Cond: (session_id = 46)
Planning Time: 0.168 ms
Execution Time: 0.078 ms

*/
