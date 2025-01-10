DROP VIEW IF EXISTS service_tasks, all_attributes;
DROP TABLE IF EXISTS attribute_values, movies, attributes, attribute_types;

CREATE TABLE IF NOT EXISTS movies
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS attribute_types
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS attributes
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS attribute_values
(
    id                SERIAL PRIMARY KEY,
    movie_id          INT NOT NULL REFERENCES movies (id),
    attribute_id      INT NOT NULL REFERENCES attributes (id),
    attribute_type_id INT NOT NULL REFERENCES attribute_types (id),
    text              TEXT    DEFAULT NULL,
    boolean           BOOLEAN DEFAULT NULL,
    int               INT     DEFAULT NULL,
    num               NUMERIC(4,2) DEFAULT NULL,
    date              DATE    DEFAULT NULL
);

create index if not exists attribute_values_text_idx ON attribute_values(text);
create index if not exists attribute_values_boolean_idx ON attribute_values(boolean);
create index if not exists attribute_values_int_idx ON attribute_values(int);
create index if not exists attribute_values_num_idx ON attribute_values(num);
create index if not exists attribute_values_date_idx ON attribute_values(date);