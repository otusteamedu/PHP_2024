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
     value_date DATE,
     value_integer INT,
     value_float DOUBLE PRECISION
);

CREATE INDEX idx_movie_id ON attribute_values(movie_id);
CREATE INDEX idx_attribute_id ON attribute_values(attribute_id);
CREATE INDEX idx_value_date ON attribute_values(value_date);
