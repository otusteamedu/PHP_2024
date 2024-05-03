explain analyse
select count(*)
from tickets
where pay_time between (CURRENT_DATE - INTERVAL '7 day') and CURRENT_DATE;


/*
Finalize Aggregate  (cost=18715.17..18715.18 rows=1 width=8) (actual time=37.339..39.320 rows=1 loops=1)
  ->  Gather  (cost=18714.96..18715.17 rows=2 width=8) (actual time=37.277..39.315 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=17714.96..17714.97 rows=1 width=8) (actual time=35.481..35.482 rows=1 loops=3)
              ->  Parallel Seq Scan on tickets  (cost=0.00..17709.75 rows=2083 width=0) (actual time=0.307..35.471 rows=113 loops=3)
                    Filter: ((pay_time <= CURRENT_DATE) AND (pay_time >= (CURRENT_DATE - '7 days'::interval)))
                    Rows Removed by Filter: 333221
Planning Time: 0.121 ms
Execution Time: 39.335 ms
*/

CREATE INDEX idx_ticket_pay_time ON tickets (pay_time);


/*
Aggregate  (cost=12.46..12.47 rows=1 width=8) (actual time=0.053..0.053 rows=1 loops=1)
  ->  Index Only Scan using idx_ticket_pay_time on tickets  (cost=0.43..11.57 rows=357 width=0) (actual time=0.013..0.040 rows=338 loops=1)
        Index Cond: ((pay_time >= (CURRENT_DATE - '7 days'::interval)) AND (pay_time <= CURRENT_DATE))
        Heap Fetches: 0
Planning Time: 0.200 ms
Execution Time: 0.065 ms
*/
