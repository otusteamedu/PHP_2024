SELECT
	m.name movie,
	sum(sales.amount) amount
FROM
	sales
	JOIN tickets t ON sales.ticket_id = t.id
	JOIN shows s ON t.show_id = s.id
	JOIN movies m ON s.movie_id = m.id
WHERE
	date BETWEEN CURRENT_DATE - interval '6 days' AND CURRENT_DATE
GROUP BY
	m.id
ORDER BY
	sum(amount) DESC
LIMIT
	3
;

-- 10_000 rows
-- Limit  (cost=352.52..352.52 rows=3 width=50) (actual time=3.513..3.518 rows=3 loops=1)
--    ->  Sort  (cost=352.52..352.54 rows=10 width=50) (actual time=3.512..3.515 rows=3 loops=1)
--          Sort Key: (sum(sales.amount)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  HashAggregate  (cost=352.26..352.39 rows=10 width=50) (actual time=3.484..3.489 rows=10 loops=1)
--                Group Key: m.id
--                Batches: 1  Memory Usage: 24kB
--                ->  Hash Join  (cost=166.97..350.38 rows=377 width=24) (actual time=2.260..3.387 rows=377 loops=1)
--                      Hash Cond: (s.movie_id = m.id)
--                      ->  Hash Join  (cost=165.75..347.74 rows=377 width=14) (actual time=2.240..3.308 rows=377 loops=1)
--                            Hash Cond: (t.show_id = s.id)
--                            ->  Hash Join  (cost=149.50..330.49 rows=377 width=14) (actual time=2.073..3.057 rows=377 loops=1)
--                                  Hash Cond: (sales.ticket_id = t.id)
--                                  ->  Seq Scan on sales  (cost=0.00..180.00 rows=377 width=14) (actual time=0.015..0.879 rows=377 loops=1)
--                                        Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
--                                        Rows Removed by Filter: 5623
--                                  ->  Hash  (cost=87.00..87.00 rows=5000 width=16) (actual time=1.988..1.988 rows=5000 loops=1)
--                                        Buckets: 8192  Batches: 1  Memory Usage: 299kB
--                                        ->  Seq Scan on tickets t  (cost=0.00..87.00 rows=5000 width=16) (actual time=0.004..0.971 rows=5000 loops=1)
--                            ->  Hash  (cost=10.00..10.00 rows=500 width=16) (actual time=0.159..0.160 rows=500 loops=1)
--                                  Buckets: 1024  Batches: 1  Memory Usage: 32kB
--                                  ->  Seq Scan on shows s  (cost=0.00..10.00 rows=500 width=16) (actual time=0.003..0.080 rows=500 loops=1)
--                      ->  Hash  (cost=1.10..1.10 rows=10 width=18) (actual time=0.013..0.014 rows=10 loops=1)
--                            Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                            ->  Seq Scan on movies m  (cost=0.00..1.10 rows=10 width=18) (actual time=0.007..0.009 rows=10 loops=1)
--  Planning Time: 2.198 ms
--  Execution Time: 3.609 ms
-- 
-- 10_000_000 rows
-- Limit  (cost=149791.63..149791.63 rows=3 width=56) (actual time=6808.547..6817.882 rows=3 loops=1)
--    ->  Sort  (cost=149791.63..149792.88 rows=500 width=56) (actual time=6778.713..6788.047 rows=3 loops=1)
--          Sort Key: (sum(sales.amount)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=149654.74..149785.16 rows=500 width=56) (actual time=6777.541..6787.856 rows=500 loops=1)
--                Group Key: m.id
--                ->  Gather Merge  (cost=149654.74..149771.41 rows=1000 width=56) (actual time=6777.497..6787.173 rows=1500 loops=1)
--                      Workers Planned: 2
--                      Workers Launched: 2
--                      ->  Sort  (cost=148654.72..148655.97 rows=500 width=56) (actual time=6715.367..6715.458 rows=500 loops=3)
--                            Sort Key: m.id
--                            Sort Method: quicksort  Memory: 83kB
--                            Worker 0:  Sort Method: quicksort  Memory: 83kB
--                            Worker 1:  Sort Method: quicksort  Memory: 83kB
--                            ->  Partial HashAggregate  (cost=148626.05..148632.30 rows=500 width=56) (actual time=6714.025..6714.827 rows=500 loops=3)
--                                  Group Key: m.id
--                                  Batches: 1  Memory Usage: 297kB
--                                  Worker 0:  Batches: 1  Memory Usage: 297kB
--                                  Worker 1:  Batches: 1  Memory Usage: 297kB
--                                  ->  Hash Join  (cost=140286.41..148072.44 rows=110722 width=30) (actual time=6209.271..6671.036 rows=81686 loops=3)
--                                        Hash Cond: (s.movie_id = m.id)
--                                        ->  Parallel Hash Join  (cost=140271.16..147764.09 rows=110722 width=14) (actual time=6156.476..6590.714 rows=81686 loops=3)
--                                              Hash Cond: (s.id = t.show_id)
--                                              ->  Parallel Seq Scan on shows s  (cost=0.00..6250.33 rows=208333 width=16) (actual time=1.064..297.609 rows=166667 loops=3)
--                                              ->  Parallel Hash  (cost=138887.14..138887.14 rows=110722 width=14) (actual time=6152.780..6152.792 rows=81686 loops=3)
--                                                    Buckets: 524288  Batches: 1  Memory Usage: 15616kB
--                                                    ->  Parallel Hash Join  (cost=59932.53..138887.14 rows=110722 width=14) (actual time=862.971..6049.261 rows=81686 loops=3)
--                                                          Hash Cond: (t.id = sales.ticket_id)
--                                                          ->  Parallel Seq Scan on tickets t  (cost=0.00..69118.20 rows=2500020 width=16) (actual time=0.815..3659.554 rows=2000000 loops=3)
--                                                          ->  Parallel Hash  (cost=58548.50..58548.50 rows=110722 width=14) (actual time=859.818..859.821 rows=81686 loops=3)
--                                                                Buckets: 524288  Batches: 1  Memory Usage: 15616kB
--                                                                ->  Parallel Seq Scan on sales  (cost=0.00..58548.50 rows=110722 width=14) (actual time=1.227..792.443 rows=81686 loops=3)
--                                                                      Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
--                                                                      Rows Removed by Filter: 1084980
--                                        ->  Hash  (cost=9.00..9.00 rows=500 width=24) (actual time=52.776..52.779 rows=500 loops=3)
--                                              Buckets: 1024  Batches: 1  Memory Usage: 38kB
--                                              ->  Seq Scan on movies m  (cost=0.00..9.00 rows=500 width=24) (actual time=52.225..52.554 rows=500 loops=3)
--  Planning Time: 24.215 ms
--  JIT:
--    Functions: 109
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 8.672 ms, Inlining 0.000 ms, Optimization 3.043 ms, Emission 180.241 ms, Total 191.956 ms
--  Execution Time: 6925.439 ms
-- 
-- Что удалось улучшить:
-- Уменьшен "cost" запроса.
-- Перечень оптимизаций:
-- Добавил индекс на поле "date". За счет этого произошла замена Seq Scan таблицы sales на использование индекса - Bitmap Index Scan
-- 
-- Результат:
-- 
-- Limit  (cost=123098.30..123098.31 rows=3 width=56) (actual time=13569.559..13594.777 rows=3 loops=1)
--    ->  Sort  (cost=123098.30..123099.55 rows=500 width=56) (actual time=13537.538..13562.755 rows=3 loops=1)
--          Sort Key: (sum(sales.amount)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=122961.41..123091.84 rows=500 width=56) (actual time=13536.529..13562.557 rows=500 loops=1)
--                Group Key: m.id
--                ->  Gather Merge  (cost=122961.41..123078.09 rows=1000 width=56) (actual time=13536.494..13561.923 rows=1500 loops=1)
--                      Workers Planned: 2
--                      Workers Launched: 2
--                      ->  Sort  (cost=121961.39..121962.64 rows=500 width=56) (actual time=13495.147..13495.183 rows=500 loops=3)
--                            Sort Key: m.id
--                            Sort Method: quicksort  Memory: 83kB
--                            Worker 0:  Sort Method: quicksort  Memory: 83kB
--                            Worker 1:  Sort Method: quicksort  Memory: 83kB
--                            ->  Partial HashAggregate  (cost=121932.72..121938.97 rows=500 width=56) (actual time=13494.748..13494.990 rows=500 loops=3)
--                                  Group Key: m.id
--                                  Batches: 1  Memory Usage: 297kB
--                                  Worker 0:  Batches: 1  Memory Usage: 297kB
--                                  Worker 1:  Batches: 1  Memory Usage: 297kB
--                                  ->  Hash Join  (cost=113593.09..121379.11 rows=110722 width=30) (actual time=13113.653..13460.832 rows=81686 loops=3)
--                                        Hash Cond: (s.movie_id = m.id)
--                                        ->  Parallel Hash Join  (cost=113577.84..121070.76 rows=110722 width=14) (actual time=13091.969..13417.819 rows=81686 loops=3)
--                                              Hash Cond: (s.id = t.show_id)
--                                              ->  Parallel Seq Scan on shows s  (cost=0.00..6250.33 rows=208333 width=16) (actual time=1.723..212.306 rows=166667 loops=3)
--                                              ->  Parallel Hash  (cost=112193.81..112193.81 rows=110722 width=14) (actual time=13087.887..13087.893 rows=81686 loops=3)
--                                                    Buckets: 524288  Batches: 1  Memory Usage: 15648kB
--                                                    ->  Parallel Hash Join  (cost=33239.47..112193.81 rows=110722 width=14) (actual time=7811.852..12969.762 rows=81686 loops=3)
--                                                          Hash Cond: (t.id = sales.ticket_id)
--                                                          ->  Parallel Seq Scan on tickets t  (cost=0.00..69118.00 rows=2500000 width=16) (actual time=1.881..3504.515 rows=2000000 loops=3)
--                                                          ->  Parallel Hash  (cost=31855.45..31855.45 rows=110722 width=14) (actual time=7807.791..7807.792 rows=81686 loops=3)
--                                                                Buckets: 524288  Batches: 1  Memory Usage: 15648kB
--                                                                ->  Parallel Bitmap Heap Scan on sales  (cost=3628.20..31855.45 rows=110722 width=14) (actual time=18.787..7687.692 rows=81686 loops=3)
--                                                                      Recheck Cond: ((date >= (CURRENT_DATE - '6 days'::interval)) AND (date <= CURRENT_DATE))
--                                                                      Heap Blocks: exact=8687
--                                                                      ->  Bitmap Index Scan on sales_date_idx  (cost=0.00..3561.77 rows=265733 width=0) (actual time=46.968..46.969 rows=245059 loops=1)
--                                                                            Index Cond: ((date >= (CURRENT_DATE - '6 days'::interval)) AND (date <= CURRENT_DATE))
--                                        ->  Hash  (cost=9.00..9.00 rows=500 width=24) (actual time=21.661..21.662 rows=500 loops=3)
--                                              Buckets: 1024  Batches: 1  Memory Usage: 38kB
--                                              ->  Seq Scan on movies m  (cost=0.00..9.00 rows=500 width=24) (actual time=20.985..21.527 rows=500 loops=3)
--  Planning Time: 53.939 ms
--  JIT:
--    Functions: 115
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 5.076 ms, Inlining 0.000 ms, Optimization 3.978 ms, Emission 90.223 ms, Total 99.276 ms
--  Execution Time: 13648.521 ms
