-- Количество роданных билетов за неделю
select count(tt.id) as ticket_sold_count
from tbl_ticket tt
WHERE tt.time_paid BETWEEN CURRENT_DATE - (EXTRACT(DOW FROM CURRENT_DATE)::INTEGER - 1)
     AND CURRENT_DATE + (7 - EXTRACT(DOW FROM CURRENT_DATE)::INTEGER)

/**
< 10000 записей запрос без индексов
Aggregate  (cost=445.00..445.01 rows=1 width=8) (actual time=3.794..3.795 rows=1 loops=1)
  ->  Seq Scan on tbl_ticket tt  (cost=0.00..444.60 rows=160 width=4) (actual time=0.037..3.778 rows=167 loops=1)
        Filter: ((time_paid >= (CURRENT_DATE - ((date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer - 1))) AND (time_paid <= (CURRENT_DATE + (7 - (date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer))))
        Rows Removed by Filter: 7645
Planning Time: 0.197 ms
Execution Time: 3.820 ms



< 10000 добавил индекс tbl_ticket_time_paid_idx запрос значительно улучшился
Aggregate  (cost=68.36..68.37 rows=1 width=8) (actual time=0.075..0.076 rows=1 loops=1)
  ->  Bitmap Heap Scan on tbl_ticket tt  (cost=5.96..67.96 rows=160 width=4) (actual time=0.023..0.060 rows=167 loops=1)
        Recheck Cond: ((time_paid >= (CURRENT_DATE - ((date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer - 1))) AND (time_paid <= (CURRENT_DATE + (7 - (date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer))))
        Heap Blocks: exact=16
        ->  Bitmap Index Scan on tbl_ticket_time_paid_idx  (cost=0.00..5.92 rows=160 width=0) (actual time=0.015..0.015 rows=167 loops=1)
              Index Cond: ((time_paid >= (CURRENT_DATE - ((date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer - 1))) AND (time_paid <= (CURRENT_DATE + (7 - (date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer))))
Planning Time: 0.319 ms
Execution Time: 0.102 ms
 */