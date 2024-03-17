DROP DATABASE IF EXISTS cinema;
CREATE DATABASE cinema OWNER = matrix ENCODING = 'UTF8';

ALTER TABLE IF EXISTS attributes
DROP CONSTRAINT IF EXISTS attributes_attribute_type_id_fkey;

ALTER TABLE IF EXISTS values
DROP CONSTRAINT IF EXISTS values_movie_id_fkey;

ALTER TABLE IF EXISTS values
DROP CONSTRAINT IF EXISTS values_attribute_id_fkey;

DROP VIEW IF EXISTS actual_for_date;
DROP VIEW IF EXISTS movie_attr_values;

DROP TABLE IF EXISTS movies;
CREATE TABLE movies
(
    id   BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
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
    text_val     TEXT
);

INSERT INTO movies (name)
VALUES ('Фильм 1'),
       ('Фильм 2'),
       ('Фильм 3');

INSERT INTO attribute_types (name)
VALUES ('bool'),
       ('date'),
       ('text');

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


CREATE VIEW actual_for_date (movie, today, nearest_20_day) AS
SELECT m.name,
       CASE WHEN v.date_val = CURRENT_DATE THEN TRUE END as today,
       CASE
           WHEN v.date_val > CURRENT_DATE AND v.date_val <= (CURRENT_DATE + '20 days'::interval)::DATE
               THEN v.date_val END                       as nearest_20_day
FROM movies as m
         LEFT JOIN values as v ON v.movie_id = m.id
         LEFT JOIN attributes as a ON a.id = v.attribute_id
WHERE v.date_val IS NOT NULL;


CREATE VIEW movie_attr_values (movie, attribute_type, attribute, value) AS
SELECT m.name,
       at.name,
       a.name,
       CASE
           WHEN v.bool_val IS NOT NULL THEN v.bool_val::TEXT
           WHEN v.date_val IS NOT NULL THEN v.date_val::TEXT
           WHEN v.text_val IS NOT NULL THEN v.text_val::TEXT
           END as value
FROM movies as m
         LEFT JOIN values as v ON v.movie_id = m.id
         LEFT JOIN attributes as a ON a.id = v.attribute_id
         LEFT JOIN attribute_types as at ON at.id = a.attribute_type_id
;

SELECT *
FROM actual_for_date;
SELECT *
FROM movie_attr_values;
