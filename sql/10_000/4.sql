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
Limit  (cost=571.60..571.61 rows=3 width=58) (actual time=1.042..1.043 rows=3 loops=1)
  ->  Sort  (cost=571.60..571.63 rows=12 width=58) (actual time=1.041..1.042 rows=3 loops=1)
        Sort Key: (sum(t.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  GroupAggregate  (cost=571.24..571.45 rows=12 width=58) (actual time=1.035..1.038 rows=9 loops=1)
              Group Key: f.id
              ->  Sort  (cost=571.24..571.27 rows=12 width=58) (actual time=1.033..1.033 rows=9 loops=1)
                    Sort Key: f.id
                    Sort Method: quicksort  Memory: 25kB
                    ->  Nested Loop  (cost=0.57..571.02 rows=12 width=58) (actual time=0.157..1.029 rows=9 loops=1)
                          ->  Nested Loop  (cost=0.29..566.63 rows=12 width=16) (actual time=0.154..1.010 rows=9 loops=1)
                                ->  Seq Scan on tickets t  (cost=0.00..475.00 rows=12 width=16) (actual time=0.149..0.990 rows=9 loops=1)
                                      Filter: ((pay_time <= CURRENT_DATE) AND (pay_time >= (CURRENT_DATE - '21 days'::interval)))
                                      Rows Removed by Filter: 9991
                                ->  Index Scan using films_sessions_pkey on films_sessions s  (cost=0.29..7.64 rows=1 width=16) (actual time=0.002..0.002 rows=1 loops=9)
                                      Index Cond: (id = t.session_id)
                          ->  Index Scan using films_pkey on films f  (cost=0.29..0.37 rows=1 width=50) (actual time=0.002..0.002 rows=1 loops=9)
                                Index Cond: (id = s.film_id)
Planning Time: 0.164 ms
Execution Time: 1.061 ms


*/


CREATE INDEX idx_ticket_pay_time ON tickets (pay_time);


/*

Limit  (cost=141.40..141.41 rows=3 width=58) (actual time=0.078..0.080 rows=3 loops=1)
  ->  Sort  (cost=141.40..141.43 rows=12 width=58) (actual time=0.078..0.078 rows=3 loops=1)
        Sort Key: (sum(t.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  GroupAggregate  (cost=141.04..141.25 rows=12 width=58) (actual time=0.071..0.074 rows=9 loops=1)
              Group Key: f.id
              ->  Sort  (cost=141.04..141.07 rows=12 width=58) (actual time=0.068..0.069 rows=9 loops=1)
                    Sort Key: f.id
                    Sort Method: quicksort  Memory: 25kB
                    ->  Nested Loop  (cost=4.99..140.82 rows=12 width=58) (actual time=0.018..0.064 rows=9 loops=1)
                          ->  Nested Loop  (cost=4.70..136.43 rows=12 width=16) (actual time=0.014..0.040 rows=9 loops=1)
                                ->  Bitmap Heap Scan on tickets t  (cost=4.42..44.80 rows=12 width=16) (actual time=0.010..0.017 rows=9 loops=1)
                                      Recheck Cond: ((pay_time >= (CURRENT_DATE - '21 days'::interval)) AND (pay_time <= CURRENT_DATE))
                                      Heap Blocks: exact=8
                                      ->  Bitmap Index Scan on idx_ticket_pay_time  (cost=0.00..4.41 rows=12 width=0) (actual time=0.006..0.006 rows=9 loops=1)
                                            Index Cond: ((pay_time >= (CURRENT_DATE - '21 days'::interval)) AND (pay_time <= CURRENT_DATE))
                                ->  Index Scan using films_sessions_pkey on films_sessions s  (cost=0.29..7.64 rows=1 width=16) (actual time=0.002..0.002 rows=1 loops=9)
                                      Index Cond: (id = t.session_id)
                          ->  Index Scan using films_pkey on films f  (cost=0.29..0.37 rows=1 width=50) (actual time=0.002..0.002 rows=1 loops=9)
                                Index Cond: (id = s.film_id)
Planning Time: 0.201 ms
Execution Time: 0.105 ms

*/
