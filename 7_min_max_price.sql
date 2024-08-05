EXPLAIN(SELECT MIN(price) AS min_price, MAX(price) AS max_price
FROM tickets
WHERE timetable_id = 15);

-- for 10000 rows
--Aggregate  (cost=11.59..11.60 rows=1 width=64)
--  ->  Bitmap Heap Scan on tickets  (cost=4.30..11.58 rows=2 width=6)
--        Recheck Cond: (timetable_id = 15)
--        ->  Bitmap Index Scan on idx_tickets_timetable_id  (cost=0.00..4.30 rows=2 width=0)
--              Index Cond: (timetable_id = 15)

-- for 100000 rows
--Aggregate  (cost=2076.05..2076.07 rows=1 width=64)
--           ->  Seq Scan on tickets  (cost=0.00..2076.00 rows=11 width=6)
--        Filter: (timetable_id = 15)

CREATE INDEX idx_tickets_timetable_id ON tickets(timetable_id);

-- тут помог простой индекс
--Aggregate  (cost=44.44..44.45 rows=1 width=64)
--           ->  Bitmap Heap Scan on tickets  (cost=4.38..44.38 rows=11 width=6)
--        Recheck Cond: (timetable_id = 15)
--        ->  Bitmap Index Scan on idx_tickets_timetable_id  (cost=0.00..4.38 rows=11 width=0)
--              Index Cond: (timetable_id = 15)

