--5 Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

SELECT 
	schedule.id, schedule.movie_id, movie.title AS "название фильма", schedule.hall_id, hall.title AS зал, 
	seat_layout.row_number AS ряд, seat_layout.cell_number, 
	(
        CASE
            WHEN seat_layout.is_seat THEN 'кресло'
            WHEN NOT seat_layout.is_seat THEN 'проход'
        END
    ) AS "на схеме",
	seat_layout.seat_number, seat_layout.location_id,
	seat_location.title,
	(
        CASE
            WHEN ticket.tariff_price IS NOT NULL THEN 'продано'
            WHEN ticket.tariff_price IS NULL AND seat_layout.is_seat THEN 'свободно'
        END
    ) AS статус,
	(
		CASE
			WHEN ticket.tariff_price IS NULL AND seat_layout.is_seat
			THEN movie.min_price + tariff_movie.tariff_value + tariff_hall.tariff_value + tariff_seat.tariff_value + tariff_schedule.tariff_value
        END
	) AS цена
FROM schedule schedule
JOIN movie movie ON schedule.movie_id = movie.id
JOIN hall hall ON schedule.hall_id = hall.id
JOIN seat_scheme seat_scheme ON hall.seat_scheme_id = seat_scheme.id
JOIN seat_layout seat_layout ON seat_layout.seat_scheme_id = seat_scheme.id
LEFT JOIN seat_location seat_location ON seat_layout.location_id = seat_location.id
LEFT JOIN ticket ticket ON schedule.id = ticket.schedule_id 
	AND ticket.row_number = seat_layout.row_number AND ticket.seat_number = seat_layout.seat_number
JOIN tariff tariff_movie ON tariff_movie.price_key_id = 1 
	AND tariff_movie.price_category_id = movie.price_category_id
JOIN tariff tariff_hall ON tariff_hall.price_key_id = 2 
	AND tariff_hall.price_category_id = hall.price_category_id
LEFT JOIN tariff tariff_seat ON tariff_seat.price_key_id = 3 
	AND tariff_seat.price_category_id = seat_layout.location_id			
JOIN tariff tariff_schedule ON tariff_schedule.price_key_id = 4 
	AND tariff_schedule.price_category_id = schedule.price_category_id
WHERE schedule.id = 1;

-- 10.000 строк в таблицах movie, schedule, ticket

