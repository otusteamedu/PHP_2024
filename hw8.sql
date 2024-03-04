DROP DATABASE IF EXISTS cinema;
CREATE DATABASE cinema OWNER = postgres ENCODING = 'UTF8';

ALTER TABLE IF EXISTS zones
DROP CONSTRAINT IF EXISTS zones_hall_id_fkey;
ALTER TABLE IF EXISTS prices
DROP CONSTRAINT IF EXISTS prices_hall_id_fkey;
ALTER TABLE IF EXISTS prices
DROP CONSTRAINT IF EXISTS prices_zone_id_fkey;
ALTER TABLE IF EXISTS movies
DROP CONSTRAINT IF EXISTS movies_country_id_fkey;
ALTER TABLE IF EXISTS movies
DROP CONSTRAINT IF EXISTS movies_genre_id_fkey;
ALTER TABLE IF EXISTS sessions
DROP CONSTRAINT IF EXISTS sessions_movie_id_fkey;
ALTER TABLE IF EXISTS sessions
DROP CONSTRAINT IF EXISTS sessions_hall_id_fkey;
ALTER TABLE IF EXISTS tickets
DROP CONSTRAINT IF EXISTS tickets_session_id_fkey;
ALTER TABLE IF EXISTS tickets
DROP CONSTRAINT IF EXISTS tickets_zone_id_fkey;
ALTER TABLE IF EXISTS tickets
DROP CONSTRAINT IF EXISTS tickets_visitor_id_fkey;

DROP TABLE IF EXISTS halls;
CREATE TABLE halls
(
    id   BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS zones;
CREATE TABLE zones
(
    id              BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    hall_id         BIGINT REFERENCES halls (id) ON DELETE CASCADE,
    number_of_seats INT NOT NULL,
    number_of_rows  INT NOT NULL
);

DROP TABLE IF EXISTS prices;
CREATE TABLE prices
(
    id      BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    hall_id BIGINT REFERENCES halls (id) ON DELETE CASCADE,
    zone_id BIGINT REFERENCES zones (id) ON DELETE CASCADE,
    price   DECIMAL(8, 2) NOT NULL
);

DROP TABLE IF EXISTS countries;
CREATE TABLE countries
(
    id   BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS genres;
CREATE TABLE genres
(
    id   BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);


DROP TABLE IF EXISTS movies;
CREATE TABLE movies
(
    id            BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    country_id    BIGINT REFERENCES countries (id) ON DELETE CASCADE,
    genre_id      BIGINT REFERENCES genres (id) ON DELETE CASCADE,
    name          VARCHAR(255) NOT NULL UNIQUE,
    duration      TIME         NOT NULL,
    year_of_issue SMALLINT     NOT NULL
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions
(
    id             BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    movie_id       BIGINT REFERENCES movies (id) ON DELETE CASCADE,
    hall_id        BIGINT REFERENCES halls (id) ON DELETE CASCADE,
    datetime_start TIMESTAMP NOT NULL,
    duration       TIME      NOT NULL
);

DROP TABLE IF EXISTS visitors;
CREATE TABLE visitors
(
    id       BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name     VARCHAR(255) NOT NULL,
    contacts VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS tickets;
CREATE TABLE tickets
(
    id            BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    session_id    BIGINT REFERENCES sessions (id) ON DELETE SET NULL,
    zone_id       BIGINT REFERENCES zones (id) ON DELETE SET NULL,
    visitor_id    BIGINT REFERENCES visitors (id) ON DELETE SET NULL,
    row           INT    NOT NULL,
    place         INT    NOT NULL,
    selling_price DECIMAL(8, 2),
    sale_at       TIMESTAMP
);

INSERT INTO halls (name)
VALUES ('Зал 1'),
       ('Зал 2');

INSERT INTO zones (hall_id, number_of_seats, number_of_rows)
VALUES (1, 43, 5),
       (1, 12, 6),
       (1, 44, 3),
       (2, 23, 5),
       (2, 65, 6),
       (2, 16, 3);


INSERT INTO prices (hall_id, zone_id, price)
VALUES (1, 1, 250.50),
       (1, 2, 300.50),
       (1, 3, 350.00),
       (2, 1, 200.50),
       (2, 2, 221.50),
       (2, 3, 260);

INSERT INTO countries (name)
VALUES ('Россия'),
       ('Канада'),
       ('Корея');

INSERT INTO genres (name)
VALUES ('Триллер'),
       ('Фонтастика'),
       ('Ужасы');

INSERT INTO movies (name, duration, year_of_issue, country_id, genre_id)
VALUES ('Хищник', '02:30', 1992, 2, 2),
       ('Робин Гуд', '01:30', 2019, 1, 1),
       ('Операция Ы', '02:10', 2015, 1, 1),
       ('Чужой', '02:00', 1992, 2, 3);

INSERT INTO sessions (movie_id, hall_id, datetime_start, duration)
VALUES (1, 1, '2024-01-05 10:00', '03:00'),
       (2, 1, '2024-01-05 13:00', '03:00'),
       (3, 1, '2024-01-05 16:00', '03:00'),
       (4, 1, '2024-01-05 19:00', '03:00'),
       (4, 2, '2024-01-05 10:00', '03:00'),
       (3, 2, '2024-01-05 13:00', '03:00'),
       (2, 2, '2024-01-05 16:00', '03:00'),
       (1, 2, '2024-01-05 19:00', '03:00');

INSERT INTO visitors (name, contacts)
VALUES ('Василий', '+7999555542'),
       ('Георгий', '+79995348844'),
       ('Евгений', '+79995538849'),
       ('Игорь', '+79995558811');

INSERT INTO tickets (session_id, zone_id, visitor_id, row, place)
VALUES (1, 1, 1, 1, 2),
       (1, 2, 2, 2, 12),
       (2, 3, 4, 1, 5),
       (3, 1, 3, 2, 15);

SELECT m.name, sum(p.price) as sum
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
GROUP BY m.id
ORDER BY sum DESC
LIMIT 1;