--2. Подсчёт проданных билетов за неделю

SELECT count(tickets.id) as CTN from tickets
    join orders on orders.id = tickets.order_id
    where orders.date_created BETWEEN CURRENT_DATE - interval '6 days' AND CURRENT_DATE;


---10_000 записей
/*
 Aggregate  (cost=447.87..447.88 rows=1 width=8) (actual time=7.912..7.926 rows=1 loops=1)
   ->  Hash Join  (cost=289.99..430.37 rows=6999 width=4) (actual time=4.175..7.384 rows=7000 loops=1)
         Hash Cond: (tickets.order_id = orders.id)
         ->  Seq Scan on tickets  (cost=0.00..122.00 rows=7000 width=12) (actual time=0.013..0.913 rows=7000 loops=1)
         ->  Hash  (cost=202.50..202.50 rows=6999 width=4) (actual time=4.100..4.103 rows=7000 loops=1)
               Buckets: 8192  Batches: 1  Memory Usage: 311kB
               ->  Seq Scan on orders  (cost=0.00..202.50 rows=6999 width=4) (actual time=0.008..2.566 rows=7000 loops=1)
                     Filter: ((date_created <= CURRENT_DATE) AND (date_created >= (CURRENT_DATE - '6 days'::interval)))
 Planning Time: 1.440 ms
 Execution Time: 8.050 ms
(10 rows)
*/

--10_000_000 записей
/*
------------------------------------------------------------------------------------------------------------------------------------------------------------
 Finalize Aggregate  (cost=336445.20..336445.21 rows=1 width=8) (actual time=8585.599..8707.019 rows=1 loops=1)
   ->  Gather  (cost=336444.98..336445.19 rows=2 width=8) (actual time=8575.805..8706.962 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=335444.98..335444.99 rows=1 width=8) (actual time=8530.180..8530.270 rows=1 loops=3)
               ->  Parallel Hash Join  (cost=180632.55..327113.22 rows=3332705 width=4) (actual time=6614.073..8316.279 rows=2666667 loops=3)
                     Hash Cond: (tickets.order_id = orders.id)
                     ->  Parallel Seq Scan on tickets  (cost=0.00..92157.60 rows=3333360 width=12) (actual time=1.796..2261.096 rows=2666667 loops=3)
                     ->  Parallel Hash  (cost=125955.40..125955.40 rows=3332652 width=4) (actual time=3376.910..3376.911 rows=2666667 loops=3)
                           Buckets: 262144  Batches: 64  Memory Usage: 7008kB
                           ->  Parallel Seq Scan on orders  (cost=0.00..125955.40 rows=3332652 width=4) (actual time=75.447..2520.822 rows=2666667 loops=3)
                                 Filter: ((date_created <= CURRENT_DATE) AND (date_created >= (CURRENT_DATE - '6 days'::interval)))
 Planning Time: 3.947 ms
 JIT:
   Functions: 41
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 5.016 ms, Inlining 0.000 ms, Optimization 24.784 ms, Emission 200.501 ms, Total 230.301 ms
 Execution Time: 8870.357 ms
(18 rows)
*/

/* Предлагаемая оптимизация - добавить индекс на поле orders.date_created */

CREATE INDEX idx_orders_date_created ON orders(date_created);

/* результат для 10_000_000 записей после добавления индекса
 Finalize Aggregate  (cost=336459.95..336459.96 rows=1 width=8) (actual time=5268.328..5413.248 rows=1 loops=1)
   ->  Gather  (cost=336459.73..336459.94 rows=2 width=8) (actual time=5263.705..5413.202 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=335459.73..335459.74 rows=1 width=8) (actual time=5239.109..5239.196 rows=1 loops=3)
               ->  Parallel Hash Join  (cost=180643.66..327126.33 rows=3333360 width=4) (actual time=3244.047..4984.885 rows=2666667 loops=3)
                     Hash Cond: (tickets.order_id = orders.id)
                     ->  Parallel Seq Scan on tickets  (cost=0.00..92157.60 rows=3333360 width=12) (actual time=0.097..500.655 rows=2666667 loops=3)
                     ->  Parallel Hash  (cost=125956.00..125956.00 rows=3333333 width=4) (actual time=2012.222..2012.224 rows=2666667 loops=3)
                           Buckets: 262144  Batches: 64  Memory Usage: 7008kB
                           ->  Parallel Seq Scan on orders  (cost=0.00..125956.00 rows=3333333 width=4) (actual time=14.682..1057.103 rows=2666667 loops=3)
                                 Filter: ((date_created <= CURRENT_DATE) AND (date_created >= (CURRENT_DATE - '6 days'::interval)))
 Planning Time: 0.685 ms
 JIT:
   Functions: 41
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 2.896 ms, Inlining 0.000 ms, Optimization 1.523 ms, Emission 42.700 ms, Total 47.119 ms
 Execution Time: 5414.400 ms
(18 rows)

*/

/* вывод - добавление индекса сократило Execution Time c 8870.357 ms до 5414.400 ms */

/* Предлагаемая ещё одна оптимизация - добавить индекс на поле tickets.order_id */

CREATE INDEX idx_tickets_order_id ON tickets(order_id);

/* результат для 10_000_000 записей после добавления индекса
 Finalize Aggregate  (cost=336459.54..336459.55 rows=1 width=8) (actual time=4626.991..4757.049 rows=1 loops=1)
   ->  Gather  (cost=336459.33..336459.54 rows=2 width=8) (actual time=4600.965..4756.996 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=335459.33..335459.34 rows=1 width=8) (actual time=4581.184..4581.255 rows=1 loops=3)
               ->  Parallel Hash Join  (cost=180643.66..327125.99 rows=3333333 width=4) (actual time=2648.563..4335.258 rows=2666667 loops=3)
                     Hash Cond: (tickets.order_id = orders.id)
                     ->  Parallel Seq Scan on tickets  (cost=0.00..92157.33 rows=3333333 width=12) (actual time=0.127..498.722 rows=2666667 loops=3)
                     ->  Parallel Hash  (cost=125956.00..125956.00 rows=3333333 width=4) (actual time=1385.843..1385.844 rows=2666667 loops=3)
                           Buckets: 262144  Batches: 64  Memory Usage: 7008kB
                           ->  Parallel Seq Scan on orders  (cost=0.00..125956.00 rows=3333333 width=4) (actual time=8.275..795.405 rows=2666667 loops=3)
                                 Filter: ((date_created <= CURRENT_DATE) AND (date_created >= (CURRENT_DATE - '6 days'::interval)))
 Planning Time: 0.569 ms
 JIT:
   Functions: 41
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 2.328 ms, Inlining 0.000 ms, Optimization 1.298 ms, Emission 23.660 ms, Total 27.286 ms
 Execution Time: 4758.084 ms
(18 rows)

*/

/* вывод - добавление ещё одного индекса сократило Execution Time c  5414.400 ms ms до 4758.084 ms */