"Nested Loop  (cost=21.53..327.42 rows=1 width=380) (actual time=0.585..10.166 rows=24 loops=1)"
"  Join Filter: (schedule.price_category_id = tariff_schedule.price_category_id)"
"  Rows Removed by Join Filter: 48"
"  ->  Nested Loop Left Join  (cost=21.53..303.21 rows=1 width=395) (actual time=0.581..10.130 rows=24 loops=1)"
"        Join Filter: (tariff_seat.price_category_id = seat_layout.location_id)"
"        Rows Removed by Join Filter: 52"
"        ->  Nested Loop  (cost=21.53..279.01 rows=1 width=363) (actual time=0.579..10.100 rows=24 loops=1)"
"              Join Filter: (hall.price_category_id = tariff_hall.price_category_id)"
"              Rows Removed by Join Filter: 48"
"              ->  Nested Loop Left Join  (cost=21.53..254.81 rows=1 width=335) (actual time=0.577..10.066 rows=24 loops=1)"
"                    Join Filter: ((ticket.row_number = seat_layout.row_number) AND (ticket.seat_number = seat_layout.seat_number))"
"                    Rows Removed by Join Filter: 460"
"                    ->  Nested Loop Left Join  (cost=21.53..55.51 rows=1 width=330) (actual time=0.126..0.204 rows=24 loops=1)"
"                          ->  Nested Loop  (cost=21.38..55.32 rows=1 width=212) (actual time=0.123..0.166 rows=24 loops=1)"
"                                Join Filter: (seat_scheme.id = hall.seat_scheme_id)"
"                                ->  Hash Join  (cost=21.23..55.11 rows=1 width=220) (actual time=0.099..0.116 rows=24 loops=1)"
"                                      Hash Cond: (seat_layout.seat_scheme_id = hall.seat_scheme_id)"
"                                      ->  Seq Scan on seat_layout  (cost=0.00..27.30 rows=1730 width=15) (actual time=0.019..0.022 rows=24 loops=1)"
"                                      ->  Hash  (cost=21.22..21.22 rows=1 width=205) (actual time=0.068..0.071 rows=1 loops=1)"
"                                            Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                                            ->  Nested Loop  (cost=8.75..21.22 rows=1 width=205) (actual time=0.061..0.068 rows=1 loops=1)"
"                                                  ->  Merge Join  (cost=8.60..13.02 rows=1 width=79) (actual time=0.044..0.050 rows=1 loops=1)"
"                                                        Merge Cond: (movie.id = schedule.movie_id)"
"                                                        ->  Nested Loop  (cost=0.29..1321.42 rows=300 width=67) (actual time=0.026..0.030 rows=2 loops=1)"
"                                                              Join Filter: (movie.price_category_id = tariff_movie.price_category_id)"
"                                                              Rows Removed by Join Filter: 2"
"                                                              ->  Index Scan using movie_pkey on movie  (cost=0.29..397.29 rows=10000 width=39) (actual time=0.009..0.009 rows=2 loops=1)"
"                                                              ->  Materialize  (cost=0.00..24.16 rows=6 width=36) (actual time=0.008..0.009 rows=2 loops=2)"
"                                                                    ->  Seq Scan on tariff tariff_movie  (cost=0.00..24.12 rows=6 width=36) (actual time=0.013..0.014 rows=3 loops=1)"
"                                                                          Filter: (price_key_id = 1)"
"                                                                          Rows Removed by Filter: 9"
"                                                        ->  Sort  (cost=8.31..8.32 rows=1 width=16) (actual time=0.016..0.017 rows=1 loops=1)"
"                                                              Sort Key: schedule.movie_id"
"                                                              Sort Method: quicksort  Memory: 25kB"
"                                                              ->  Index Scan using schedule_pkey on schedule  (cost=0.29..8.30 rows=1 width=16) (actual time=0.008..0.009 rows=1 loops=1)"
"                                                                    Index Cond: (id = 1)"
"                                                  ->  Index Scan using hall_pkey on hall  (cost=0.15..8.17 rows=1 width=130) (actual time=0.015..0.015 rows=1 loops=1)"
"                                                        Index Cond: (id = schedule.hall_id)"
"                                ->  Index Only Scan using seat_scheme_pkey on seat_scheme  (cost=0.15..0.20 rows=1 width=4) (actual time=0.002..0.002 rows=1 loops=24)"
"                                      Index Cond: (id = seat_layout.seat_scheme_id)"
"                                      Heap Fetches: 24"
"                          ->  Index Scan using seat_location_pkey on seat_location  (cost=0.15..0.20 rows=1 width=122) (actual time=0.001..0.001 rows=1 loops=24)"
"                                Index Cond: (id = seat_layout.location_id)"
"                    ->  Seq Scan on ticket  (cost=0.00..199.00 rows=20 width=13) (actual time=0.001..0.409 rows=20 loops=24)"
"                          Filter: (schedule_id = 1)"
"                          Rows Removed by Filter: 9980"
"              ->  Seq Scan on tariff tariff_hall  (cost=0.00..24.12 rows=6 width=36) (actual time=0.000..0.001 rows=3 loops=24)"
"                    Filter: (price_key_id = 2)"
"                    Rows Removed by Filter: 9"
"        ->  Seq Scan on tariff tariff_seat  (cost=0.00..24.12 rows=6 width=36) (actual time=0.000..0.001 rows=3 loops=24)"
"              Filter: (price_key_id = 3)"
"              Rows Removed by Filter: 9"
"  ->  Seq Scan on tariff tariff_schedule  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.001 rows=3 loops=24)"
"        Filter: (price_key_id = 4)"
"        Rows Removed by Filter: 9"
"Planning Time: 1.784 ms"
"Execution Time: 10.268 ms"

