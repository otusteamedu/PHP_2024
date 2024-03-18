create database db;

CREATE TABLE movies
(
    id    SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL
);

CREATE TABLE attribute_types
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE attributes
(
    id      SERIAL PRIMARY KEY,
    name    VARCHAR(100) NOT NULL,
    type_id INT          NOT NULL REFERENCES attribute_types (id)
);

CREATE TABLE attribute_values
(
    movie_id     INT NOT NULL REFERENCES movies (id),
    attribute_id INT NOT NULL REFERENCES attributes (id),
    value        TEXT,
    PRIMARY KEY (movie_id, attribute_id)
);

CREATE VIEW movies_tasks AS
SELECT m.title as movie_title, a.name as attribute_name, av.value
FROM movies m
         JOIN attribute_values av ON m.id = av.movie_id
         JOIN attributes a ON av.attribute_id = a.id
WHERE a.name = 'task_date'
  AND (av.value::date = CURRENT_DATE OR av.value::date = CURRENT_DATE + INTERVAL '20 day');

CREATE VIEW marketing_data AS
SELECT m.title as movie_title, at.name as attribute_type, a.name as attribute_name, av.value
FROM movies m
         JOIN attribute_values av ON m.id = av.movie_id
         JOIN attributes a ON av.attribute_id = a.id
         JOIN attribute_types at ON a.type_id = at.id;