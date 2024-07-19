CREATE TABLE movies
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR UNIQUE NOT NULL
);

CREATE TABLE movie_attribute_types
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR UNIQUE NOT NULL
);

CREATE TABLE movie_attributes
(
    id                      SERIAL PRIMARY KEY,
    name                    VARCHAR UNIQUE                            NOT NULL,
    movie_attribute_type_id INT REFERENCES movie_attribute_types (id) NOT NULL
);

CREATE TABLE movie_attribute_value
(
    id                 SERIAL PRIMARY KEY,
    movie_id           INT REFERENCES movies (id)           NOT NULL,
    movie_attribute_id INT REFERENCES movie_attributes (id) NOT NULL,
    value_text         TEXT NULL,
    value_boolean      BOOLEAN NULL,
    value_date         DATE NULL,
    value_timestamp    TIMESTAMP NULL,
    value_float        FLOAT NULL
);

CREATE UNIQUE INDEX unique_movie_attribute ON movie_attribute_value (movie_id, movie_attribute_id);

CREATE INDEX idx_movie_id ON movie_attribute_value (movie_id);
CREATE INDEX idx_movie_attribute_id ON movie_attribute_value (movie_attribute_id);
CREATE INDEX idx_movie_attribute_type_id ON movie_attributes (movie_attribute_type_id);
