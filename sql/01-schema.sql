-- Таблица: фильмы
CREATE TABLE movies
(
    id           SERIAL PRIMARY KEY,
    title        VARCHAR(255) NOT NULL,
    description  TEXT,
    release_year INT
);

-- Таблица: типы атрибутов
CREATE TABLE attribute_types
(
    id        SERIAL PRIMARY KEY,
    name      VARCHAR(100) NOT NULL UNIQUE,
    data_type VARCHAR(50)  NOT NULL
);

-- Таблица: атрибуты
CREATE TABLE attributes
(
    id                SERIAL PRIMARY KEY,
    movie_id          INT          NOT NULL REFERENCES movies (id) ON DELETE CASCADE,
    attribute_type_id INT          NOT NULL REFERENCES attribute_types (id) ON DELETE CASCADE,
    name              VARCHAR(255) NOT NULL,
    UNIQUE (movie_id, attribute_type_id, name)
);

-- Таблица: значения атрибутов
CREATE TABLE values
(
    id            SERIAL PRIMARY KEY,
    attribute_id  INT NOT NULL REFERENCES attributes (id) ON DELETE CASCADE,
    value_text    TEXT,
    value_boolean BOOLEAN,
    value_date    DATE,
    CONSTRAINT check_one_value CHECK (
        (value_text IS NOT NULL):: int +
        (value_boolean IS NOT NULL):: int +
        (value_date IS NOT NULL):: int = 1
)
    );

-- Индексы
CREATE INDEX idx_attribute_type_movie ON attributes (movie_id, attribute_type_id);
CREATE INDEX idx_value_by_date ON values (value_date);
