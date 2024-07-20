DROP VIEW IF EXISTS movies_today;
DROP VIEW IF EXISTS tickets_sold_last_week;
DROP VIEW IF EXISTS movie_flyers_today;
DROP VIEW IF EXISTS most_profitable_movies_last_week;
DROP VIEW IF EXISTS hall_seating_schema;

DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS seats;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS cinemas;

CREATE TABLE cinemas
(
    id      SERIAL PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL
);

CREATE TABLE halls
(
    id        SERIAL PRIMARY KEY,
    cinema_id INT REFERENCES cinemas (id) NOT NULL,
    name      VARCHAR(255)                NOT NULL
);

CREATE TABLE seats
(
    id      SERIAL PRIMARY KEY,
    hall_id INT REFERENCES halls (id) NOT NULL,
    row     INT                       NOT NULL,
    number  INT                       NOT NULL,
    UNIQUE (hall_id, row, number)
);

CREATE TABLE customers
(
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE genres
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE movies
(
    id           SERIAL PRIMARY KEY,
    title        VARCHAR(255)               NOT NULL,
    duration     INT                        NOT NULL,
    rating       VARCHAR(10)                NOT NULL,
    genre_id     INT REFERENCES genres (id) NOT NULL,
    release_date DATE                       NOT NULL,
    description  TEXT
);

CREATE TABLE sessions
(
    id         SERIAL PRIMARY KEY,
    hall_id    INT REFERENCES halls (id)  NOT NULL,
    movie_id   INT REFERENCES movies (id) NOT NULL,
    start_time TIMESTAMP                  NOT NULL,
    price      DECIMAL(10, 2)             NOT NULL
);

CREATE TABLE tickets
(
    id           SERIAL PRIMARY KEY,
    session_id   INT REFERENCES sessions (id)  NOT NULL,
    seat_id      INT REFERENCES seats (id)     NOT NULL,
    customer_id  INT REFERENCES customers (id) NOT NULL,
    purchased_at TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (session_id, seat_id)
);


/* 1. Выбор всех фильмов на сегодня */
CREATE OR REPLACE VIEW movies_today AS
SELECT m.id    AS movie_id,
       m.title AS movie_title
FROM movies m
         JOIN sessions s ON m.id = s.movie_id
WHERE DATE(s.start_time) = CURRENT_DATE;


/* 2. Подсчёт проданных билетов за неделю */
CREATE OR REPLACE VIEW tickets_sold_last_week AS
SELECT count(*) AS tickets_sold
FROM tickets t
WHERE t.purchased_at >= CURRENT_DATE - INTERVAL '1 week';

/* 3. Формирование афиши (фильмы, которые показывают сегодня) */
CREATE OR REPLACE VIEW movie_flyers_today AS
SELECT m.id         AS movie_id,
       m.title      AS movie_title,
       g.name       AS genre_name,
       s.start_time AS session_start_time,
       c.name       AS cinema_name,
       s.price      AS session_price
FROM movies m
         JOIN sessions s ON m.id = s.movie_id
         JOIN halls h ON s.hall_id = h.id
         JOIN cinemas c ON h.cinema_id = c.id
         JOIN genres g ON m.genre_id = g.id
WHERE DATE(s.start_time) = CURRENT_DATE;

/* 4. Поиск 3 самых прибыльных фильмов за неделю */
CREATE OR REPLACE VIEW most_profitable_movies_last_week AS
WITH weekly_revenue AS (SELECT m.id,
                               m.title AS movie_title,
                               SUM(s.price) AS session_revenue
                        FROM tickets t
                                 JOIN sessions s ON t.session_id = s.id
                                 JOIN movies m ON s.movie_id = m.id
                        WHERE t.purchased_at >= CURRENT_DATE - INTERVAL '1 week'
                        GROUP BY m.id)
SELECT wr.id,
       wr.movie_title,
       wr.session_revenue
FROM weekly_revenue wr
ORDER BY wr.session_revenue DESC
LIMIT 3;

/* 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс */
CREATE OR REPLACE VIEW hall_seating_schema AS
SELECT
    h.name AS hall_name,
    s.id AS session_id,
    st.row as seat_row,
    st.number as seat_number,
    CASE
        WHEN t.id IS NULL THEN true
        ELSE false
        END AS is_available
FROM
    halls h
        JOIN sessions s ON h.id = s.hall_id
        JOIN seats st ON h.id = st.hall_id
        LEFT JOIN tickets t ON t.session_id = s.id AND t.seat_id = st.id;

/* Функция добавления записей */
CREATE OR REPLACE FUNCTION populate_data(num_records INT) RETURNS INT AS
$$
DECLARE
    i          INT;
    hall_id    INT;
    row_num    INT;
    seat_num   INT;
    session_id INT;
    seat_id    INT;
    email      TEXT;
BEGIN
    FOR i IN 1..num_records / 10
        LOOP
            INSERT INTO cinemas (name, address)
            VALUES ('Cinema ' || i, 'Address ' || i);
        END LOOP;

    FOR i IN 1..num_records / 5
        LOOP
            INSERT INTO halls (cinema_id, name)
            VALUES ((SELECT id FROM cinemas ORDER BY random() LIMIT 1), 'Hall ' || i);
        END LOOP;

    FOR i IN 1..num_records
        LOOP
            hall_id := (SELECT id FROM halls ORDER BY random() LIMIT 1);
            row_num := floor(random() * 10 + 1)::int;
            seat_num := floor(random() * 20 + 1)::int;

            LOOP
                BEGIN
                    INSERT INTO seats (hall_id, row, number)
                    VALUES (hall_id, row_num, seat_num);
                    EXIT;
                EXCEPTION
                    WHEN unique_violation THEN
                        row_num := floor(random() * 10 + 1)::int;
                        seat_num := floor(random() * 20 + 1)::int;
                END;
            END LOOP;
        END LOOP;

    FOR i IN 1..num_records
        LOOP
            email := 'customer' || i || '@example.com';

            LOOP
                BEGIN
                    INSERT INTO customers (name, email)
                    VALUES ('Customer ' || i, email);
                    EXIT;
                EXCEPTION
                    WHEN unique_violation THEN
                        email := 'customer' || i || '_' || floor(random() * 1000) || '@example.com';
                END;
            END LOOP;
        END LOOP;

    INSERT INTO genres (name)
    VALUES ('Action'),
           ('Comedy'),
           ('Drama'),
           ('Horror'),
           ('Sci-Fi')
    ON CONFLICT DO NOTHING;

    FOR i IN 1..num_records / 10
        LOOP
            INSERT INTO movies (title, duration, rating, genre_id, release_date, description)
            VALUES ('Movie ' || i,
                    floor(random() * 120 + 60)::int,
                    'Rating ' || floor(random() * 10 + 1),
                    (SELECT id FROM genres ORDER BY random() LIMIT 1),
                    CURRENT_DATE - (floor(random() * 1000) * INTERVAL '1 day'),
                    'Description of movie ' || i);
        END LOOP;

    FOR i IN 1..num_records
        LOOP
            INSERT INTO sessions (hall_id, movie_id, start_time, price)
            VALUES ((SELECT id FROM halls ORDER BY random() LIMIT 1),
                    (SELECT id FROM movies ORDER BY random() LIMIT 1),
                    CURRENT_DATE + (floor(random() * 1000) * INTERVAL '1 hour'),
                    round((random() * 20 + 5)::numeric, 2));
        END LOOP;

    FOR i IN 1..num_records
        LOOP
            session_id := (SELECT id FROM sessions ORDER BY random() LIMIT 1);
            seat_id := (SELECT id FROM seats ORDER BY random() LIMIT 1);

            LOOP
                BEGIN
                    INSERT INTO tickets (session_id, seat_id, customer_id, purchased_at)
                    VALUES (session_id,
                            seat_id,
                            (SELECT id FROM customers ORDER BY random() LIMIT 1),
                            CURRENT_DATE - (floor(random() * 30) * INTERVAL '1 day'));
                    EXIT;
                EXCEPTION
                    WHEN unique_violation THEN
                        session_id := (SELECT id FROM sessions ORDER BY random() LIMIT 1);
                        seat_id := (SELECT id FROM seats ORDER BY random() LIMIT 1);
                END;
            END LOOP;
        END LOOP;

    RETURN num_records;
END
$$ LANGUAGE plpgsql;

SELECT populate_data(1000);

