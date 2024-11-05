-- 2 Подсчёт проданных билетов за неделю

SELECT COUNT(*) FROM ticket WHERE sale_datetime BETWEEN CURRENT_DATE - interval '6 days' AND NOW();

-- 10.000 строк в таблице ticket

"Aggregate  (cost=300.57..300.58 rows=1 width=8) (actual time=2.882..2.883 rows=1 loops=1)"
"  ->  Seq Scan on ticket  (cost=0.00..299.00 rows=629 width=0) (actual time=0.005..2.856 rows=600 loops=1)"
"        Filter: ((sale_datetime <= now()) AND (sale_datetime >= (CURRENT_DATE - '6 days'::interval)))"
"        Rows Removed by Filter: 9400"
"Planning Time: 0.093 ms"
"Execution Time: 2.901 ms"

-- 1.000.000 строк в таблице ticket

"Finalize Aggregate  (cost=17728.70..17728.71 rows=1 width=8) (actual time=101.707..106.834 rows=1 loops=1)"
"  ->  Gather  (cost=17728.48..17728.69 rows=2 width=8) (actual time=101.551..106.823 rows=3 loops=1)"
"        Workers Planned: 2"
"        Workers Launched: 2"
"        ->  Partial Aggregate  (cost=16728.48..16728.49 rows=1 width=8) (actual time=76.211..76.212 rows=1 loops=3)"
"              ->  Parallel Seq Scan on ticket  (cost=0.00..16728.00 rows=193 width=0) (actual time=42.819..76.138 rows=200 loops=3)"
"                    Filter: ((sale_datetime <= now()) AND (sale_datetime >= (CURRENT_DATE - '6 days'::interval)))"
"                    Rows Removed by Filter: 333133"
"Planning Time: 0.539 ms"
"Execution Time: 106.946 ms"

-- оптимизация

CREATE INDEX ticket_sale_datetime_idx ON ticket (sale_datetime)

-- результат: использование индекса

"Aggregate  (cost=17.10..17.11 rows=1 width=8) (actual time=0.193..0.194 rows=1 loops=1)"
"  ->  Index Only Scan using ticket_sale_datetime_idx on ticket  (cost=0.43..15.69 rows=563 width=0) (actual time=0.030..0.119 rows=600 loops=1)"
"        Index Cond: ((sale_datetime >= (CURRENT_DATE - '6 days'::interval)) AND (sale_datetime <= now()))"
"        Heap Fetches: 0"
"Planning Time: 0.652 ms"
"Execution Time: 0.230 ms"