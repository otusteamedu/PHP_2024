CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL
);

CREATE TABLE attribute_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    data_type VARCHAR(50) NOT NULL
);

CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,
    type_id INT REFERENCES attribute_types(id),
    name VARCHAR(100) NOT NULL
);

CREATE TABLE values (
    id SERIAL PRIMARY KEY,
    movie_id INT REFERENCES movies(id),
    attribute_id INT REFERENCES attributes(id),
    value_text TEXT NULL,
    value_boolean BOOLEAN NULL,
    value_date DATE NULL,
    created_at TIMESTAMP DEFAULT now()
);

CREATE INDEX idx_values_movie ON values(movie_id);
CREATE INDEX idx_values_attribute ON values(attribute_id);
CREATE INDEX idx_values_date ON values(value_date);