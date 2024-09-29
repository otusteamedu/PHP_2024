-- 6 Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

/*
	ограничение прменения: использовать для сеанса, продажи билетов на который уже закрыты,
	данные на откртые продажи см. запрос "query-6_1"
*/

WITH scan_price AS (
SELECT tariff_price 
FROM ticket_part
WHERE schedule_id = 1
),
get_price AS (
SELECT tariff_price,
    ROW_NUMBER() OVER (ORDER BY tariff_price DESC) AS min_price_row, 
    ROW_NUMBER() OVER (ORDER BY tariff_price ASC) AS max_price_row
FROM scan_price
)

SELECT tariff_price
FROM get_price
WHERE min_price_row = 1 OR max_price_row = 1;

/*
    Спойлер!

    Оптимизация: ситуация аналогичная первому варианту на миллионе строк - партиционирование и наличие ранее созданных индексов делают результативно своё дело.
*/

-- 10.000 строк в таблицах movie, schedule, ticket

"Subquery Scan on get_price  (cost=200.21..200.86 rows=2 width=5) (actual time=3.488..3.506 rows=2 loops=1)"
"  Filter: ((get_price.min_price_row = 1) OR (get_price.max_price_row = 1))"
"  Rows Removed by Filter: 18"
"  ->  WindowAgg  (cost=200.21..200.56 rows=20 width=21) (actual time=3.484..3.497 rows=20 loops=1)"
"        ->  Sort  (cost=200.21..200.26 rows=20 width=13) (actual time=3.480..3.483 rows=20 loops=1)"
"              Sort Key: ticket.tariff_price"
"              Sort Method: quicksort  Memory: 25kB"
"              ->  WindowAgg  (cost=199.43..199.78 rows=20 width=13) (actual time=3.439..3.456 rows=20 loops=1)"
"                    ->  Sort  (cost=199.43..199.48 rows=20 width=5) (actual time=3.428..3.432 rows=20 loops=1)"
"                          Sort Key: ticket.tariff_price DESC"
"                          Sort Method: quicksort  Memory: 25kB"
"                          ->  Seq Scan on ticket  (cost=0.00..199.00 rows=20 width=5) (actual time=0.020..3.409 rows=20 loops=1)"
"                                Filter: (schedule_id = 1)"
"                                Rows Removed by Filter: 9980"
"Planning Time: 0.484 ms"
"Execution Time: 3.584 ms"

-- 1.000.000 строк в таблицах movie, schedule, ticket

"Subquery Scan on get_price  (cost=78.73..82.30 rows=2 width=7) (actual time=0.271..0.286 rows=2 loops=1)"
"  Filter: ((get_price.min_price_row = 1) OR (get_price.max_price_row = 1))"
"  Rows Removed by Filter: 18"
"  ->  WindowAgg  (cost=78.73..80.65 rows=110 width=23) (actual time=0.269..0.280 rows=20 loops=1)"
"        ->  Sort  (cost=78.73..79.00 rows=110 width=15) (actual time=0.266..0.270 rows=20 loops=1)"
"              Sort Key: ticket_part.tariff_price"
"              Sort Method: quicksort  Memory: 25kB"
"              ->  WindowAgg  (cost=73.07..75.00 rows=110 width=15) (actual time=0.211..0.227 rows=20 loops=1)"
"                    ->  Sort  (cost=73.07..73.35 rows=110 width=7) (actual time=0.202..0.207 rows=20 loops=1)"
"                          Sort Key: ticket_part.tariff_price DESC"
"                          Sort Method: quicksort  Memory: 25kB"
"                          ->  Append  (cost=4.19..69.34 rows=110 width=7) (actual time=0.178..0.188 rows=20 loops=1)"
"                                ->  Bitmap Heap Scan on ticket_up_1980 ticket_part_1  (cost=4.19..12.66 rows=5 width=32) (actual time=0.005..0.005 rows=0 loops=1)"
"                                      Recheck Cond: (schedule_id = 1)"
"                                      ->  Bitmap Index Scan on ticket_up_1980_schedule_id_idx  (cost=0.00..4.19 rows=5 width=0) (actual time=0.003..0.003 rows=0 loops=1)"
"                                            Index Cond: (schedule_id = 1)"
"                                ->  Bitmap Heap Scan on ticket_up_1990 ticket_part_2  (cost=4.19..12.66 rows=5 width=32) (actual time=0.002..0.002 rows=0 loops=1)"
"                                      Recheck Cond: (schedule_id = 1)"
"                                      ->  Bitmap Index Scan on ticket_up_1990_schedule_id_idx  (cost=0.00..4.19 rows=5 width=0) (actual time=0.002..0.002 rows=0 loops=1)"
"                                            Index Cond: (schedule_id = 1)"
"                                ->  Index Scan using ticket_up_2000_schedule_id_idx on ticket_up_2000 ticket_part_3  (cost=0.29..8.64 rows=20 width=5) (actual time=0.030..0.031 rows=0 loops=1)"
"                                      Index Cond: (schedule_id = 1)"
"                                ->  Index Scan using ticket_up_2010_schedule_id_idx on ticket_up_2010 ticket_part_4  (cost=0.42..8.77 rows=20 width=5) (actual time=0.033..0.033 rows=0 loops=1)"
"                                      Index Cond: (schedule_id = 1)"
"                                ->  Index Scan using ticket_up_2020_schedule_id_idx on ticket_up_2020 ticket_part_5  (cost=0.42..8.77 rows=20 width=5) (actual time=0.036..0.036 rows=0 loops=1)"
"                                      Index Cond: (schedule_id = 1)"
"                                ->  Index Scan using ticket_up_2030_schedule_id_idx on ticket_up_2030 ticket_part_6  (cost=0.29..8.64 rows=20 width=5) (actual time=0.027..0.027 rows=0 loops=1)"
"                                      Index Cond: (schedule_id = 1)"
"                                ->  Index Scan using ticket_current_schedule_id_idx on ticket_current ticket_part_7  (cost=0.29..8.64 rows=20 width=5) (actual time=0.044..0.049 rows=20 loops=1)"
"                                      Index Cond: (schedule_id = 1)"
"Planning Time: 1.953 ms"
"Execution Time: 0.406 ms"