EXPLAIN(SELECT movies.name, SUM(tickets.price) AS total_revenue
FROM tickets
         JOIN timetable ON tickets.timetable_id = timetable.id
         JOIN movies ON timetable.movie_id = movies.id
WHERE timetable.showtime BETWEEN '2024-07-27 00:00:00'  AND '2024-08-05 23:59:59'
GROUP BY movies.name
ORDER BY total_revenue DESC
LIMIT 3);

-- for 10000 rows
--Limit  (cost=503.19..503.20 rows=3 width=55)
--  ->  Sort  (cost=503.19..503.20 rows=4 width=55)
--        Sort Key: (sum(tickets.price)) DESC
--       ->  HashAggregate  (cost=503.10..503.15 rows=4 width=55)
--              Group Key: movies.name
--              ->  Hash Join  (cost=215.89..487.27 rows=3166 width=29)
--                    Hash Cond: (timetable.movie_id = movies.id)
--                    ->  Hash Join  (cost=214.80..469.06 rows=3166 width=10)
--                          Hash Cond: (tickets.timetable_id = timetable.id)
--                          ->  Seq Scan on tickets  (cost=0.00..228.00 rows=10000 width=10)
--                          ->  Hash  (cost=175.23..175.23 rows=3166 width=8)
--                                ->  Bitmap Heap Scan on timetable  (cost=72.74..175.23 rows=3166 width=8)
--                                     Recheck Cond: ((showtime >= '2024-07-27 00:00:00'::timestamp without time zone) AND (showtime <= '2024-08-05 23:59:59'::timestamp without time zone))
--                                      ->  Bitmap Index Scan on idx_timetable_showtime  (cost=0.00..71.94 rows=3166 width=0)
--                                            Index Cond: ((showtime >= '2024-07-27 00:00:00'::timestamp without time zone) AND (showtime <= '2024-08-05 23:59:59'::timestamp without time zone))
--                    ->  Hash  (cost=1.04..1.04 rows=4 width=27)
--                          ->  Seq Scan on movies  (cost=0.00..1.04 rows=4 width=27)


-- for 100000 rows

--Limit  (cost=3198.93..3198.94 rows=3 width=49)
--       ->  Sort  (cost=3198.93..3211.05 rows=4847 width=49)
--        Sort Key: (sum(tickets.price)) DESC
--        ->  HashAggregate  (cost=3075.70..3136.28 rows=4847 width=49)
--              Group Key: movies.name
--              ->  Nested Loop  (cost=834.69..3051.46 rows=4847 width=23)
--                    ->  Hash Join  (cost=834.39..2924.15 rows=4847 width=10)
--                          Hash Cond: (tickets.timetable_id = timetable.id)
--                          ->  Seq Scan on tickets  (cost=0.00..1801.00 rows=110000 width=10)
--                          ->  Hash  (cost=773.80..773.80 rows=4847 width=8)
--                                ->  Bitmap Heap Scan on timetable  (cost=106.10..773.80 rows=4847 width=8)
--                                      Recheck Cond: ((showtime >= '2024-07-27 00:00:00'::timestamp without time zone) AND (showtime <= '2024-08-05 23:59:59'::timestamp without time zone))
--                                      ->  Bitmap Index Scan on idx_timetable_showtime2  (cost=0.00..104.89 rows=4847 width=0)
--                                            Index Cond: ((showtime >= '2024-07-27 00:00:00'::timestamp without time zone) AND (showtime <= '2024-08-05 23:59:59'::timestamp without time zone))
--                    ->  Memoize  (cost=0.30..1.24 rows=1 width=21)
--                          Cache Key: timetable.movie_id
--                          Cache Mode: logical
--                          ->  Index Scan using movies_pkey on movies  (cost=0.29..1.23 rows=1 width=21)
--                                Index Cond: (id = timetable.movie_id)

-- Здесь уже используется индекс idx_timetable_showtime2 и movies_pkey
-- Если убрать индекс idx_timetable_showtime2, то запрос будет выполняться на 1500 единиц дольше
--Limit  (cost=4669.39..4669.40 rows=3 width=49)
--       ->  Sort  (cost=4669.39..4681.48 rows=4836 width=49)
--        Sort Key: (sum(tickets.price)) DESC
--        ->  HashAggregate  (cost=4546.43..4606.88 rows=4836 width=49)
--              Group Key: movies.name
--              ->  Nested Loop  (cost=2305.75..4522.25 rows=4836 width=23)
--                   ->  Hash Join  (cost=2305.45..4395.21 rows=4836 width=10)
--                          Hash Cond: (tickets.timetable_id = timetable.id)
--                          ->  Seq Scan on tickets  (cost=0.00..1801.00 rows=110000 width=10)
--                          ->  Hash  (cost=2245.00..2245.00 rows=4836 width=8)
--                                ->  Seq Scan on timetable  (cost=0.00..2245.00 rows=4836 width=8)
--                                      Filter: ((showtime >= '2024-07-27 00:00:00'::timestamp without time zone) AND (showtime <= '2024-08-05 23:59:59'::timestamp without time zone))
--                    ->  Memoize  (cost=0.30..1.24 rows=1 width=21)
--                          Cache Key: timetable.movie_id
--                          Cache Mode: logical
--                          ->  Index Scan using movies_pkey on movies  (cost=0.29..1.23 rows=1 width=21)
--                               Index Cond: (id = timetable.movie_id)
