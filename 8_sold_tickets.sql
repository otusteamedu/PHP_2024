EXPLAIN(SELECT COUNT(*) AS sold_tickets
    FROM tickets
    JOIN timetable ON tickets.timetable_id = timetable.id
    WHERE timetable.showtime BETWEEN '2024-07-27 00:00:00' AND '2024-08-05 23:59:59');

--for 10000 rows
--Aggregate  (cost=476.98..476.99 rows=1 width=8)
--  ->  Hash Join  (cost=214.80..469.06 rows=3166 width=0)
--        Hash Cond: (tickets.timetable_id = timetable.id)
--        ->  Seq Scan on tickets  (cost=0.00..228.00 rows=10000 width=4)
--        ->  Hash  (cost=175.23..175.23 rows=3166 width=4)
--              ->  Bitmap Heap Scan on timetable  (cost=72.74..175.23 rows=3166 width=4)
--                    Recheck Cond: ((showtime >= '2024-07-27 00:00:00'::timestamp without time zone) AND (showtime <= '2024-08-05 23:59:59'::timestamp without time zone))
--                    ->  Bitmap Index Scan on idx_timetable_showtime  (cost=0.00..71.94 rows=3166 width=0)
--                          Index Cond: ((showtime >= '2024-07-27 00:00:00'::timestamp without time zone) AND (showtime <= '2024-08-05 23:59:59'::timestamp without time zone))

--for 100000 rows
--Aggregate  (cost=2848.12..2848.13 rows=1 width=8)
--           ->  Merge Join  (cost=0.81..2836.00 rows=4847 width=0)
--        Merge Cond: (tickets.timetable_id = timetable.id)
--        ->  Index Only Scan using idx_tickets_timetable_id on tickets  (cost=0.29..2146.29 rows=110000 width=4)
--        ->  Index Scan using timetable_pkey on timetable  (cost=0.29..4010.29 rows=4847 width=4)
--              Filter: ((showtime >= '2024-07-27 00:00:00'::timestamp without time zone) AND (showtime <= '2024-08-05 23:59:59'::timestamp without time zone))

-- тут уже используется индекс в том числе и покрывающий Index Only Scan using idx_tickets_timetable_id
-- ничего больше придумать не получилось