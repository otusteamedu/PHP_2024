-- 1. Таблица фильмов
CREATE TABLE IF NOT EXISTS movies (
                                      id SERIAL PRIMARY KEY,
                                      title VARCHAR(255) NOT NULL
);

-- 2. Таблица типов атрибутов
CREATE TABLE IF NOT EXISTS attribute_types (
                                               id SERIAL PRIMARY KEY,
                                               name VARCHAR(100) UNIQUE NOT NULL
);

-- 3. Таблица атрибутов
CREATE TABLE IF NOT EXISTS attributes (
                                          id SERIAL PRIMARY KEY,
                                          type_id INT NOT NULL,
                                          name VARCHAR(255) NOT NULL,
                                          FOREIGN KEY (type_id) REFERENCES attribute_types(id)
);

CREATE INDEX idx_attributes_type_id ON attributes(type_id);
CREATE UNIQUE INDEX idx_attributes_unique ON attributes(type_id, name);

-- 4. Таблица значений
CREATE TABLE `values` (
                        id SERIAL PRIMARY KEY,
                        movie_id INT NOT NULL,
                        attribute_id INT NOT NULL,
                        text_value TEXT,
                        boolean_value BOOLEAN,
                        date_value DATE,
                        float_value FLOAT,
                        int_value INTEGER,
                        FOREIGN KEY (movie_id) REFERENCES movies(id),
                        FOREIGN KEY (attribute_id) REFERENCES attributes(id)
);

CREATE INDEX idx_values_movie_id ON `values`(movie_id);
CREATE INDEX idx_values_attribute_id ON `values`(attribute_id);

