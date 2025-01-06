-- Таблица "Фильмы"
CREATE TABLE films
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Таблица "Типы атрибутов"
CREATE TABLE attribute_types
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Таблица "Атрибуты"
CREATE TABLE attributes
(
    id                SERIAL PRIMARY KEY,
    attribute_type_id INT          NOT NULL REFERENCES attribute_types (id),
    name              VARCHAR(255) NOT NULL
);

-- Таблица "Значения"
CREATE TABLE attribute_values
(
    id            SERIAL PRIMARY KEY,
    film_id       INT NOT NULL REFERENCES films (id),
    attribute_id  INT NOT NULL REFERENCES attributes (id),
    value_text    TEXT,
    value_date    DATE,
    value_boolean BOOLEAN,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Таблица "Фильмы"
CREATE TABLE films
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Таблица "Типы атрибутов"
CREATE TABLE attribute_types
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Таблица "Атрибуты"
CREATE TABLE attributes
(
    id                SERIAL PRIMARY KEY,
    attribute_type_id INT          NOT NULL REFERENCES attribute_types (id),
    name              VARCHAR(255) NOT NULL
);

-- Таблица "Значения"
CREATE TABLE attribute_values
(
    id            SERIAL PRIMARY KEY,
    film_id       INT NOT NULL REFERENCES films (id),
    attribute_id  INT NOT NULL REFERENCES attributes (id),
    value_text    TEXT,
    value_date    DATE,
    value_boolean BOOLEAN,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
