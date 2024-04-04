
-- HashAggregate  (cost=13092.74..13102.74 rows=1000 width=14)
--                Group Key: f.film
--   ->  Gather  (cost=12877.74..13087.74 rows=2000 width=14)
--         Workers Planned: 2
--         ->  HashAggregate  (cost=11877.74..11887.74 rows=1000 width=14)
--               Group Key: f.film
--               ->  Hash Join  (cost=29.50..11870.32 rows=2968 width=14)
--                     Hash Cond: (s.film_id = f.id)
--                     ->  Parallel Seq Scan on sessions s  (cost=0.00..11833.00 rows=2968 width=8)
-- "                          Filter: ((session_at >= to_timestamp(to_char(now(), 'YYYY-MM-DD 00:00:00'::text), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at <= to_timestamp(to_char(now(), 'YYYY-MM-DD 23:59:59'::text), 'YYYY-MM-DD HH24:MI:SS'::text)))"
--                     ->  Hash  (cost=17.00..17.00 rows=1000 width=22)
--                           ->  Seq Scan on films f  (cost=0.00..17.00 rows=1000 width=22)


EXPLAIN SELECT
            DISTINCT f.film
        FROM
            films f,
            sessions s
        WHERE
            s.session_at BETWEEN TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
                AND TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
          AND s.film_id = f.id;

CREATE INDEX sess_at_key ON sessions(session_at);

-- HashAggregate  (cost=13092.74..13102.74 rows=1000 width=14)
--                Group Key: f.film
--   ->  Gather  (cost=12877.74..13087.74 rows=2000 width=14)
--         Workers Planned: 2
--         ->  HashAggregate  (cost=11877.74..11887.74 rows=1000 width=14)
--               Group Key: f.film
--               ->  Hash Join  (cost=29.50..11870.32 rows=2968 width=14)
--                     Hash Cond: (s.film_id = f.id)
--                     ->  Parallel Seq Scan on sessions s  (cost=0.00..11833.00 rows=2968 width=8)
-- "                          Filter: ((session_at >= to_timestamp(to_char(now(), 'YYYY-MM-DD 00:00:00'::text), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at <= to_timestamp(to_char(now(), 'YYYY-MM-DD 23:59:59'::text), 'YYYY-MM-DD HH24:MI:SS'::text)))"
--                     ->  Hash  (cost=17.00..17.00 rows=1000 width=22)
--                           ->  Seq Scan on films f  (cost=0.00..17.00 rows=1000 width=22)

-- добавлен индекс по времени сессии

-- Seq Scan on seats  (cost=0.00..1699.00 rows=2907 width=21)
--   Filter: ((number)::text = 'A10'::text)


EXPLAIN SELECT * FROM seats
        WHERE number = 'A10';

CREATE INDEX seat_num_idx ON seats(number);

-- Bitmap Heap Scan on seats  (cost=34.82..645.16 rows=2907 width=21)
--   Recheck Cond: ((number)::text = 'A10'::text)
--   ->  Bitmap Index Scan on seat_num_idx  (cost=0.00..34.09 rows=2907 width=0)
--         Index Cond: ((number)::text = 'A10'::text)


-- Добавлен индекс на поле number для быстрой выборки по индексу


-- Gather  (cost=1000.00..1122319.70 rows=6157 width=38)
--         Workers Planned: 2
--   ->  Parallel Seq Scan on booking_session_seats  (cost=0.00..1120704.00 rows=2565 width=38)
--         Filter: ((price > '500'::numeric) AND (price < '600'::numeric) AND (hall_id = 10))


EXPLAIN SELECT * FROM booking_session_seats where hall_id = 10 AND price > 500 AND price < 600;

CREATE INDEX hall_price_idx ON booking_session_seats(hall_id, price);

-- Bitmap Heap Scan on booking_session_seats  (cost=175.07..23124.31 rows=6157 width=38)
--   Recheck Cond: ((hall_id = 10) AND (price > '500'::numeric) AND (price < '600'::numeric))
--   ->  Bitmap Index Scan on hall_price_idx  (cost=0.00..173.53 rows=6157 width=0)
--         Index Cond: ((hall_id = 10) AND (price > '500'::numeric) AND (price < '600'::numeric))



EXPLAIN SELECT
    f.film Фильм,
    SUM(b.price) Выручка
FROM
    sessions s,
    booking_session_seats b,
    films f
