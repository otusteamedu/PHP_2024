-- Фильмы
CREATE TABLE IF NOT EXISTS movie
(
    id   SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL
);
COMMENT ON TABLE movie IS 'Фильмы';
COMMENT ON COLUMN movie.name IS 'Название фильма';

-- Типы атрибутов
CREATE TABLE IF NOT EXISTS attribute_type
(
    id   SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL
);
COMMENT ON TABLE attribute_type IS 'Типы атрибутов';
COMMENT ON COLUMN attribute_type.name IS 'Имя типа';

-- Атрибуты
CREATE TABLE IF NOT EXISTS attribute
(
    id   SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL,
    attribute_type_id int NOT NULL,
    CONSTRAINT fk_attribute_type
        FOREIGN KEY (attribute_type_id)
            REFERENCES attribute_type (id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);
COMMENT ON TABLE attribute IS 'Атрибуты';
COMMENT ON COLUMN attribute.name IS 'Имя атрибута';
COMMENT ON COLUMN attribute.name IS 'Ссылка на тип атрибута';

-- Значения
CREATE TABLE IF NOT EXISTS value
(
    movie_id     int NOT NULL,
    attribute_id int NOT NULL,
    value        text DEFAULT NULL,
    CONSTRAINT fk_movie
        FOREIGN KEY (movie_id)
            REFERENCES movie (id)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    CONSTRAINT fk_attribute
        FOREIGN KEY (attribute_id)
            REFERENCES attribute (id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);
COMMENT ON TABLE value IS 'Значения';
COMMENT ON COLUMN value.movie_id IS 'Ссылка на фильм';
COMMENT ON COLUMN value.attribute_id IS 'Ссылка на атрибут';
COMMENT ON COLUMN value.value IS 'Само значение';

