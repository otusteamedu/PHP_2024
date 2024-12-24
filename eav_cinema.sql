DROP VIEW IF EXISTS tasks, all_attributes;
DROP TABLE IF EXISTS values, films, attributes, types;

-- DDL
CREATE TABLE films
(
    id        SERIAL PRIMARY KEY,
    film_name CHARACTER VARYING(50)
);
CREATE INDEX film_name_idx ON films (film_name);

CREATE TABLE attributes
(
    id             SERIAL PRIMARY KEY,
    attribute_name CHARACTER VARYING(50)
);
CREATE INDEX attribute_name_idx ON attributes (attribute_name);

CREATE TABLE types
(
    id        SERIAL PRIMARY KEY,
    type_name CHARACTER VARYING(50)
);
CREATE INDEX type_name_idx ON types (type_name);

CREATE TABLE values
(
    id           SERIAL PRIMARY KEY,
    film_id      INT REFERENCES films,
    attribute_id INT REFERENCES attributes,
    type         INT REFERENCES types,
    value        TEXT
);
CREATE INDEX film_id_attribute_id_type_idx ON values (film_id, attribute_id, type);

-- Dates view
CREATE VIEW tasks AS
SELECT f.film_name AS Фильм,
       STRING_AGG(CASE WHEN (DATE(v.value) >= CURRENT_DATE) THEN a.attribute_name || ' ' || v.value END, ' ,') AS "Актуально сегодня",
       STRING_AGG(CASE WHEN (DATE(v.value) >= (CURRENT_DATE + INTERVAL '20 DAYS')) THEN  a.attribute_name || ' ' || v.value  END, ' ,') AS "Актуально через 20 дней"
FROM values v
         JOIN films f ON v.film_id = f.id
         JOIN attributes a ON v.attribute_id = a.id
         JOIN types t ON v.type = t.id
WHERE t.type_name = 'DATE'
GROUP BY f.id;

-- Marketing view
CREATE VIEW all_attributes AS
SELECT
    f.film_name AS фильм,
    t.type_name AS "тип атрибута",
    a.attribute_name AS атрибут,
    v.value AS значение
FROM values v
         JOIN films f ON v.film_id = f.id
         JOIN attributes a ON v.attribute_id = a.id
         JOIN types t ON v.type = t.id;

-- Test DATASET
INSERT INTO films (film_name)
VALUES ('Film 1'),
       ('Film 2');

INSERT INTO attributes (attribute_name)
VALUES ('critic_review'),
       ('film_academy_review'),
       ('nika'),
       ('oscar'),
       ('world_premiere_date'),
       ('russia_premiere_date'),
       ('sales_start_date'),
       ('advertising_start_date');

INSERT INTO types (type_name)
VALUES ('TEXT'),
       ('BOOL'),
       ('DATE');

INSERT INTO values (film_id, attribute_id, type, value)
VALUES (1, 1, 1, 'Film 1 critic review '),
       (1, 2, 1, 'Film 1 academy review'),
       (1, 4, 2, 1),
       (1, 5, 3, '2025-01-01'),
       (1, 6, 3, '2025-01-30'),
       (1, 8, 3, '2025-01-03'),
       (1, 7, 3, '2025-01-23'),
       (2, 1, 1, 'Film 2 critic review '),
       (2, 2, 1, 'Film 2 academy review'),
       (2, 3, 2, 1),
       (2, 4, 2, 1),
       (2, 5, 3, '2025-01-05'),
       (2, 6, 3, '2025-01-25'),
       (2, 8, 3, '2025-01-05'),
       (2, 7, 3, '2025-01-07');

