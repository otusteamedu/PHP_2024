DROP DATABASE IF EXISTS cinema;
CREATE DATABASE cinema OWNER = matrix ENCODING = 'UTF8';

ALTER TABLE IF EXISTS zones
DROP CONSTRAINT IF EXISTS zones_hall_id_fkey;

ALTER TABLE IF EXISTS prices
DROP CONSTRAINT IF EXISTS prices_hall_id_fkey;

ALTER TABLE IF EXISTS prices
DROP CONSTRAINT IF EXISTS prices_zone_id_fkey;

ALTER TABLE IF EXISTS movie_genre
DROP CONSTRAINT IF EXISTS movie_genre_movie_id_fkey;

ALTER TABLE IF EXISTS movie_genre
DROP CONSTRAINT IF EXISTS movie_genre_genre_id_fkey;

DROP INDEX IF EXISTS movie_genre_gm_idx;

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

ALTER TABLE IF EXISTS attributes
DROP CONSTRAINT IF EXISTS attributes_attribute_type_id_fkey;

ALTER TABLE IF EXISTS values
DROP CONSTRAINT IF EXISTS values_movie_id_fkey;

ALTER TABLE IF EXISTS values
DROP CONSTRAINT IF EXISTS values_attribute_id_fkey;

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
    name          VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS movie_genre;
CREATE TABLE movie_genre
(
    genre_id      BIGINT REFERENCES genres (id) ON DELETE CASCADE,
    movie_id      BIGINT REFERENCES movies (id) ON DELETE CASCADE
);

CREATE UNIQUE INDEX movie_genre_gm_idx ON movie_genre (genre_id, movie_id);

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

DROP TABLE IF EXISTS attribute_types;
CREATE TABLE attribute_types
(
    id   BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS attributes;
CREATE TABLE attributes
(
    id                BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name              VARCHAR(255) NOT NULL UNIQUE,
    attribute_type_id BIGINT       REFERENCES attribute_types (id) ON DELETE SET NULL
);

DROP TABLE IF EXISTS values;
CREATE TABLE values
(
    id           BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    movie_id     BIGINT REFERENCES movies (id) ON DELETE CASCADE,
    attribute_id BIGINT REFERENCES attributes (id) ON DELETE CASCADE,
    bool_val     BOOL,
    date_val     DATE,
    text_val     TEXT,
    int_val      INT,
    float_val    FLOAT,
    json_val     JSONB
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

INSERT INTO movies (name, country_id)
VALUES ('Хищник', 1),
       ('Робин Гуд', 2),
       ('Операция Ы', 3),
       ('Чужой', 3);

INSERT INTO attribute_types (name)
VALUES ('bool'),
       ('date'),
       ('text'),
       ('int'),
       ('float'),
       ('json');

INSERT INTO attributes (name, attribute_type_id)
VALUES ('is_active', 1),
       ('sale_start_date', 2),
       ('reviews', 3);

INSERT INTO values (movie_id, attribute_id, bool_val, date_val, text_val)
VALUES (1, 1, true, null, null),
       (1, 2, null, '2024-03-17', null),
       (1, 3, null, null, 'Отзыв к фильму 1'),
       (2, 1, true, null, null),
       (2, 2, null, '2024-03-20', null),
       (2, 3, null, null, 'Отзыв к фильму 2'),
       (3, 1, true, null, null),
       (3, 2, null, '2024-03-22', null),
       (3, 3, null, null, 'Отзыв к фильму 3');

INSERT INTO movie_genre (movie_id, genre_id)
VALUES (1, 2),
       (2, 1),
       (3, 1),
       (4, 3),
       (1, 1);

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