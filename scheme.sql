-- Таблица для фильмов
CREATE TABLE films (
    film_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    release_year INT NOT NULL
);

-- Таблица для типов атрибутов
CREATE TABLE attribute_types (
    type_id SERIAL PRIMARY KEY,
    type_name VARCHAR(100) NOT NULL
);

-- Таблица для атрибутов фильмов
CREATE TABLE attributes (
    attribute_id SERIAL PRIMARY KEY,
    attribute_name VARCHAR(255) NOT NULL,
    type_id INT NOT NULL REFERENCES attribute_types(type_id)
);

-- Таблица для хранения значений атрибутов
CREATE TABLE attribute_values (
    value_id SERIAL PRIMARY KEY,
    film_id INT NOT NULL REFERENCES films(film_id),
    attribute_id INT NOT NULL REFERENCES attributes(attribute_id),
    value_text TEXT,
    value_date DATE,
    value_boolean BOOLEAN,
    value_float FLOAT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
