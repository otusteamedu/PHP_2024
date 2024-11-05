-- 6 Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс 

/*
	ограничение прменения: использовать для сеанса, продажи билетов на который ещё открыты,
	исторические данные см. запрос "query-6_2"
*/

WITH scan_price AS (
SELECT 
	(movie.min_price + tariff_movie.tariff_value + tariff_hall.tariff_value + tariff_seat.tariff_value + tariff_schedule.tariff_value) AS tariff_price
FROM schedule_part schedule
JOIN movie movie ON schedule.movie_id = movie.id
JOIN hall hall ON schedule.hall_id = hall.id
JOIN seat_scheme seat_scheme ON hall.seat_scheme_id = seat_scheme.id
JOIN seat_layout seat_layout ON seat_layout.seat_scheme_id = seat_scheme.id
JOIN seat_location seat_location ON seat_layout.location_id = seat_location.id
JOIN tariff tariff_movie ON tariff_movie.price_key_id = 1 
	AND tariff_movie.price_category_id = movie.price_category_id
JOIN tariff tariff_hall ON tariff_hall.price_key_id = 2 
	AND tariff_hall.price_category_id = hall.price_category_id
JOIN tariff tariff_seat ON tariff_seat.price_key_id = 3 
	AND tariff_seat.price_category_id = seat_layout.location_id			
JOIN tariff tariff_schedule ON tariff_schedule.price_key_id = 4 
	AND tariff_schedule.price_category_id = schedule.price_category_id
WHERE schedule.id = 1
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

	Оптимизация: 

	в данном случае на миллионе строк получаем результат: "Execution Time: 0.645 ms" (см. ниже).
	Думаю, это следствие того, что база уже имеет оптимальную структуру для данного запроса, поскольку динамическое определение цены на конкретное место,
	хоть и зависит от нескольких переменных, но эти переменные содержаться в небольших таблицах, которые быстро джойнятся.
*/

-- 10.000 строк в таблицах movie, schedule, ticket

"Subquery Scan on get_price  (cost=128.17..128.22 rows=1 width=32) (actual time=0.512..0.541 rows=2 loops=1)"
"  Filter: ((get_price.min_price_row = 1) OR (get_price.max_price_row = 1))"
"  Rows Removed by Filter: 18"
"  ->  WindowAgg  (cost=128.17..128.20 rows=1 width=48) (actual time=0.508..0.531 rows=20 loops=1)"
"        ->  Sort  (cost=128.17..128.18 rows=1 width=40) (actual time=0.505..0.514 rows=20 loops=1)"
"              Sort Key: (((((movie.min_price + tariff_movie.tariff_value) + tariff_hall.tariff_value) + tariff_seat.tariff_value) + tariff_schedule.tariff_value))"
"              Sort Method: quicksort  Memory: 25kB"
"              ->  WindowAgg  (cost=128.13..128.16 rows=1 width=40) (actual time=0.464..0.491 rows=20 loops=1)"
"                    ->  Sort  (cost=128.13..128.14 rows=1 width=32) (actual time=0.412..0.422 rows=20 loops=1)"
"                          Sort Key: (((((movie.min_price + tariff_movie.tariff_value) + tariff_hall.tariff_value) + tariff_seat.tariff_value) + tariff_schedule.tariff_value)) DESC"
"                          Sort Method: quicksort  Memory: 25kB"
"                          ->  Nested Loop  (cost=21.53..128.12 rows=1 width=32) (actual time=0.140..0.403 rows=20 loops=1)"
"                                Join Filter: (schedule.price_category_id = tariff_schedule.price_category_id)"
"                                Rows Removed by Join Filter: 40"
"                                ->  Nested Loop  (cost=21.53..103.91 rows=1 width=105) (actual time=0.133..0.328 rows=20 loops=1)"
"                                      Join Filter: (seat_layout.location_id = tariff_seat.price_category_id)"
"                                      Rows Removed by Join Filter: 40"
"                                      ->  Nested Loop  (cost=21.53..79.71 rows=1 width=81) (actual time=0.131..0.268 rows=20 loops=1)"
"                                            Join Filter: (hall.price_category_id = tariff_hall.price_category_id)"
"                                            Rows Removed by Join Filter: 40"
"                                            ->  Nested Loop  (cost=21.53..55.51 rows=1 width=53) (actual time=0.128..0.204 rows=20 loops=1)"
"                                                  ->  Nested Loop  (cost=21.38..55.32 rows=1 width=49) (actual time=0.073..0.125 rows=24 loops=1)"
"                                                        Join Filter: (seat_scheme.id = hall.seat_scheme_id)"
"                                                        ->  Hash Join  (cost=21.23..55.11 rows=1 width=57) (actual time=0.068..0.087 rows=24 loops=1)"
"                                                              Hash Cond: (seat_layout.seat_scheme_id = hall.seat_scheme_id)"
"                                                              ->  Seq Scan on seat_layout  (cost=0.00..27.30 rows=1730 width=8) (actual time=0.007..0.010 rows=24 loops=1)"
"                                                              ->  Hash  (cost=21.22..21.22 rows=1 width=49) (actual time=0.053..0.056 rows=1 loops=1)"
"                                                                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                                                                    ->  Nested Loop  (cost=8.75..21.22 rows=1 width=49) (actual time=0.044..0.053 rows=1 loops=1)"
"                                                                          ->  Merge Join  (cost=8.60..13.02 rows=1 width=45) (actual time=0.034..0.043 rows=1 loops=1)"
"                                                                                Merge Cond: (movie.id = schedule.movie_id)"
"                                                                                ->  Nested Loop  (cost=0.29..1321.42 rows=300 width=41) (actual time=0.020..0.027 rows=2 loops=1)"
"                                                                                      Join Filter: (movie.price_category_id = tariff_movie.price_category_id)"
"                                                                                      Rows Removed by Join Filter: 2"
"                                                                                      ->  Index Scan using movie_pkey on movie  (cost=0.29..397.29 rows=10000 width=13) (actual time=0.009..0.010 rows=2 loops=1)"
"                                                                                      ->  Materialize  (cost=0.00..24.16 rows=6 width=36) (actual time=0.004..0.006 rows=2 loops=2)"
"                                                                                            ->  Seq Scan on tariff tariff_movie  (cost=0.00..24.12 rows=6 width=36) (actual time=0.006..0.008 rows=3 loops=1)"
"                                                                                                  Filter: (price_key_id = 1)"
"                                                                                                  Rows Removed by Filter: 9"
"                                                                                ->  Sort  (cost=8.31..8.32 rows=1 width=12) (actual time=0.012..0.012 rows=1 loops=1)"
"                                                                                      Sort Key: schedule.movie_id"
"                                                                                      Sort Method: quicksort  Memory: 25kB"
"                                                                                      ->  Index Scan using schedule_pkey on schedule  (cost=0.29..8.30 rows=1 width=12) (actual time=0.007..0.008 rows=1 loops=1)"
"                                                                                            Index Cond: (id = 1)"
"                                                                          ->  Index Scan using hall_pkey on hall  (cost=0.15..8.17 rows=1 width=12) (actual time=0.007..0.007 rows=1 loops=1)"
"                                                                                Index Cond: (id = schedule.hall_id)"
"                                                        ->  Index Only Scan using seat_scheme_pkey on seat_scheme  (cost=0.15..0.20 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=24)"
"                                                              Index Cond: (id = seat_layout.seat_scheme_id)"
"                                                              Heap Fetches: 24"
"                                                  ->  Index Only Scan using seat_location_pkey on seat_location  (cost=0.15..0.20 rows=1 width=4) (actual time=0.003..0.003 rows=1 loops=24)"
"                                                        Index Cond: (id = seat_layout.location_id)"
"                                                        Heap Fetches: 20"
"                                            ->  Seq Scan on tariff tariff_hall  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.002 rows=3 loops=20)"
"                                                  Filter: (price_key_id = 2)"
"                                                  Rows Removed by Filter: 9"
"                                      ->  Seq Scan on tariff tariff_seat  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.002 rows=3 loops=20)"
"                                            Filter: (price_key_id = 3)"
"                                            Rows Removed by Filter: 9"
"                                ->  Seq Scan on tariff tariff_schedule  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.002 rows=3 loops=20)"
"                                      Filter: (price_key_id = 4)"
"                                      Rows Removed by Filter: 9"
"Planning Time: 2.085 ms"
"Execution Time: 0.739 ms"

-- 1.000.000 строк в таблицах movie, schedule, ticket

"Subquery Scan on get_price  (cost=215.87..215.91 rows=1 width=32) (actual time=0.479..0.493 rows=2 loops=1)"
"  Filter: ((get_price.min_price_row = 1) OR (get_price.max_price_row = 1))"
"  Rows Removed by Filter: 18"
"  ->  WindowAgg  (cost=215.87..215.90 rows=1 width=48) (actual time=0.469..0.480 rows=20 loops=1)"
"        ->  Sort  (cost=215.87..215.87 rows=1 width=40) (actual time=0.467..0.474 rows=20 loops=1)"
"              Sort Key: (((((movie.min_price + tariff_movie.tariff_value) + tariff_hall.tariff_value) + tariff_seat.tariff_value) + tariff_schedule.tariff_value))"
"              Sort Method: quicksort  Memory: 25kB"
"              ->  WindowAgg  (cost=215.83..215.86 rows=1 width=40) (actual time=0.443..0.455 rows=20 loops=1)"
"                    ->  Sort  (cost=215.83..215.83 rows=1 width=32) (actual time=0.438..0.445 rows=20 loops=1)"
"                          Sort Key: (((((movie.min_price + tariff_movie.tariff_value) + tariff_hall.tariff_value) + tariff_seat.tariff_value) + tariff_schedule.tariff_value)) DESC"
"                          Sort Method: quicksort  Memory: 25kB"
"                          ->  Nested Loop  (cost=101.27..215.82 rows=1 width=32) (actual time=0.298..0.435 rows=20 loops=1)"
"                                Join Filter: (schedule.price_category_id = tariff_schedule.price_category_id)"
"                                Rows Removed by Join Filter: 40"
"                                ->  Nested Loop  (cost=101.27..191.61 rows=1 width=105) (actual time=0.293..0.402 rows=20 loops=1)"
"                                      Join Filter: (seat_layout.location_id = tariff_seat.price_category_id)"
"                                      Rows Removed by Join Filter: 40"
"                                      ->  Nested Loop  (cost=101.27..167.41 rows=1 width=81) (actual time=0.289..0.376 rows=20 loops=1)"
"                                            Join Filter: (movie.price_category_id = tariff_movie.price_category_id)"
"                                            Rows Removed by Join Filter: 40"
"                                            ->  Nested Loop  (cost=101.27..143.21 rows=1 width=53) (actual time=0.287..0.348 rows=20 loops=1)"
"                                                  ->  Nested Loop  (cost=101.12..143.01 rows=1 width=49) (actual time=0.262..0.314 rows=24 loops=1)"
"                                                        ->  Hash Join  (cost=100.69..134.57 rows=1 width=44) (actual time=0.239..0.251 rows=24 loops=1)"
"                                                              Hash Cond: (seat_layout.seat_scheme_id = hall.seat_scheme_id)"
"                                                              ->  Seq Scan on seat_layout  (cost=0.00..27.30 rows=1730 width=8) (actual time=0.025..0.026 rows=24 loops=1)"
"                                                              ->  Hash  (cost=100.68..100.68 rows=1 width=48) (actual time=0.204..0.209 rows=1 loops=1)"
"                                                                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                                                                    ->  Nested Loop  (cost=42.12..100.68 rows=1 width=48) (actual time=0.200..0.206 rows=1 loops=1)"
"                                                                          ->  Hash Join  (cost=41.97..100.42 rows=1 width=44) (actual time=0.167..0.172 rows=1 loops=1)"
"                                                                                Hash Cond: (schedule.hall_id = hall.id)"
"                                                                                ->  Append  (cost=0.42..58.83 rows=7 width=12) (actual time=0.125..0.128 rows=1 loops=1)"
"                                                                                      ->  Index Scan using schedule_up_1980_pkey on schedule_up_1980 schedule_1  (cost=0.42..8.44 rows=1 width=12) (actual time=0.019..0.019 rows=0 loops=1)"
"                                                                                            Index Cond: (id = 1)"
"                                                                                      ->  Index Scan using schedule_up_1990_pkey on schedule_up_1990 schedule_2  (cost=0.42..8.44 rows=1 width=12) (actual time=0.018..0.018 rows=0 loops=1)"
"                                                                                            Index Cond: (id = 1)"
"                                                                                      ->  Index Scan using schedule_up_2000_pkey on schedule_up_2000 schedule_3  (cost=0.42..8.44 rows=1 width=12) (actual time=0.018..0.018 rows=0 loops=1)"
"                                                                                            Index Cond: (id = 1)"
"                                                                                      ->  Index Scan using schedule_up_2010_pkey on schedule_up_2010 schedule_4  (cost=0.42..8.44 rows=1 width=12) (actual time=0.016..0.016 rows=0 loops=1)"
"                                                                                            Index Cond: (id = 1)"
"                                                                                      ->  Index Scan using schedule_up_2020_pkey on schedule_up_2020 schedule_5  (cost=0.42..8.44 rows=1 width=12) (actual time=0.022..0.022 rows=0 loops=1)"
"                                                                                            Index Cond: (id = 1)"
"                                                                                      ->  Index Scan using schedule_up_2030_pkey on schedule_up_2030 schedule_6  (cost=0.29..8.31 rows=1 width=12) (actual time=0.013..0.013 rows=0 loops=1)"
"                                                                                            Index Cond: (id = 1)"
"                                                                                      ->  Index Scan using schedule_current_pkey on schedule_current schedule_7  (cost=0.29..8.30 rows=1 width=12) (actual time=0.020..0.021 rows=1 loops=1)"
"                                                                                            Index Cond: (id = 1)"
"                                                                                ->  Hash  (cost=41.36..41.36 rows=15 width=40) (actual time=0.033..0.035 rows=10 loops=1)"
"                                                                                      Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                                                                                      ->  Hash Join  (cost=24.20..41.36 rows=15 width=40) (actual time=0.029..0.032 rows=10 loops=1)"
"                                                                                            Hash Cond: (hall.price_category_id = tariff_hall.price_category_id)"
"                                                                                            ->  Seq Scan on hall  (cost=0.00..15.10 rows=510 width=12) (actual time=0.007..0.007 rows=10 loops=1)"
"                                                                                            ->  Hash  (cost=24.12..24.12 rows=6 width=36) (actual time=0.010..0.011 rows=3 loops=1)"
"                                                                                                  Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                                                                                                  ->  Seq Scan on tariff tariff_hall  (cost=0.00..24.12 rows=6 width=36) (actual time=0.007..0.007 rows=3 loops=1)"
"                                                                                                        Filter: (price_key_id = 2)"
"                                                                                                        Rows Removed by Filter: 9"
"                                                                          ->  Index Only Scan using seat_scheme_pkey on seat_scheme  (cost=0.15..0.26 rows=1 width=4) (actual time=0.031..0.031 rows=1 loops=1)"
"                                                                                Index Cond: (id = hall.seat_scheme_id)"
"                                                                                Heap Fetches: 1"
"                                                        ->  Index Scan using movie_pkey on movie  (cost=0.42..8.44 rows=1 width=13) (actual time=0.002..0.002 rows=1 loops=24)"
"                                                              Index Cond: (id = schedule.movie_id)"
"                                                  ->  Index Only Scan using seat_location_pkey on seat_location  (cost=0.15..0.20 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=24)"
"                                                        Index Cond: (id = seat_layout.location_id)"
"                                                        Heap Fetches: 20"
"                                            ->  Seq Scan on tariff tariff_movie  (cost=0.00..24.12 rows=6 width=36) (actual time=0.000..0.001 rows=3 loops=20)"
"                                                  Filter: (price_key_id = 1)"
"                                                  Rows Removed by Filter: 9"
"                                      ->  Seq Scan on tariff tariff_seat  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.001 rows=3 loops=20)"
"                                            Filter: (price_key_id = 3)"
"                                            Rows Removed by Filter: 9"
"                                ->  Seq Scan on tariff tariff_schedule  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.001 rows=3 loops=20)"
"                                      Filter: (price_key_id = 4)"
"                                      Rows Removed by Filter: 9"
"Planning Time: 4.465 ms"
"Execution Time: 0.645 ms"