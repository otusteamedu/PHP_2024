-- фильмы
CREATE TABLE IF NOT EXISTS movies (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name          varchar(255)
);

CREATE TYPE attrigutes_types AS ENUM ('boolean', 'text', 'date', 'float');

-- типы атрибутов
CREATE TABLE IF NOT EXISTS movies_attributes_types (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name          varchar(255) unique,
    type attrigutes_types
);

-- атрибуты
CREATE TABLE IF NOT EXISTS movies_attributes (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    type_id bigint REFERENCES movies_attributes_types (id),
    name          varchar(255) unique
);

-- значение атрибутов
CREATE TABLE IF NOT EXISTS movies_attributes_values (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    movie_id bigint REFERENCES movies (id),
    attribute_id bigint REFERENCES movies_attributes (id),
    boolean_value boolean DEFAULT false,
    text_value text DEFAULT NULL,
    date_value date DEFAULT NULL,
    float_value float DEFAULT NULL
);