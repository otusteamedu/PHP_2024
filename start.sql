CREATE TABLE IF NOT EXISTS movie (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    duration INTERVAL NOT NULL,
    rating NUMERIC(2, 1) CHECK (rating >= 0 AND rating <= 10)
);

CREATE TABLE IF NOT EXISTS movie_attribute_type (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL
);

INSERT INTO movie_attribute_type(name) VALUES ('Рецензии'), ('Премия'), ('Важные даты'), ('Служебные даты');

CREATE TABLE IF NOT EXISTS movie_attribute (
    id SERIAL PRIMARY KEY,
    type_id INTEGER NOT NULL,
    name VARCHAR NOT NULL,
    CONSTRAINT fk_movie_attribute_type_id FOREIGN KEY (type_id) REFERENCES movie_attribute_type
);

INSERT INTO movie_attribute(type_id, name)
VALUES
   (1, 'Рецензии критиков'), (1, 'Отзыв неизвестной киноакадемии'),
   (2, 'Оскар'), (2, 'Ника'),
   (3, 'Мировая премьера'), (3, 'Премьера в РФ'),
   (4, 'Дата продажи билетов'), (4, 'Дата старта рекламы');

CREATE TABLE IF NOT EXISTS movie_attribute_value (
    id SERIAL PRIMARY KEY,
    movie_id INTEGER NOT NULL,
    attribute_id INTEGER NOT NULL,
    value JSONB NOT NULL,
    CONSTRAINT fk_movie_attribute_movie_id FOREIGN KEY (movie_id) REFERENCES movie,
    CONSTRAINT fk_attribute_id FOREIGN KEY (attribute_id) REFERENCES movie_attribute
);

INSERT INTO movie_attribute_value(movie_id, attribute_id, value)
VALUES (1, 7, '{"dateStart": 1714521599}'), (1, 8, '{"dateStart": 1711929600}');
INSERT INTO movie_attribute_value(movie_id, attribute_id, value)
VALUES (1, 5, '{"dateStart": 1714621599}'), (1, 6, '{"dateStart": 1714821599}');
INSERT INTO movie_attribute_value(movie_id, attribute_id, value)
VALUES (2, 5, '{"dateStart": 1713709168}'), (2, 6, '{"dateStart": 1713709168}');
INSERT INTO movie_attribute_value(movie_id, attribute_id, value)
VALUES (3, 5, '{"dateStart": 2713709168}'), (3, 6, '{"dateStart": 2713709168}');


CREATE VIEW important_events_20_days AS
SELECT m.title, ma.name, to_timestamp((value ->> 'dateStart')::BIGINT) as event_start FROM movie_attribute_value AS mav
INNER JOIN movie AS m
ON mav.movie_id = m.id
INNER JOIN movie_attribute AS ma
ON mav.attribute_id = ma.id
WHERE ma.type_id = 3 AND to_timestamp((value ->> 'dateStart')::BIGINT) > CURRENT_DATE + INTERVAL '20 day';

CREATE VIEW important_events_now AS
SELECT m.title, ma.name, to_timestamp((value ->> 'dateStart')::BIGINT) as event_start FROM movie_attribute_value AS mav
INNER JOIN movie AS m
ON mav.movie_id = m.id
INNER JOIN movie_attribute AS ma
ON mav.attribute_id = ma.id
WHERE ma.type_id = 3 AND (to_timestamp((value ->> 'dateStart')::BIGINT) >= CURRENT_DATE) AND (to_timestamp((value ->> 'dateStart')::BIGINT) < CURRENT_DATE + INTERVAL '1 day');


CREATE VIEW all_attributes AS
SELECT m.title, mat.name AS attribute_type_name, ma.name AS attribute_name, mav.value FROM movie_attribute_value AS mav
INNER JOIN movie AS m ON m.id = mav.movie_id
INNER JOIN movie_attribute AS ma ON mav.attribute_id = ma.id
INNER JOIN movie_attribute_type AS mat ON ma.type_id = mat.id;