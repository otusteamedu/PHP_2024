explain analyse
select f.name,
       sum(t.price) as total_price
from tickets t
         join films_sessions s on t.session_id = s.id
         join films f on s.film_id = f.id
where t.pay_time between (CURRENT_DATE - INTERVAL '21 day') and CURRENT_DATE
group by f.id
order by total_price desc
limit 3;


/*
Limit  (cost=22466.37..22466.38 rows=3 width=58) (actual time=36.481..38.578 rows=3 loops=1)
  ->  Sort  (cost=22466.37..22469.04 rows=1068 width=58) (actual time=36.480..38.577 rows=3 loops=1)
        Sort Key: (sum(t.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=22326.92..22452.56 rows=1068 width=58) (actual time=36.170..38.513 rows=1017 loops=1)
              Group Key: f.id
              ->  Gather Merge  (cost=22326.92..22437.43 rows=890 width=58) (actual time=36.167..38.392 rows=1021 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=21326.89..21334.68 rows=445 width=58) (actual time=33.882..33.946 rows=340 loops=3)
                          Group Key: f.id
                          ->  Sort  (cost=21326.89..21328.01 rows=445 width=58) (actual time=33.877..33.893 rows=341 loops=3)
                                Sort Key: f.id
                                Sort Method: quicksort  Memory: 55kB
                                Worker 0:  Sort Method: quicksort  Memory: 51kB
                                Worker 1:  Sort Method: quicksort  Memory: 53kB
                                ->  Nested Loop  (cost=0.85..21307.32 rows=445 width=58) (actual time=0.196..33.804 rows=341 loops=3)
                                      ->  Nested Loop  (cost=0.42..21082.58 rows=445 width=16) (actual time=0.172..31.499 rows=341 loops=3)
                                            ->  Parallel Seq Scan on tickets t  (cost=0.00..17709.00 rows=445 width=16) (actual time=0.150..29.531 rows=341 loops=3)
                                                  Filter: ((pay_time <= CURRENT_DATE) AND (pay_time >= (CURRENT_DATE - '21 days'::interval)))
                                                  Rows Removed by Filter: 332993
                                            ->  Index Scan using films_sessions_pkey on films_sessions s  (cost=0.42..7.58 rows=1 width=16) (actual time=0.006..0.006 rows=1 loops=1022)
                                                  Index Cond: (id = t.session_id)
                                      ->  Index Scan using films_pkey on films f  (cost=0.42..0.51 rows=1 width=50) (actual time=0.007..0.007 rows=1 loops=1022)
                                            Index Cond: (id = s.film_id)
Planning Time: 0.326 ms
Execution Time: 38.605 ms



*/


CREATE INDEX idx_ticket_pay_time ON tickets (pay_time);
CREATE INDEX idx_ticket_seat_id ON tickets (seat_id);


/*

Limit  (cost=11740.17..11740.17 rows=3 width=58) (actual time=5.570..5.572 rows=3 loops=1)
  ->  Sort  (cost=11740.17..11742.84 rows=1068 width=58) (actual time=5.569..5.570 rows=3 loops=1)
        Sort Key: (sum(t.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  GroupAggregate  (cost=11707.67..11726.36 rows=1068 width=58) (actual time=5.335..5.512 rows=1017 loops=1)
              Group Key: f.id
              ->  Sort  (cost=11707.67..11710.34 rows=1068 width=58) (actual time=5.330..5.367 rows=1022 loops=1)
                    Sort Key: f.id
                    Sort Method: quicksort  Memory: 110kB
                    ->  Nested Loop  (cost=24.23..11653.95 rows=1068 width=58) (actual time=0.124..5.192 rows=1022 loops=1)
                          ->  Nested Loop  (cost=23.80..11114.57 rows=1068 width=16) (actual time=0.120..3.013 rows=1022 loops=1)
                                ->  Bitmap Heap Scan on tickets t  (cost=23.38..3017.98 rows=1068 width=16) (actual time=0.115..0.784 rows=1022 loops=1)
                                      Recheck Cond: ((pay_time >= (CURRENT_DATE - '21 days'::interval)) AND (pay_time <= CURRENT_DATE))
                                      Heap Blocks: exact=973
                                      ->  Bitmap Index Scan on idx_ticket_pay_time  (cost=0.00..23.11 rows=1068 width=0) (actual time=0.058..0.058 rows=1022 loops=1)
                                            Index Cond: ((pay_time >= (CURRENT_DATE - '21 days'::interval)) AND (pay_time <= CURRENT_DATE))
                                ->  Index Scan using films_sessions_pkey on films_sessions s  (cost=0.42..7.58 rows=1 width=16) (actual time=0.002..0.002 rows=1 loops=1022)
                                      Index Cond: (id = t.session_id)
                          ->  Index Scan using films_pkey on films f  (cost=0.42..0.51 rows=1 width=50) (actual time=0.002..0.002 rows=1 loops=1022)
                                Index Cond: (id = s.film_id)
Planning Time: 0.217 ms
Execution Time: 5.600 ms

*/
