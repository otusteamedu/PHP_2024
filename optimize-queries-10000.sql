DROP table public.booking_session_seats;

DROP table public.sessions;

DROP table public.seats;

DROP table public.halls;

DROP table public.films;



EXPLAIN SELECT
            DISTINCT f.film
        FROM
            films f,
            sessions s
        WHERE
            s.session_at BETWEEN TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
                AND TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
          AND s.film_id = f.id;


-- Unique  (cost=371.64..371.65 rows=1 width=14)
--         ->  Sort  (cost=371.64..371.65 rows=1 width=14)
--         Sort Key: f.film
--         ->  Nested Loop  (cost=0.57..371.63 rows=1 width=14)
--               ->  Index Scan using sessions_hall_id_session_at_key on sessions s  (cost=0.30..363.31 rows=1 width=8)
-- "                    Index Cond: ((session_at >= to_timestamp(to_char(now(), 'YYYY-MM-DD 00:00:00'::text), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at <= to_timestamp(to_char(now(), 'YYYY-MM-DD 23:59:59'::text), 'YYYY-MM-DD HH24:MI:SS'::text)))"
--               ->  Index Scan using films_pkey on films f  (cost=0.27..8.29 rows=1 width=22)
--                     Index Cond: (id = s.film_id)


CREATE INDEX sess_at_key ON sessions(session_at);

-- Unique  (cost=16.65..16.66 rows=1 width=14)
--         ->  Sort  (cost=16.65..16.66 rows=1 width=14)
--         Sort Key: f.film
--         ->  Nested Loop  (cost=0.57..16.64 rows=1 width=14)
--               ->  Index Scan using sess_at_key on sessions s  (cost=0.30..8.32 rows=1 width=8)
-- "                    Index Cond: ((session_at >= to_timestamp(to_char(now(), 'YYYY-MM-DD 00:00:00'::text), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at <= to_timestamp(to_char(now(), 'YYYY-MM-DD 23:59:59'::text), 'YYYY-MM-DD HH24:MI:SS'::text)))"
--               ->  Index Scan using films_pkey on films f  (cost=0.27..8.29 rows=1 width=22)
--                     Index Cond: (id = s.film_id)


EXPLAIN SELECT * FROM seats
        WHERE number = 'A10';

-- Seq Scan on seats  (cost=0.00..204.00 rows=360 width=21)
--   Filter: ((number)::text = 'A10'::text)

CREATE INDEX seat_num_idx ON seats(number);

-- Bitmap Heap Scan on seats  (cost=7.07..80.58 rows=360 width=21)
--   Recheck Cond: ((number)::text = 'A10'::text)
--   ->  Bitmap Index Scan on seat_num_idx  (cost=0.00..6.98 rows=360 width=0)
--         Index Cond: ((number)::text = 'A10'::text)


EXPLAIN SELECT * FROM booking_session_seats where hall_id = 10 AND price > 500 AND price < 600;

-- Gather  (cost=13577.87..105962.67 rows=4958 width=38)
--         Workers Planned: 2
--   ->  Parallel Bitmap Heap Scan on booking_session_seats  (cost=12577.87..104466.87 rows=2066 width=38)
--         Recheck Cond: ((price > '500'::numeric) AND (price < '600'::numeric))
--         Filter: (hall_id = 10)
--         ->  Bitmap Index Scan on price_idx  (cost=0.00..12576.63 rows=599220 width=0)
--               Index Cond: ((price > '500'::numeric) AND (price < '600'::numeric))




CREATE INDEX hall_price_idx ON booking_session_seats(hall_id, price);

-- Bitmap Heap Scan on booking_session_seats  (cost=143.65..15626.49 rows=4958 width=38)
--   Recheck Cond: ((hall_id = 10) AND (price > '500'::numeric) AND (price < '600'::numeric))
--   ->  Bitmap Index Scan on hall_price_idx  (cost=0.00..142.41 rows=4958 width=0)
--         Index Cond: ((hall_id = 10) AND (price > '500'::numeric) AND (price < '600'::numeric))





