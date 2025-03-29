CREATE TABLE IF NOT EXISTS MOVIES
(
    id   SERIAL PRIMARY KEY,   -- Уникальный идентификатор фильма
    name VARCHAR(255) NOT NULL -- Название фильма
);

CREATE TABLE IF NOT EXISTS ATTRIBUTE_TYPES
(
    id         SERIAL PRIMARY KEY, -- Уникальный идентификатор типа атрибута
    value_type varchar(64)         -- Название типа атрибута
);

CREATE TABLE IF NOT EXISTS ATTRIBUTE
(
    id                SERIAL PRIMARY KEY, -- Уникальный идентификатор атрибута
    name              VARCHAR(255),       -- Название атрибута
    attribute_type_id INT,                -- Привязка к типу атрибута
    CONSTRAINT fk_attribute_attribute_types FOREIGN KEY (attribute_type_id) REFERENCES ATTRIBUTE_TYPES (id)
);

CREATE TABLE IF NOT EXISTS ATTRIBUTE_VALUES
(
    id            SERIAL PRIMARY KEY, -- Уникальный идентификатор значения атрибута
    movie_id      INT,                -- Привязка к фильму
    attribute_id  INT,                -- Привязка к атрибуту
    value_text    TEXT    NULL,
    value_boolean BOOLEAN NULL,
    value_date    DATE    NULL,
    value_int     INTEGER NULL,
    value_float   REAL    NULL,
    created_at    TIMESTAMP DEFAULT now(),
    CONSTRAINT fk_attribute_values_movies FOREIGN KEY (movie_id) REFERENCES MOVIES (id),
    CONSTRAINT fk_attribute_values_attribute FOREIGN KEY (attribute_id) REFERENCES ATTRIBUTE (id)
);

CREATE INDEX idx_attribute_values_movie ON ATTRIBUTE_VALUES (movie_id);
CREATE INDEX idx_attribute_values_attribute ON ATTRIBUTE_VALUES (attribute_id);
CREATE INDEX idx_attribute_values_date ON ATTRIBUTE_VALUES (value_date);
