SELECT m.id, SUM(t.price) AS total_revenue
FROM db.movies m
         JOIN db.sessions s ON m.id = s.movie_id
         JOIN db.tickets t ON s.id = t.session_id
WHERE t.purchase_time >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY m.id
ORDER BY total_revenue DESC
LIMIT 3;

/*
 10000
 Limit  (cost=873.08..873.09 rows=3 width=41) (actual time=6.610..6.621 rows=2 loops=1)
  ->  Sort  (cost=873.08..879.49 rows=2564 width=41) (actual time=6.608..6.617 rows=2 loops=1)
        Sort Key: (sum(t.price)) DESC
        Sort Method: quicksort  Memory: 25kB
        ->  HashAggregate  (cost=807.89..839.94 rows=2564 width=41) (actual time=6.511..6.529 rows=2 loops=1)
              Group Key: m.id
              Batches: 1  Memory Usage: 121kB
              ->  Nested Loop  (cost=281.35..795.07 rows=2564 width=15) (actual time=2.253..5.855 rows=2562 loops=1)
                    ->  Hash Join  (cost=281.05..729.69 rows=2564 width=10) (actual time=2.233..5.125 rows=2562 loops=1)
                          Hash Cond: (s.id = t.session_id)
                          ->  Seq Scan on sessions s  (cost=0.00..348.00 rows=20000 width=8) (actual time=0.014..1.066 rows=20000 loops=1)
                          ->  Hash  (cost=249.00..249.00 rows=2564 width=10) (actual time=2.204..2.206 rows=2562 loops=1)
                                Buckets: 4096  Batches: 1  Memory Usage: 143kB
                                ->  Seq Scan on tickets t  (cost=0.00..249.00 rows=2564 width=10) (actual time=0.012..1.853 rows=2562 loops=1)
                                      Filter: (purchase_time >= (CURRENT_DATE - '7 days'::interval))
                                      Rows Removed by Filter: 7438
                    ->  Memoize  (cost=0.30..0.33 rows=1 width=13) (actual time=0.000..0.000 rows=1 loops=2562)
                          Cache Key: s.movie_id
                          Cache Mode: logical
                          Hits: 2560  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                          ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.32 rows=1 width=13) (actual time=0.009..0.009 rows=1 loops=2)
                                Index Cond: (id = s.movie_id)
Planning Time: 0.300 ms
Execution Time: 6.782 ms

 10000000
 Limit  (cost=351381.32..351381.33 rows=3 width=41) (actual time=2651.358..2698.218 rows=3 loops=1)
  ->  Sort  (cost=351381.32..351406.32 rows=10000 width=41) (actual time=2637.934..2684.792 rows=3 loops=1)
        Sort Key: (sum(t.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=348643.58..351252.07 rows=10000 width=41) (actual time=2635.752..2684.577 rows=1000 loops=1)
              Group Key: m.id
              ->  Gather Merge  (cost=348643.58..350977.07 rows=20000 width=41) (actual time=2635.712..2683.328 rows=3000 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Sort  (cost=347643.55..347668.55 rows=10000 width=41) (actual time=2620.662..2620.830 rows=1000 loops=3)
                          Sort Key: m.id
                          Sort Method: quicksort  Memory: 126kB
                          Worker 0:  Sort Method: quicksort  Memory: 126kB
                          Worker 1:  Sort Method: quicksort  Memory: 126kB
                          ->  Partial HashAggregate  (cost=346854.17..346979.17 rows=10000 width=41) (actual time=2618.566..2618.973 rows=1000 loops=3)
                                Group Key: m.id
                                Batches: 1  Memory Usage: 913kB
                                Worker 0:  Batches: 1  Memory Usage: 913kB
                                Worker 1:  Batches: 1  Memory Usage: 913kB
                                ->  Hash Join  (cost=165487.91..341460.13 rows=1078807 width=15) (actual time=1487.310..2410.511 rows=861714 loops=3)
                                      Hash Cond: (s.movie_id = m.id)
                                      ->  Parallel Hash Join  (cost=165198.91..338338.06 rows=1078807 width=10) (actual time=1477.574..2247.897 rows=861714 loops=3)
                                            Hash Cond: (s.id = t.session_id)
                                            ->  Parallel Seq Scan on sessions s  (cost=0.00..115197.00 rows=4166700 width=8) (actual time=0.150..308.862 rows=3333333 loops=3)
                                            ->  Parallel Hash  (cost=146445.82..146445.82 rows=1078807 width=10) (actual time=649.828..649.829 rows=861714 loops=3)
                                                  Buckets: 262144  Batches: 32  Memory Usage: 5888kB
                                                  ->  Parallel Seq Scan on tickets t  (cost=0.00..146445.82 rows=1078807 width=10) (actual time=0.083..492.277 rows=861714 loops=3)
                                                        Filter: (purchase_time >= (CURRENT_DATE - '7 days'::interval))
                                                        Rows Removed by Filter: 2471619
                                      ->  Hash  (cost=164.00..164.00 rows=10000 width=13) (actual time=9.677..9.678 rows=10000 loops=3)
                                            Buckets: 16384  Batches: 1  Memory Usage: 597kB
                                            ->  Seq Scan on movies m  (cost=0.00..164.00 rows=10000 width=13) (actual time=7.320..8.144 rows=10000 loops=3)
Planning Time: 1.719 ms
JIT:
  Functions: 79
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 2.702 ms, Inlining 0.000 ms, Optimization 1.494 ms, Emission 34.258 ms, Total 38.454 ms
Execution Time: 2699.907 ms

 Для данного запроса индексы особо не помогают
 как вариант можно создать материализованное представления

 CREATE MATERIALIZED VIEW movie_revenue_summary AS
SELECT m.id, SUM(t.price) AS total_revenue
FROM db.movies m
JOIN db.sessions s ON m.id = s.movie_id
JOIN db.tickets t ON s.id = t.session_id
WHERE t.purchase_time >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY m.id;

 и далее выбрать данные из него

 SELECT id, total_revenue
FROM movie_revenue_summary
ORDER BY total_revenue DESC
LIMIT 3;

 Limit  (cost=30.92..30.93 rows=3 width=12) (actual time=0.220..0.221 rows=3 loops=1)
  ->  Sort  (cost=30.92..33.42 rows=1000 width=12) (actual time=0.220..0.220 rows=3 loops=1)
        Sort Key: total_revenue DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Seq Scan on movie_revenue_summary  (cost=0.00..18.00 rows=1000 width=12) (actual time=0.006..0.109 rows=1000 loops=1)
Planning Time: 0.101 ms
Execution Time: 0.231 ms
 */