-- 1.000.000 строк в таблицах movie, schedule, ticket

"Nested Loop  (cost=1021.69..13691.91 rows=1 width=381) (actual time=39.915..802.853 rows=24 loops=1)"
"  Join Filter: (schedule.price_category_id = tariff_schedule.price_category_id)"
"  Rows Removed by Join Filter: 48"
"  ->  Nested Loop Left Join  (cost=1021.69..13667.70 rows=1 width=396) (actual time=39.909..802.743 rows=24 loops=1)"
"        Join Filter: (tariff_seat.price_category_id = seat_layout.location_id)"
"        Rows Removed by Join Filter: 52"
"        ->  Nested Loop  (cost=1021.69..13643.50 rows=1 width=364) (actual time=39.904..802.658 rows=24 loops=1)"
"              Join Filter: (hall.price_category_id = tariff_hall.price_category_id)"
"              Rows Removed by Join Filter: 48"
"              ->  Nested Loop Left Join  (cost=1021.69..13619.30 rows=1 width=336) (actual time=39.881..802.418 rows=24 loops=1)"
"                    Join Filter: ((ticket.row_number = seat_layout.row_number) AND (ticket.seat_number = seat_layout.seat_number))"
"                    Rows Removed by Join Filter: 460"
"                    ->  Nested Loop Left Join  (cost=21.69..55.67 rows=1 width=331) (actual time=0.503..1.351 rows=24 loops=1)"
"                          ->  Nested Loop  (cost=21.54..55.48 rows=1 width=213) (actual time=0.489..1.052 rows=24 loops=1)"
"                                Join Filter: (seat_scheme.id = hall.seat_scheme_id)"
"                                ->  Hash Join  (cost=21.39..55.27 rows=1 width=221) (actual time=0.389..0.572 rows=24 loops=1)"
"                                      Hash Cond: (seat_layout.seat_scheme_id = hall.seat_scheme_id)"
"                                      ->  Seq Scan on seat_layout  (cost=0.00..27.30 rows=1730 width=15) (actual time=0.103..0.141 rows=24 loops=1)"
"                                      ->  Hash  (cost=21.38..21.38 rows=1 width=206) (actual time=0.258..0.263 rows=1 loops=1)"
"                                            Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                                            ->  Nested Loop  (cost=9.04..21.38 rows=1 width=206) (actual time=0.249..0.257 rows=1 loops=1)"
"                                                  ->  Merge Join  (cost=8.89..13.18 rows=1 width=80) (actual time=0.182..0.189 rows=1 loops=1)"
"                                                        Merge Cond: (movie.id = schedule.movie_id)"
"                                                        ->  Nested Loop  (cost=0.42..128354.57 rows=30000 width=68) (actual time=0.078..0.083 rows=2 loops=1)"
"                                                              Join Filter: (movie.price_category_id = tariff_movie.price_category_id)"
"                                                              Rows Removed by Join Filter: 2"
"                                                              ->  Index Scan using movie_pkey on movie  (cost=0.42..38330.43 rows=1000000 width=40) (actual time=0.018..0.019 rows=2 loops=1)"
"                                                              ->  Materialize  (cost=0.00..24.16 rows=6 width=36) (actual time=0.029..0.030 rows=2 loops=2)"
"                                                                    ->  Seq Scan on tariff tariff_movie  (cost=0.00..24.12 rows=6 width=36) (actual time=0.040..0.042 rows=3 loops=1)"
"                                                                          Filter: (price_key_id = 1)"
"                                                                          Rows Removed by Filter: 9"
"                                                        ->  Sort  (cost=8.46..8.46 rows=1 width=16) (actual time=0.101..0.102 rows=1 loops=1)"
"                                                              Sort Key: schedule.movie_id"
"                                                              Sort Method: quicksort  Memory: 25kB"
"                                                              ->  Index Scan using id_time_begin_idx on schedule  (cost=0.43..8.45 rows=1 width=16) (actual time=0.039..0.040 rows=1 loops=1)"
"                                                                    Index Cond: (id = 1)"
"                                                  ->  Index Scan using hall_pkey on hall  (cost=0.15..8.17 rows=1 width=130) (actual time=0.064..0.064 rows=1 loops=1)"
"                                                        Index Cond: (id = schedule.hall_id)"
"                                ->  Index Only Scan using seat_scheme_pkey on seat_scheme  (cost=0.15..0.20 rows=1 width=4) (actual time=0.013..0.013 rows=1 loops=24)"
"                                      Index Cond: (id = seat_layout.seat_scheme_id)"
"                                      Heap Fetches: 24"
"                          ->  Index Scan using seat_location_pkey on seat_location  (cost=0.15..0.20 rows=1 width=122) (actual time=0.009..0.009 rows=1 loops=24)"
"                                Index Cond: (id = seat_layout.location_id)"
"                    ->  Gather  (cost=1000.00..13563.33 rows=20 width=13) (actual time=3.300..33.373 rows=20 loops=24)"
"                          Workers Planned: 2"
"                          Workers Launched: 2"
"                          ->  Parallel Seq Scan on ticket  (cost=0.00..12561.33 rows=8 width=13) (actual time=9.724..19.659 rows=7 loops=72)"
"                                Filter: (schedule_id = 1)"
"                                Rows Removed by Filter: 333327"
"              ->  Seq Scan on tariff tariff_hall  (cost=0.00..24.12 rows=6 width=36) (actual time=0.004..0.005 rows=3 loops=24)"
"                    Filter: (price_key_id = 2)"
"                    Rows Removed by Filter: 9"
"        ->  Seq Scan on tariff tariff_seat  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.001 rows=3 loops=24)"
"              Filter: (price_key_id = 3)"
"              Rows Removed by Filter: 9"
"  ->  Seq Scan on tariff tariff_schedule  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.001 rows=3 loops=24)"
"        Filter: (price_key_id = 4)"
"        Rows Removed by Filter: 9"
"Planning Time: 3.288 ms"
"Execution Time: 803.161 ms"

