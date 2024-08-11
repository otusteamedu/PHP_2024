-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

EXPLAIN ANALYSE
SELECT halls.name                                                                            AS "Зал",
       movies.title                                                                          AS "Фильм",
       seats.row_number                                                                             AS "Ряд",
       seats.seat_number                                                                           AS "Место",
       CASE WHEN tickets.id IS NOT NULL THEN 'Занято' ELSE CAST(tickets.price AS VARCHAR) END AS "Цена"
FROM sessions
         JOIN movies ON sessions.movie_id = movies.id
         JOIN halls ON sessions.hall_id = halls.id
         JOIN seats ON halls.id = seats.hall_id
         LEFT JOIN tickets ON seats.id = tickets.seat_id
WHERE sessions.id = 1
ORDER BY seats.row_number, seats.seat_number;

-- Sort  (cost=418.14..418.15 rows=1 width=66) (actual time=9.813..9.870 rows=334 loops=1)
-- "  Sort Key: seats.row_number, seats.seat_number"
--   Sort Method: quicksort  Memory: 51kB
--   ->  Nested Loop  (cost=184.36..418.13 rows=1 width=66) (actual time=4.701..9.642 rows=334 loops=1)
--         Join Filter: (sessions.hall_id = halls.id)
--         ->  Nested Loop  (cost=184.07..417.80 rows=1 width=40) (actual time=4.688..9.004 rows=334 loops=1)
--               ->  Hash Right Join  (cost=183.79..415.30 rows=1 width=29) (actual time=4.660..8.421 rows=334 loops=1)
--                     Hash Cond: (tickets.seat_id = seats.id)
--                     ->  Seq Scan on tickets  (cost=0.00..194.00 rows=10000 width=13) (actual time=0.048..1.758 rows=10000 loops=1)
--                     ->  Hash  (cost=183.78..183.78 rows=1 width=24) (actual time=4.586..4.589 rows=334 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 27kB
--                           ->  Hash Join  (cost=2.52..183.78 rows=1 width=24) (actual time=0.035..4.432 rows=334 loops=1)
--                                 Hash Cond: (seats.hall_id = sessions.hall_id)
--                                 ->  Seq Scan on seats  (cost=0.00..155.00 rows=10000 width=16) (actual time=0.008..2.002 rows=10000 loops=1)
--                                 ->  Hash  (cost=2.50..2.50 rows=1 width=8) (actual time=0.017..0.018 rows=1 loops=1)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                       ->  Index Scan using sessions_pkey on sessions  (cost=0.29..2.50 rows=1 width=8) (actual time=0.011..0.012 rows=1 loops=1)
--                                             Index Cond: (id = 1)
--               ->  Index Scan using movies_pkey on movies  (cost=0.29..2.50 rows=1 width=19) (actual time=0.001..0.001 rows=1 loops=334)
--                     Index Cond: (id = sessions.movie_id)
--         ->  Index Scan using halls_pkey on halls  (cost=0.29..0.31 rows=1 width=15) (actual time=0.001..0.001 rows=1 loops=334)
--               Index Cond: (id = seats.hall_id)
-- Planning Time: 1.225 ms
-- Execution Time: 10.049 ms
CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);
CREATE INDEX ON seats (hall_id);
CREATE INDEX ON tickets (seat_id);
CREATE INDEX ON tickets (date);

-- Sort  (cost=18.13..18.14 rows=1 width=66) (actual time=1.403..1.461 rows=334 loops=1)
-- "  Sort Key: seats.row_number, seats.seat_number"
--   Sort Method: quicksort  Memory: 51kB
--   ->  Nested Loop Left Join  (cost=1.43..18.12 rows=1 width=66) (actual time=0.058..1.239 rows=334 loops=1)
--         ->  Nested Loop  (cost=1.14..17.79 rows=1 width=38) (actual time=0.049..0.337 rows=334 loops=1)
--               Join Filter: (sessions.hall_id = seats.hall_id)
--               ->  Nested Loop  (cost=0.86..7.51 rows=1 width=34) (actual time=0.028..0.032 rows=1 loops=1)
--                     ->  Nested Loop  (cost=0.57..5.01 rows=1 width=19) (actual time=0.021..0.023 rows=1 loops=1)
--                           ->  Index Scan using sessions_pkey on sessions  (cost=0.29..2.50 rows=1 width=8) (actual time=0.010..0.011 rows=1 loops=1)
--                                 Index Cond: (id = 1)
--                           ->  Index Scan using movies_pkey on movies  (cost=0.29..2.50 rows=1 width=19) (actual time=0.007..0.008 rows=1 loops=1)
--                                 Index Cond: (id = sessions.movie_id)
--                     ->  Index Scan using halls_pkey on halls  (cost=0.29..2.50 rows=1 width=15) (actual time=0.006..0.006 rows=1 loops=1)
--                           Index Cond: (id = sessions.hall_id)
--               ->  Index Scan using seats_hall_id_idx on seats  (cost=0.29..6.12 rows=333 width=16) (actual time=0.019..0.172 rows=334 loops=1)
--                     Index Cond: (hall_id = halls.id)
--         ->  Index Scan using tickets_seat_id_idx on tickets  (cost=0.29..0.32 rows=1 width=13) (actual time=0.002..0.002 rows=1 loops=334)
--               Index Cond: (seat_id = seats.id)
-- Planning Time: 1.790 ms
-- Execution Time: 1.612 ms
