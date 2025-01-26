-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT h.name,
       s.row_number,
       s.col_number,
       CASE WHEN t.sold_at IS NULL THEN false ELSE true END is_sold
FROM hall h
         JOIN seat s ON s.hall_id = h.id
         LEFT JOIN ticket t ON t.seat_id = s.id AND t.session_id = 1
ORDER BY h.hall_id,
         s.row_number,
         s.col_number;

-- 10_000 rows
-- Sort  (cost=639.91..652.41 rows=5000 width=529) (actual time=3.598..3.734 rows=5000 loops=1)
--   Sort Key: h.id, s.row_number, s.col_number
--   Sort Method: quicksort  Memory: 485kB
--   ->  Hash Left Join  (cost=212.18..332.72 rows=5000 width=529) (actual time=0.679..2.499 rows=5000 loops=1)
--         Hash Cond: (s.id = t.seat_id)
--         ->  Hash Join  (cost=13.15..108.68 rows=5000 width=532) (actual time=0.034..1.266 rows=5000 loops=1)
--               Hash Cond: (s.hall_id = h.id)
--               ->  Seq Scan on seat s  (cost=0.00..82.00 rows=5000 width=16) (actual time=0.008..0.243 rows=5000 loops=1)
--               ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.019..0.019 rows=50 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 11kB
--                     ->  Seq Scan on hall h  (cost=0.00..11.40 rows=140 width=520) (actual time=0.006..0.010 rows=50 loops=1)
--         ->  Hash  (cost=199.00..199.00 rows=2 width=12) (actual time=0.640..0.640 rows=1 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on ticket t  (cost=0.00..199.00 rows=2 width=12) (actual time=0.336..0.638 rows=1 loops=1)
--                     Filter: (session_id = 1)
--                     Rows Removed by Filter: 9999
-- Planning Time: 0.200 ms
-- Execution Time: 4.089 ms

-- 10_000_000 rows
-- Incremental Sort  (cost=3912.21..127460.91 rows=5000 width=29) (actual time=368.999..372.739 rows=5000 loops=1)
--   Sort Key: h.id, s.row_number, s.col_number
--   Presorted Key: h.id
--   Full-sort Groups: 50  Sort Method: quicksort  Average Memory: 29kB  Peak Memory: 29kB
--   Pre-sorted Groups: 50  Sort Method: quicksort  Average Memory: 32kB  Peak Memory: 32kB
--   ->  Nested Loop Left Join  (cost=1392.10..127231.31 rows=5000 width=29) (actual time=368.902..371.057 rows=5000 loops=1)
--         Join Filter: (t.seat_id = s.id)
--         Rows Removed by Join Filter: 4999
--         ->  Merge Join  (cost=392.10..467.35 rows=5000 width=32) (actual time=1.251..2.095 rows=5000 loops=1)
--               Merge Cond: (h.id = s.hall_id)
--               ->  Sort  (cost=2.91..3.04 rows=50 width=20) (actual time=0.038..0.041 rows=50 loops=1)
--                     Sort Key: h.id
--                     Sort Method: quicksort  Memory: 27kB
--                     ->  Seq Scan on hall h  (cost=0.00..1.50 rows=50 width=20) (actual time=0.025..0.029 rows=50 loops=1)
--               ->  Sort  (cost=389.19..401.69 rows=5000 width=16) (actual time=1.210..1.374 rows=5000 loops=1)
--                     Sort Key: s.hall_id
--                     Sort Method: quicksort  Memory: 388kB
--                     ->  Seq Scan on seat s  (cost=0.00..82.00 rows=5000 width=16) (actual time=0.013..0.676 rows=5000 loops=1)
--         ->  Materialize  (cost=1000.00..126613.96 rows=2 width=12) (actual time=0.074..0.074 rows=1 loops=5000)
--               ->  Gather  (cost=1000.00..126613.95 rows=2 width=12) (actual time=367.566..367.669 rows=1 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Parallel Seq Scan on ticket t  (cost=0.00..125613.75 rows=1 width=12) (actual time=306.191..349.198 rows=0 loops=3)
--                           Filter: (session_id = 1)
--                           Rows Removed by Filter: 3333333
-- Planning Time: 0.941 ms
-- Execution Time: 373.216 ms

-- Что тут можно сделать, добавить индекс на колонку session_id в таблице ticket.
-- После добавления индекса cost джойна значительно уменьшился, чем значительно сократило время запроса.

-- Sort  (cost=443.07..455.57 rows=5000 width=29) (actual time=3.032..3.181 rows=5000 loops=1)
--   Sort Key: h.id, s.row_number, s.col_number
--   Sort Method: quicksort  Memory: 486kB
--   ->  Hash Left Join  (cost=14.62..135.88 rows=5000 width=29) (actual time=0.044..1.904 rows=5000 loops=1)
--         Hash Cond: (s.id = t.seat_id)
--         ->  Hash Join  (cost=2.12..98.36 rows=5000 width=32) (actual time=0.028..1.290 rows=5000 loops=1)
--               Hash Cond: (s.hall_id = h.id)
--               ->  Seq Scan on seat s  (cost=0.00..82.00 rows=5000 width=16) (actual time=0.008..0.253 rows=5000 loops=1)
--               ->  Hash  (cost=1.50..1.50 rows=50 width=20) (actual time=0.015..0.016 rows=50 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 11kB
--                     ->  Seq Scan on hall h  (cost=0.00..1.50 rows=50 width=20) (actual time=0.004..0.008 rows=50 loops=1)
--         ->  Hash  (cost=12.47..12.47 rows=2 width=12) (actual time=0.012..0.013 rows=1 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Index Scan using idx_ticket_session_id on ticket t  (cost=0.43..12.47 rows=2 width=12) (actual time=0.007..0.007 rows=1 loops=1)
--                     Index Cond: (session_id = 1)
-- Planning Time: 0.220 ms
-- Execution Time: 3.532 ms
