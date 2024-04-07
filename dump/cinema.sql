DROP DATABASE IF EXISTS cinema;
CREATE DATABASE cinema OWNER = postgres ENCODING = 'UTF8';
\c cinema;

CREATE TABLE cinema_hall
(
    id   BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE zones
(
    id              BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    hall_id         BIGINT REFERENCES cinema_hall (id) ON DELETE CASCADE,
    number_of_seats INT NOT NULL,
    number_of_rows  INT NOT NULL
);

CREATE TABLE prices
(
    id      BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    hall_id BIGINT REFERENCES cinema_hall (id) ON DELETE CASCADE,
    zone_id BIGINT REFERENCES zones (id) ON DELETE CASCADE,
    price   DECIMAL(8, 2) NOT NULL
);

CREATE TABLE countries
(
    id   BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE genres
(
    id   BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE movies
(
    id            BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    country_id    BIGINT REFERENCES countries (id) ON DELETE CASCADE,
    name          VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE movie_genre
(
    genre_id      BIGINT REFERENCES genres (id) ON DELETE CASCADE,
    movie_id      BIGINT REFERENCES movies (id) ON DELETE CASCADE
);

CREATE TABLE sessions
(
    id             BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    movie_id       BIGINT REFERENCES movies (id) ON DELETE CASCADE,
    hall_id        BIGINT REFERENCES cinema_hall (id) ON DELETE CASCADE,
    datetime_start TIMESTAMP NOT NULL,
    duration       TIME      NOT NULL
);

CREATE TABLE visitors
(
    id       BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name     VARCHAR(255) NOT NULL,
    phone    VARCHAR(255) NOT NULL
);

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

CREATE TABLE attribute_types
(
    id   BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE attributes
(
    id                BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name              VARCHAR(255) NOT NULL UNIQUE,
    attribute_type_id BIGINT       REFERENCES attribute_types (id) ON DELETE SET NULL
);

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

INSERT INTO cinema_hall (name)
VALUES ('relax'),
       ('kids');

INSERT INTO zones (hall_id, number_of_seats, number_of_rows)
VALUES (1, 40, 5),
       (1, 50, 6),
       (1, 35, 3),
       (2, 25, 5),
       (2, 35, 6),
       (2, 20, 3);


INSERT INTO prices (hall_id, zone_id, price)
VALUES (1, 1, 280.00),
       (1, 2, 300.00),
       (1, 3, 350.00),
       (2, 1, 400.00),
       (2, 2, 230.00),
       (2, 3, 240.00);

INSERT INTO countries (name)
VALUES ('USA'),
       ('France'),
       ('Russia');

INSERT INTO genres (name)
VALUES ('Horror'),
       ('Action'),
       ('Adventure');

INSERT INTO movies (name, country_id)
VALUES ('Prometeus', 1),
       ('Leon', 2),
       ('Брат 2', 3),
       ('Indiana Jones and the Dial of Destiny', 1);

INSERT INTO attribute_types (name)
VALUES ('bool'),
       ('date'),
       ('text'),
       ('int'),
       ('float'),
       ('json');

INSERT INTO attributes (name, attribute_type_id)
VALUES ('active', 1),
       ('premiere_date', 2),
       ('reviews', 3);

INSERT INTO values (movie_id, attribute_id, bool_val, date_val, text_val)
VALUES (1, 1, true, null, null),
       (1, 2, null, '2024-03-02', null),
       (1, 3, null, null, 'review 1'),
       (2, 1, true, null, null),
       (2, 2, null, '2024-03-05', null),
       (2, 3, null, null, 'review 2'),
       (3, 1, true, null, null),
       (3, 2, null, '2024-03-15', null),
       (3, 3, null, null, 'review 3');

INSERT INTO movie_genre (movie_id, genre_id)
VALUES (1, 2),
       (2, 1),
       (3, 1),
       (4, 3),
       (1, 1);

INSERT INTO sessions (movie_id, hall_id, datetime_start, duration)
VALUES (1, 1, '2024-04-03 10:00', '02:00:00'),
       (2, 1, '2024-04-03 13:00', '03:00:00'),
       (3, 1, '2024-04-03 16:00', '03:00:00'),
       (4, 1, '2024-04-03 19:00', '01:40:00'),
       (4, 2, '2024-04-03 10:00', '01:40:00'),
       (3, 2, '2024-04-03 13:00', '03:00:00'),
       (2, 2, '2024-04-03 16:00', '03:00:00'),
       (1, 2, '2024-04-03 19:00', '02:00:00');

INSERT INTO visitors (name, phone)
VALUES ('Иван Петрович', '+79205556677'),
       ('Сережа', '+79205556678'),
       ('Алексей', '+79205556679'),
       ('Андрей', '+79205556670');

INSERT INTO tickets (session_id, zone_id, visitor_id, row, place, selling_price, sale_at)
VALUES (1, 1, 1, 3, 6, 280.00, now()),
       (1, 2, 2, 1, 12, 300.00, now()),
       (2, 3, 4, 2, 15, 320.00, now()),
       (3, 1, 3, 4, 25, 340.00, now());

SELECT m.name, sum(p.price) as sum
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
GROUP BY m.id
ORDER BY sum DESC
LIMIT 1;