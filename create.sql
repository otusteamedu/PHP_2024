CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
CREATE INDEX idx_movies_name ON movies (name);

CREATE TABLE attribute_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
CREATE INDEX idx_attribute_types_name ON attribute_types (name);

CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    attribute_type_id INT REFERENCES attribute_types(id)
);
CREATE INDEX idx_attributes_attribute_type_id ON attributes (attribute_type_id);
CREATE INDEX idx_attributes_name ON attributes (name);

CREATE TABLE values (
    id SERIAL PRIMARY KEY,
    movie_id INT REFERENCES movies(id),
    attribute_id INT REFERENCES attributes(id),
    value_text TEXT NULL,
    value_boolean BOOLEAN NULL,
    value_date DATE NULL,
    value_int INTEGER NULL,
    value_numeric NUMERIC NULL,
    value_float REAL NULL,
);
CREATE INDEX idx_values_movies_id ON values (movie_id);
CREATE INDEX idx_values_attributes_id ON values (attribute_id);
CREATE INDEX idx_values_value_date ON values (value_date);