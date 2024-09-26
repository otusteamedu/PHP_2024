SELECT COUNT(*) AS sold_tickets
FROM db.tickets
WHERE purchase_time >= CURRENT_DATE - INTERVAL '7 days';

/*
 10000
 Aggregate  (cost=255.41..255.42 rows=1 width=8) (actual time=1.626..1.626 rows=1 loops=1)
  ->  Seq Scan on tickets  (cost=0.00..249.00 rows=2564 width=0) (actual time=0.043..1.525 rows=2562 loops=1)
        Filter: (purchase_time >= (CURRENT_DATE - '7 days'::interval))
        Rows Removed by Filter: 7438
Planning Time: 0.207 ms
Execution Time: 1.666 ms

10000000
 Finalize Aggregate  (cost=150143.05..150143.06 rows=1 width=8) (actual time=549.565..565.615 rows=1 loops=1)
  ->  Gather  (cost=150142.84..150143.05 rows=2 width=8) (actual time=549.379..565.592 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=149142.84..149142.85 rows=1 width=8) (actual time=531.708..531.709 rows=1 loops=3)
              ->  Parallel Seq Scan on tickets  (cost=0.00..146445.82 rows=1078807 width=0) (actual time=3.559..501.468 rows=861714 loops=3)
                    Filter: (purchase_time >= (CURRENT_DATE - '7 days'::interval))
                    Rows Removed by Filter: 2471619
Planning Time: 0.071 ms
JIT:
  Functions: 14
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 0.874 ms, Inlining 0.000 ms, Optimization 0.561 ms, Emission 10.093 ms, Total 11.528 ms
Execution Time: 565.976 ms

 добавление индекса CREATE INDEX idx_tickets_purchase_time ON db.tickets (purchase_time);

 Итог:
 Finalize Aggregate  (cost=42712.64..42712.65 rows=1 width=8) (actual time=96.311..99.769 rows=1 loops=1)
  ->  Gather  (cost=42712.42..42712.63 rows=2 width=8) (actual time=96.181..99.762 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=41712.42..41712.43 rows=1 width=8) (actual time=82.270..82.271 rows=1 loops=3)
              ->  Parallel Index Only Scan using idx_tickets_purchase_time on tickets  (cost=0.44..39015.38 rows=1078819 width=0) (actual time=0.025..53.918 rows=861714 loops=3)
                    Index Cond: (purchase_time >= (CURRENT_DATE - '7 days'::interval))
                    Heap Fetches: 0
Planning Time: 0.094 ms
Execution Time: 99.810 ms
 */
