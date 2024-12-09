--movies: Таблица для хранения информации о фильмах.

CREATE TABLE movies (
     movie_id SERIAL PRIMARY KEY,
     title VARCHAR(255) NOT NULL
);

--attribute_types: Таблица для хранения типов атрибутов.

CREATE TABLE attribute_types (
     type_id SERIAL PRIMARY KEY,
     type_name VARCHAR(255) NOT NULL
);

--attributes: Таблица для хранения атрибутов, связанных с типами.

CREATE TABLE attributes (
     attribute_id SERIAL PRIMARY KEY,
     attribute_name VARCHAR(255) NOT NULL,
     type_id INT REFERENCES attribute_types(type_id)
);

--attribute_values: Таблица для хранения значений атрибутов.

CREATE TABLE attribute_values (
     value_id SERIAL PRIMARY KEY,
     movie_id INT REFERENCES movies(movie_id),
     attribute_id INT REFERENCES attributes(attribute_id),
     value_text TEXT,
     value_boolean BOOLEAN,
     value_date DATE
);

CREATE INDEX idx_movie_id ON attribute_values(movie_id);
CREATE INDEX idx_attribute_id ON attribute_values(attribute_id);
CREATE INDEX idx_value_date ON attribute_values(value_date);

--View для сборки служебных данных:

CREATE VIEW service_tasks AS
SELECT m.title AS movie,
         a.attribute_name AS task,
         av.value_date AS date
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
JOIN attributes a ON av.attribute_id = a.attribute_id
WHERE a.type_id = 4 AND av.value_date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL '20 days';


--View для сборки данных для маркетинга:

CREATE VIEW marketing_data AS
SELECT m.title AS movie,
         at.type_name AS attribute_type,
         a.attribute_name AS attribute,
         COALESCE(av.value_text::TEXT, av.value_boolean::TEXT, av.value_date::TEXT) AS value
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
JOIN attributes a ON av.attribute_id = a.attribute_id
JOIN attribute_types at ON a.type_id = at.type_id;
