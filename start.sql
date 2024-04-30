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
    value_timestamp timestamp with time zone,
    value_int INTEGER,
    value_string VARCHAR,
    value_text TEXT,
    value_float FLOAT,
    CONSTRAINT fk_movie_attribute_movie_id FOREIGN KEY (movie_id) REFERENCES movie,
    CONSTRAINT fk_attribute_id FOREIGN KEY (attribute_id) REFERENCES movie_attribute
);

INSERT INTO movie_attribute_value(movie_id, attribute_id, value_timestamp)
VALUES (1, 7, '2024-05-15 12:00:00+03'), (1, 8, '2024-05-01 12:00:00+03');
INSERT INTO movie_attribute_value(movie_id, attribute_id, value_timestamp)
VALUES (1, 5, '2024-06-01 12:00:00+03'), (1, 6, '2024-06-10 12:00:00+03');
INSERT INTO movie_attribute_value(movie_id, attribute_id, value_timestamp)
VALUES (2, 5, '2024-06-02 12:00:00+03'), (2, 6, '2024-06-12 12:00:00+03');
INSERT INTO movie_attribute_value(movie_id, attribute_id, value_timestamp)
VALUES (3, 5, '2024-06-03 12:00:00+03'), (3, 6, '2024-06-13 12:00:00+03');
INSERT INTO movie_attribute_value(movie_id, attribute_id, value_timestamp)
VALUES (3, 5, '2024-04-30 12:40:00+03'), (3, 5, '2024-04-30 12:40:00+03');


CREATE VIEW important_events_20_days AS
SELECT m.title, ma.name, mav.value_timestamp FROM movie_attribute_value AS mav
INNER JOIN movie AS m
ON mav.movie_id = m.id
INNER JOIN movie_attribute AS ma
ON mav.attribute_id = ma.id
WHERE ma.type_id = 3 AND mav.value_timestamp > CURRENT_DATE + INTERVAL '20 day';

CREATE VIEW important_events_now AS
SELECT m.title, ma.name, mav.value_timestamp FROM movie_attribute_value AS mav
INNER JOIN movie AS m
ON mav.movie_id = m.id
INNER JOIN movie_attribute AS ma
ON mav.attribute_id = ma.id
WHERE ma.type_id = 3 AND (mav.value_timestamp >= CURRENT_DATE) AND (mav.value_timestamp < CURRENT_DATE + INTERVAL '1 day');


CREATE VIEW all_attributes AS
SELECT m.title, mat.name AS attribute_type_name, ma.name AS attribute_name, mav.* FROM movie_attribute_value AS mav
INNER JOIN movie AS m ON m.id = mav.movie_id
INNER JOIN movie_attribute AS ma ON mav.attribute_id = ma.id
INNER JOIN movie_attribute_type AS mat ON ma.type_id = mat.id;