EXPLAIN(SELECT seats.id, seats.number, seats.row,
    CASE WHEN tickets.id IS NULL THEN 'free' ELSE 'occupied' END AS status
FROM seats
         LEFT JOIN tickets ON seats.id = tickets.seat_id AND tickets.timetable_id = 15
ORDER BY seats.row, seats.number);

--Sort  (cost=47.53..48.78 rows=500 width=44)
--      "  Sort Key: seats.""row"", seats.number"
--  ->  Hash Left Join  (cost=11.60..25.12 rows=500 width=44)
--        Hash Cond: (seats.id = tickets.seat_id)
--        ->  Seq Scan on seats  (cost=0.00..11.00 rows=500 width=12)
--        ->  Hash  (cost=11.58..11.58 rows=2 width=8)
--              ->  Bitmap Heap Scan on tickets  (cost=4.30..11.58 rows=2 width=8)
--                    Recheck Cond: (timetable_id = 15)
--                    ->  Bitmap Index Scan on idx_tickets_timetable_id  (cost=0.00..4.30 rows=2 width=0)
--                          Index Cond: (timetable_id = 15)