/*
	Оптимизация:

	1. используем ticket_part и schedule_part c результатом "Execution Time: 59.397 ms" 
	2. в дополнение к п.1 CREATE INDEX ticket_part_id_schedule_idx ON ticket_part (schedule_id), результат: "Execution Time: 0.951 ms" 
*/

"Nested Loop  (cost=152.07..325.41 rows=1 width=381) (actual time=0.475..0.836 rows=24 loops=1)"
"  Join Filter: (schedule.price_category_id = tariff_schedule.price_category_id)"
"  Rows Removed by Join Filter: 48"
"  ->  Nested Loop Left Join  (cost=152.07..301.20 rows=1 width=398) (actual time=0.470..0.797 rows=24 loops=1)"
"        Join Filter: (tariff_seat.price_category_id = seat_layout.location_id)"
"        Rows Removed by Join Filter: 52"
"        ->  Nested Loop  (cost=152.07..277.00 rows=1 width=366) (actual time=0.465..0.759 rows=24 loops=1)"
"              Join Filter: (hall.price_category_id = tariff_hall.price_category_id)"
"              Rows Removed by Join Filter: 48"
"              ->  Nested Loop Left Join  (cost=152.07..252.80 rows=1 width=338) (actual time=0.463..0.720 rows=24 loops=1)"
"                    Join Filter: ((ticket.row_number = seat_layout.row_number) AND (ticket.seat_number = seat_layout.seat_number))"
"                    Rows Removed by Join Filter: 460"
"                    ->  Nested Loop Left Join  (cost=147.88..181.80 rows=1 width=331) (actual time=0.354..0.386 rows=24 loops=1)"
"                          ->  Hash Join  (cost=147.73..181.61 rows=1 width=213) (actual time=0.350..0.363 rows=24 loops=1)"
"                                Hash Cond: (seat_layout.seat_scheme_id = hall.seat_scheme_id)"
"                                ->  Seq Scan on seat_layout  (cost=0.00..27.30 rows=1730 width=15) (actual time=0.006..0.008 rows=24 loops=1)"
"                                ->  Hash  (cost=147.72..147.72 rows=1 width=210) (actual time=0.339..0.342 rows=1 loops=1)"
"                                      Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                                      ->  Nested Loop  (cost=1.14..147.72 rows=1 width=210) (actual time=0.329..0.335 rows=1 loops=1)"
"                                            ->  Nested Loop  (cost=0.99..147.45 rows=1 width=206) (actual time=0.321..0.327 rows=1 loops=1)"
"                                                  ->  Nested Loop  (cost=0.84..142.70 rows=1 width=80) (actual time=0.315..0.320 rows=1 loops=1)"
"                                                        Join Filter: (movie.price_category_id = tariff_movie.price_category_id)"
"                                                        Rows Removed by Join Filter: 2"
"                                                        ->  Nested Loop  (cost=0.84..117.93 rows=7 width=52) (actual time=0.306..0.308 rows=1 loops=1)"
"                                                              ->  Append  (cost=0.42..58.83 rows=7 width=16) (actual time=0.287..0.289 rows=1 loops=1)"
"                                                                    ->  Index Scan using schedule_up_1980_pkey on schedule_up_1980 schedule_1  (cost=0.42..8.44 rows=1 width=16) (actual time=0.074..0.075 rows=0 loops=1)"
"                                                                          Index Cond: (id = 1)"
"                                                                    ->  Index Scan using schedule_up_1990_pkey on schedule_up_1990 schedule_2  (cost=0.42..8.44 rows=1 width=16) (actual time=0.023..0.023 rows=0 loops=1)"
"                                                                          Index Cond: (id = 1)"
"                                                                    ->  Index Scan using schedule_up_2000_pkey on schedule_up_2000 schedule_3  (cost=0.42..8.44 rows=1 width=16) (actual time=0.048..0.049 rows=0 loops=1)"
"                                                                          Index Cond: (id = 1)"
"                                                                    ->  Index Scan using schedule_up_2010_pkey on schedule_up_2010 schedule_4  (cost=0.42..8.44 rows=1 width=16) (actual time=0.031..0.031 rows=0 loops=1)"
"                                                                          Index Cond: (id = 1)"
"                                                                    ->  Index Scan using schedule_up_2020_pkey on schedule_up_2020 schedule_5  (cost=0.42..8.44 rows=1 width=16) (actual time=0.055..0.055 rows=0 loops=1)"
"                                                                          Index Cond: (id = 1)"
"                                                                    ->  Index Scan using schedule_up_2030_pkey on schedule_up_2030 schedule_6  (cost=0.29..8.31 rows=1 width=16) (actual time=0.016..0.016 rows=0 loops=1)"
"                                                                          Index Cond: (id = 1)"
"                                                                    ->  Index Scan using schedule_current_pkey on schedule_current schedule_7  (cost=0.29..8.30 rows=1 width=16) (actual time=0.037..0.038 rows=1 loops=1)"
"                                                                          Index Cond: (id = 1)"
"                                                              ->  Index Scan using movie_pkey on movie  (cost=0.42..8.44 rows=1 width=40) (actual time=0.015..0.015 rows=1 loops=1)"
"                                                                    Index Cond: (id = schedule.movie_id)"
"                                                        ->  Materialize  (cost=0.00..24.16 rows=6 width=36) (actual time=0.008..0.010 rows=3 loops=1)"
"                                                              ->  Seq Scan on tariff tariff_movie  (cost=0.00..24.12 rows=6 width=36) (actual time=0.004..0.005 rows=3 loops=1)"
"                                                                    Filter: (price_key_id = 1)"
"                                                                    Rows Removed by Filter: 9"
"                                                  ->  Index Scan using hall_pkey on hall  (cost=0.15..4.74 rows=1 width=130) (actual time=0.005..0.005 rows=1 loops=1)"
"                                                        Index Cond: (id = schedule.hall_id)"
"                                            ->  Index Only Scan using seat_scheme_pkey on seat_scheme  (cost=0.15..0.26 rows=1 width=4) (actual time=0.006..0.007 rows=1 loops=1)"
"                                                  Index Cond: (id = hall.seat_scheme_id)"
"                                                  Heap Fetches: 1"
"                          ->  Index Scan using seat_location_pkey on seat_location  (cost=0.15..0.20 rows=1 width=122) (actual time=0.001..0.001 rows=1 loops=24)"
"                                Index Cond: (id = seat_layout.location_id)"
"                    ->  Append  (cost=4.19..69.34 rows=110 width=15) (actual time=0.008..0.012 rows=20 loops=24)"
"                          ->  Bitmap Heap Scan on ticket_up_1980 ticket_1  (cost=4.19..12.66 rows=5 width=40) (actual time=0.001..0.001 rows=0 loops=24)"
"                                Recheck Cond: (schedule_id = 1)"
"                                ->  Bitmap Index Scan on ticket_up_1980_schedule_id_idx  (cost=0.00..4.19 rows=5 width=0) (actual time=0.000..0.000 rows=0 loops=24)"
"                                      Index Cond: (schedule_id = 1)"
"                          ->  Bitmap Heap Scan on ticket_up_1990 ticket_2  (cost=4.19..12.66 rows=5 width=40) (actual time=0.000..0.000 rows=0 loops=24)"
"                                Recheck Cond: (schedule_id = 1)"
"                                ->  Bitmap Index Scan on ticket_up_1990_schedule_id_idx  (cost=0.00..4.19 rows=5 width=0) (actual time=0.000..0.000 rows=0 loops=24)"
"                                      Index Cond: (schedule_id = 1)"
"                          ->  Index Scan using ticket_up_2000_schedule_id_idx on ticket_up_2000 ticket_3  (cost=0.29..8.64 rows=20 width=13) (actual time=0.001..0.001 rows=0 loops=24)"
"                                Index Cond: (schedule_id = 1)"
"                          ->  Index Scan using ticket_up_2010_schedule_id_idx on ticket_up_2010 ticket_4  (cost=0.42..8.77 rows=20 width=13) (actual time=0.002..0.002 rows=0 loops=24)"
"                                Index Cond: (schedule_id = 1)"
"                          ->  Index Scan using ticket_up_2020_schedule_id_idx on ticket_up_2020 ticket_5  (cost=0.42..8.77 rows=20 width=13) (actual time=0.001..0.001 rows=0 loops=24)"
"                                Index Cond: (schedule_id = 1)"
"                          ->  Index Scan using ticket_up_2030_schedule_id_idx on ticket_up_2030 ticket_6  (cost=0.29..8.64 rows=20 width=13) (actual time=0.001..0.001 rows=0 loops=24)"
"                                Index Cond: (schedule_id = 1)"
"                          ->  Index Scan using ticket_current_schedule_id_idx on ticket_current ticket_7  (cost=0.29..8.64 rows=20 width=13) (actual time=0.002..0.004 rows=20 loops=24)"
"                                Index Cond: (schedule_id = 1)"
"              ->  Seq Scan on tariff tariff_hall  (cost=0.00..24.12 rows=6 width=36) (actual time=0.000..0.001 rows=3 loops=24)"
"                    Filter: (price_key_id = 2)"
"                    Rows Removed by Filter: 9"
"        ->  Seq Scan on tariff tariff_seat  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.001 rows=3 loops=24)"
"              Filter: (price_key_id = 3)"
"              Rows Removed by Filter: 9"
"  ->  Seq Scan on tariff tariff_schedule  (cost=0.00..24.12 rows=6 width=36) (actual time=0.001..0.001 rows=3 loops=24)"
"        Filter: (price_key_id = 4)"
"        Rows Removed by Filter: 9"
"Planning Time: 6.561 ms"
"Execution Time: 0.951 ms"