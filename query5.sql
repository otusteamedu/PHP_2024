SELECT
	ch.name cinema_hall,
	s.row seat_row,
	s.number seat_number,
	t.is_sold is_sold
FROM
	cinema_halls ch
	JOIN seats s ON s.cinema_hall_id = ch.id
	JOIN tickets t ON t.seat_id = s.id
	AND t.show_id = 5
ORDER BY
	cinema_hall_id,
	seat_row,
	seat_number
;

-- 10_000 rows
-- Sort  (cost=186.03..186.06 rows=13 width=24) (actual time=0.650..0.652 rows=13 loops=1)
--    Sort Key: ch.name, s."row", s.number
--    Sort Method: quicksort  Memory: 25kB
--    ->  Nested Loop  (cost=0.43..185.79 rows=13 width=24) (actual time=0.113..0.532 rows=13 loops=1)
--          ->  Nested Loop  (cost=0.28..183.37 rows=13 width=13) (actual time=0.103..0.507 rows=13 loops=1)
--                ->  Seq Scan on tickets t  (cost=0.00..99.50 rows=13 width=9) (actual time=0.077..0.402 rows=13 loops=1)
--                      Filter: (show_id = 5)
--                      Rows Removed by Filter: 4987
--                ->  Index Scan using seats_pk on seats s  (cost=0.28..6.45 rows=1 width=20) (actual time=0.007..0.007 rows=1 loops=13)
--                      Index Cond: (id = t.seat_id)
--          ->  Index Scan using cinema_halls_pk on cinema_halls ch  (cost=0.15..0.19 rows=1 width=27) (actual time=0.001..0.001 rows=1 loops=13)
--                Index Cond: (id = s.cinema_hall_id)
--  Planning Time: 1.208 ms
--  Execution Time: 0.704 ms
-- 
-- 10_000_000 rows
-- Gather Merge  (cost=76404.21..76405.37 rows=10 width=19) (actual time=261.395..265.350 rows=11 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Sort  (cost=75404.18..75404.20 rows=5 width=19) (actual time=245.565..245.571 rows=4 loops=3)
--          Sort Key: ch.name, s."row", s.number
--          Sort Method: quicksort  Memory: 25kB
--          Worker 0:  Sort Method: quicksort  Memory: 25kB
--          Worker 1:  Sort Method: quicksort  Memory: 25kB
--          ->  Nested Loop  (cost=0.42..75404.12 rows=5 width=19) (actual time=32.539..245.495 rows=4 loops=3)
--                ->  Nested Loop  (cost=0.28..75403.35 rows=5 width=13) (actual time=32.491..245.422 rows=4 loops=3)
--                      ->  Parallel Seq Scan on tickets t  (cost=0.00..75368.00 rows=5 width=9) (actual time=32.275..244.946 rows=4 loops=3)
--                            Filter: (show_id = 5)
--                            Rows Removed by Filter: 1999996
--                      ->  Index Scan using seats_pk on seats s  (cost=0.28..7.07 rows=1 width=20) (actual time=0.114..0.114 rows=1 loops=11)
--                            Index Cond: (id = t.seat_id)
--                ->  Index Scan using cinema_halls_pk on cinema_halls ch  (cost=0.14..0.15 rows=1 width=22) (actual time=0.015..0.015 rows=1 loops=11)
--                      Index Cond: (id = s.cinema_hall_id)
--  Planning Time: 1.356 ms
--  Execution Time: 265.455 ms
-- 
-- Что удалось улучшить:
-- Уменьшен "cost" запроса.
-- Перечень оптимизаций:
-- Добавил индекс на поле "show_id". За счет этого произошла замена Seq Scan таблицы tickets на использование индекса - Bitmap Index Scan, и одного Nested Loop на более эффективный Hash Join.
-- 
-- Результат:
-- Sort  (cost=149.44..149.47 rows=13 width=19) (actual time=0.370..0.372 rows=11 loops=1)
--    Sort Key: ch.name, s."row", s.number
--    Sort Method: quicksort  Memory: 25kB
--    ->  Hash Join  (cost=6.04..149.20 rows=13 width=19) (actual time=0.113..0.316 rows=11 loops=1)
--          Hash Cond: (s.cinema_hall_id = ch.id)
--          ->  Nested Loop  (cost=4.82..147.93 rows=13 width=13) (actual time=0.081..0.280 rows=11 loops=1)
--                ->  Bitmap Heap Scan on tickets t  (cost=4.53..56.03 rows=13 width=9) (actual time=0.056..0.141 rows=11 loops=1)
--                      Recheck Cond: (show_id = 5)
--                      Heap Blocks: exact=11
--                      ->  Bitmap Index Scan on tickets_show_id_idx  (cost=0.00..4.53 rows=13 width=0) (actual time=0.044..0.044 rows=11 loops=1)
--                            Index Cond: (show_id = 5)
--                ->  Index Scan using seats_pk on seats s  (cost=0.28..7.07 rows=1 width=20) (actual time=0.012..0.012 rows=1 loops=11)
--                      Index Cond: (id = t.seat_id)
--          ->  Hash  (cost=1.10..1.10 rows=10 width=22) (actual time=0.018..0.018 rows=10 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on cinema_halls ch  (cost=0.00..1.10 rows=10 width=22) (actual time=0.012..0.013 rows=10 loops=1)
--  Planning Time: 1.472 ms
--  Execution Time: 0.446 ms