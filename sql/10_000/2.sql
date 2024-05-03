explain analyse
select count(*)
from tickets
where pay_time between (CURRENT_DATE - INTERVAL '7 day') and CURRENT_DATE;


/*
Aggregate  (cost=475.01..475.02 rows=1 width=8) (actual time=1.181..1.181 rows=1 loops=1)
  ->  Seq Scan on tickets  (cost=0.00..475.00 rows=5 width=0) (actual time=0.331..1.177 rows=2 loops=1)
        Filter: ((pay_time <= CURRENT_DATE) AND (pay_time >= (CURRENT_DATE - '7 days'::interval)))
        Rows Removed by Filter: 9998
Planning Time: 0.066 ms
Execution Time: 1.198 ms

*/

CREATE INDEX idx_ticket_pay_time ON tickets (pay_time);


/*
Aggregate  (cost=4.41..4.42 rows=1 width=8) (actual time=0.014..0.014 rows=1 loops=1)
  ->  Index Only Scan using idx_ticket_pay_time on tickets  (cost=0.29..4.39 rows=5 width=0) (actual time=0.011..0.012 rows=2 loops=1)
        Index Cond: ((pay_time >= (CURRENT_DATE - '7 days'::interval)) AND (pay_time <= CURRENT_DATE))
        Heap Fetches: 0
Planning Time: 0.216 ms
Execution Time: 0.030 ms


*/
