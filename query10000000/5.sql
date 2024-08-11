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

-- Sort  (cost=10008.88..10008.88 rows=1 width=72) (actual time=1778.821..1874.493 rows=333334 loops=1)
-- "  Sort Key: seats.row_number, seats.seat_number"
--   Sort Method: external merge  Disk: 17952kB
--   ->  Nested Loop Left Join  (cost=2.17..10008.87 rows=1 width=72) (actual time=0.704..1594.107 rows=333334 loops=1)
--         ->  Nested Loop  (cost=1.74..10008.39 rows=1 width=44) (actual time=0.693..330.325 rows=333334 loops=1)
--               Join Filter: (sessions.hall_id = seats.hall_id)
--               ->  Nested Loop  (cost=1.30..7.96 rows=1 width=40) (actual time=0.213..0.219 rows=1 loops=1)
--                     ->  Nested Loop  (cost=0.87..5.31 rows=1 width=22) (actual time=0.035..0.038 rows=1 loops=1)
--                           ->  Index Scan using sessions_pk on sessions  (cost=0.43..2.65 rows=1 width=8) (actual time=0.019..0.020 rows=1 loops=1)
--                                 Index Cond: (id = 1)
--                           ->  Index Scan using movies_pkey on movies  (cost=0.43..2.65 rows=1 width=22) (actual time=0.013..0.013 rows=1 loops=1)
--                                 Index Cond: (id = sessions.movie_id)
--                     ->  Index Scan using halls_pkey on halls  (cost=0.43..2.65 rows=1 width=18) (actual time=0.177..0.177 rows=1 loops=1)
--                           Index Cond: (id = sessions.hall_id)
--               ->  Index Scan using seats_hall_id_idx on seats  (cost=0.43..5833.77 rows=333333 width=16) (actual time=0.477..207.964 rows=333334 loops=1)
--                     Index Cond: (hall_id = halls.id)
--         ->  Index Scan using tickets_seat_id_idx on tickets  (cost=0.43..0.46 rows=1 width=13) (actual time=0.003..0.003 rows=1 loops=333334)
--               Index Cond: (seat_id = seats.id)
-- Planning Time: 7.378 ms
-- Execution Time: 1921.122 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);
CREATE INDEX ON seats (hall_id);
CREATE INDEX ON tickets (seat_id);
CREATE INDEX ON tickets (date);

-- Sort  (cost=10008.88..10008.88 rows=1 width=72) (actual time=1738.648..1859.879 rows=333334 loops=1)
-- "  Sort Key: seats.row_number, seats.seat_number"
--   Sort Method: external merge  Disk: 17952kB
--   ->  Nested Loop Left Join  (cost=2.17..10008.87 rows=1 width=72) (actual time=1.435..1545.933 rows=333334 loops=1)
--         ->  Nested Loop  (cost=1.74..10008.39 rows=1 width=44) (actual time=1.419..514.098 rows=333334 loops=1)
--               Join Filter: (sessions.hall_id = seats.hall_id)
--               ->  Nested Loop  (cost=1.30..7.96 rows=1 width=40) (actual time=0.555..0.561 rows=1 loops=1)
--                     ->  Nested Loop  (cost=0.87..5.31 rows=1 width=22) (actual time=0.548..0.552 rows=1 loops=1)
--                           ->  Index Scan using sessions_pk on sessions  (cost=0.43..2.65 rows=1 width=8) (actual time=0.530..0.532 rows=1 loops=1)
--                                 Index Cond: (id = 1)
--                           ->  Index Scan using movies_pkey on movies  (cost=0.43..2.65 rows=1 width=22) (actual time=0.014..0.014 rows=1 loops=1)
--                                 Index Cond: (id = sessions.movie_id)
--                     ->  Index Scan using halls_pkey on halls  (cost=0.43..2.65 rows=1 width=18) (actual time=0.006..0.006 rows=1 loops=1)
--                           Index Cond: (id = sessions.hall_id)
--               ->  Index Scan using seats_hall_id_idx1 on seats  (cost=0.43..5833.77 rows=333333 width=16) (actual time=0.861..380.954 rows=333334 loops=1)
--                     Index Cond: (hall_id = halls.id)
--         ->  Index Scan using tickets_seat_id_idx on tickets  (cost=0.43..0.46 rows=1 width=13) (actual time=0.002..0.002 rows=1 loops=333334)
--               Index Cond: (seat_id = seats.id)
-- Planning Time: 31.021 ms
-- Execution Time: 1920.939 ms