WHERE
    s.session_at BETWEEN
        TO_TIMESTAMP(concat(current_date - interval '7 days', ' ', '00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
        AND TO_TIMESTAMP(concat(current_date, ' ', '23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
  AND b.session_id = s.id AND s.film_id = f.id AND b.is_reserved = true
GROUP BY
    f.id
ORDER BY
    Выручка DESC
LIMIT 3;

-- Limit  (cost=1015177.35..1015177.36 rows=3 width=54)
--        ->  Sort  (cost=1015177.35..1015179.85 rows=1000 width=54)
--         Sort Key: (sum(b.price)) DESC
--         ->  Finalize GroupAggregate  (cost=1014903.58..1015164.43 rows=1000 width=54)
--               Group Key: f.id
--               ->  Gather Merge  (cost=1014903.58..1015136.93 rows=2000 width=54)
--                     Workers Planned: 2
--                     ->  Sort  (cost=1013903.55..1013906.05 rows=1000 width=54)
--                           Sort Key: f.id
--                           ->  Partial HashAggregate  (cost=1013841.23..1013853.73 rows=1000 width=54)
--                                 Group Key: f.id
--                                 ->  Hash Join  (cost=12746.63..1007777.03 rows=1212839 width=27)
--                                       Hash Cond: (s.film_id = f.id)
--                                       ->  Parallel Hash Join  (cost=12717.13..1004550.33 rows=1212839 width=13)
--                                             Hash Cond: (b.session_id = s.id)
--                                             ->  Parallel Seq Scan on booking_session_seats b  (cost=0.00..954298.35 rows=14298893 width=13)
--                                                   Filter: is_reserved
--                                             ->  Parallel Hash  (cost=12453.83..12453.83 rows=21064 width=16)
--                                                   ->  Parallel Seq Scan on sessions s  (cost=0.00..12453.83 rows=21064 width=16)
-- "                                                        Filter: ((session_at <= to_timestamp(concat(CURRENT_DATE, ' ', '23:59:59'), 'YYYY-MM-DD HH24:MI:SS'::text)) AND (session_at >= to_timestamp(concat((CURRENT_DATE - '7 days'::interval), ' ', '00:00:00'), 'YYYY-MM-DD HH24:MI:SS'::text)))"
--                                       ->  Hash  (cost=17.00..17.00 rows=1000 width=22)
--                                             ->  Seq Scan on films f  (cost=0.00..17.00 rows=1000 width=22)

CREATE INDEX sessions_at_idx ON sessions(session_at);

CREATE MATERIALIZED VIEW high_grossing_films AS SELECT
    f.film Фильм,
    SUM(b.price) Выручка
    FROM
    sessions s,
    booking_session_seats b,
    films f
    WHERE
    s.session_at BETWEEN
    TO_TIMESTAMP(concat(current_date - interval '7 days', ' ', '00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
    AND TO_TIMESTAMP(concat(current_date, ' ', '23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
    AND b.session_id = s.id AND s.film_id = f.id AND b.is_reserved = true
    GROUP BY
    f.id
    ORDER BY
    Выручка DESC
    LIMIT 3;

EXPLAIN SELECT * FROM high_grossing_films;

-- Seq Scan on high_grossing_films  (cost=0.00..12.90 rows=290 width=250)



EXPLAIN SELECT
    min(b.price) Минимальная_цена,
    max(b.price) Максимальная_цена
FROM
    booking_session_seats b
WHERE
    b.session_id = 100 and b.is_reserved = false

--     Aggregate  (cost=354.24..354.25 rows=1 width=64)
--                ->  Index Scan using booking_session_seats_session_id_hall_id_seat_id_key on booking_session_seats b  (cost=0.56..354.08 rows=32 width=5)
--         Index Cond: (session_id = 100)
--         Filter: (NOT is_reserved)

-- Не нужна оптимизация так как используется индекс

CREATE EXTENSION IF NOT EXISTS tablefunc;
EXPLAIN SELECT
    *
FROM
    crosstab(
            'SELECT
    st.line,st.number, b.is_reserved
FROM
    sessions s,
    halls h,
    seats st,
    booking_session_seats b
WHERE
    s.id = 2 AND s.hall_id = h.id AND st.hall_id = h.id AND b.hall_id = h.id
    AND b.session_id = s.id AND b.seat_id = st.id'
    ) AS ct (line varchar(100), A1 bool ,A2 bool,A3 bool,A4 bool,A5 bool,A6 bool,A7 bool,A8 bool,A9 bool,A10 bool,
             B1 bool,B2 bool,B3 bool,B4 bool,B5 bool,B6 bool,B7 bool,B8 bool,B9 bool,B10 bool,C1 bool,C2 bool,C3 bool,
             C4 bool,C5 bool,C6 bool,C7 bool,C8 bool,C9 bool,C10 bool);

-- Не нужна оптимизация так как используется индекс