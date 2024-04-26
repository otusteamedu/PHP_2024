DROP VIEW IF EXISTS eav.marketing;
DROP VIEW IF EXISTS eav.tasks;
DROP TABLE IF EXISTS eav.values;
DROP TABLE IF EXISTS eav.attributes;
DROP TABLE IF EXISTS eav.attribute_types;
DROP TABLE IF EXISTS eav.movies;
DROP TYPE IF EXISTS  eav.value_type;
DROP SCHEMA IF EXISTS eav;

CREATE SCHEMA eav;

CREATE TYPE eav.value_type AS ENUM
(
    'integer',
    'float',
    'boolean',
    'text',
    'date'
);

CREATE TABLE IF NOT EXISTS eav.movies
(
    id serial PRIMARY KEY,
    title varchar(255) NOT NULL,
    CONSTRAINT movies__title__uniqie UNIQUE(title)
);

CREATE TABLE IF NOT EXISTS eav.attribute_types
(
    id serial PRIMARY KEY,
    name varchar(255) NOT NULL,
    value_type eav.value_type NOT NULL,
    CONSTRAINT attribute_types__name__unique UNIQUE(name)
);

CREATE TABLE IF NOT EXISTS eav.attributes
(
    id serial PRIMARY KEY,
    name varchar(255) NOT NULL,
    attribute_type_id integer NOT NULL,
    FOREIGN KEY (attribute_type_id) REFERENCES eav.attribute_types(id),
    CONSTRAINT attributes__name__unique UNIQUE(name)
);

CREATE INDEX index__attributes__attribute_type_id ON eav.attributes(attribute_type_id);

CREATE TABLE IF NOT EXISTS eav.values
(
    movie_id integer NOT NULL,
    attribute_id integer NOT NULL,
    integer_value integer DEFAULT NULL,
    float_value double precision DEFAULT NULL,
    boolean_value boolean DEFAULT NULL,
    text_value text DEFAULT NULL,
    date_value timestamptz DEFAULT NULL,
    PRIMARY KEY (movie_id, attribute_id),
    FOREIGN KEY (movie_id) REFERENCES eav.movies(id),
    FOREIGN KEY (attribute_id) REFERENCES eav.attributes(id)
);

CREATE INDEX index__values__movie_id ON eav.values(movie_id);
CREATE INDEX index__values__attribute_id ON eav.values(attribute_id);