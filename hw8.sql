DROP DATABASE IF EXISTS cinema;
CREATE DATABASE cinema OWNER = postgres ENCODING = 'UTF8';

ALTER TABLE IF EXISTS zones
DROP CONSTRAINT zones_hall_id_fkey;
ALTER TABLE IF EXISTS prices
DROP CONSTRAINT prices_hall_id_fkey;
ALTER TABLE IF EXISTS prices
DROP CONSTRAINT prices_zone_id_fkey;
ALTER TABLE IF EXISTS sessions
DROP CONSTRAINT sessions_movie_id_fkey;
ALTER TABLE IF EXISTS sessions
DROP CONSTRAINT sessions_hall_id_fkey;
ALTER TABLE IF EXISTS tickets
DROP CONSTRAINT tickets_session_id_fkey;
ALTER TABLE IF EXISTS tickets
DROP CONSTRAINT tickets_zone_id_fkey;
ALTER TABLE IF EXISTS tickets
DROP CONSTRAINT tickets_visitor_id_fkey;

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
    number_of_seats INT NOT NULL
);

DROP TABLE IF EXISTS prices;
CREATE TABLE prices
(
    id      BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    hall_id BIGINT REFERENCES halls (id) ON DELETE CASCADE,
    zone_id BIGINT REFERENCES zones (id) ON DELETE CASCADE,
    price   FLOAT NOT NULL
);

DROP TABLE IF EXISTS movies;
CREATE TABLE movies
(
    id       BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name     VARCHAR(255) NOT NULL UNIQUE,
    duration TIME         NOT NULL
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
    selling_price FLOAT,
    sale_at       TIMESTAMP
);

INSERT INTO halls (name)
VALUES ('Зал 1'),
       ('Зал 2');

INSERT INTO zones (hall_id, number_of_seats)
VALUES (1, 43),
       (1, 12),
       (1, 44),
       (2, 23),
       (2, 65),
       (2, 16);


INSERT INTO prices (hall_id, zone_id, price)
VALUES (1, 1, 250),
       (1, 2, 300),
       (1, 3, 350),
       (2, 1, 200),
       (2, 2, 220),
       (2, 3, 260);

INSERT INTO movies (name, duration)
VALUES ('Хищник', '02:30'),
       ('Робин Гуд', '01:30'),
       ('Операция Ы', '02:10'),
       ('Чужой', '02:00');

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

INSERT INTO tickets (session_id, zone_id, visitor_id)
VALUES (1, 1, 1),
       (1, 2, 2),
       (2, 3, 4),
       (3, 1, 3);

SELECT m.name, sum(p.price) as sum
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
GROUP BY m.id ORDER BY sum DESC LIMIT 1;