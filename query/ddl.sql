-- Создаем таблицу с фильмами
CREATE TABLE movies
(
    movie_id     SERIAL PRIMARY KEY,
    title        VARCHAR(255) NOT NULL,
    release_year INT
);

-- Создаем атрибут типы
CREATE TABLE attribute_types
(
    attribute_type_id SERIAL PRIMARY KEY,
    type_name         VARCHAR(255) NOT NULL,
    sql_type          VARCHAR(255) NOT NULL CHECK (sql_type IN ('VARCHAR', 'BOOLEAN', 'DATE', 'FLOAT', 'INT'))
);

-- Создаем аттрибуты
CREATE TABLE attributes
(
    attribute_id      SERIAL PRIMARY KEY,
    attribute_name    VARCHAR(255) NOT NULL,
    attribute_type_id INT,
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (attribute_type_id)
);

-- Создаем для EAV
CREATE TABLE attribute_values
(
    value_id      SERIAL PRIMARY KEY,
    movie_id      INT,
    attribute_id  INT,
    value_text    TEXT,
    value_boolean BOOLEAN,
    value_date    DATE,
    value_float   FLOAT,
    value_integer INT,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies (movie_id),
    FOREIGN KEY (attribute_id) REFERENCES attributes (attribute_id)
);

-- Индексы
CREATE INDEX idx_movie_id ON attribute_values (movie_id);
CREATE INDEX idx_attribute_id ON attribute_values (attribute_id);
CREATE INDEX idx_value_text ON attribute_values (value_text);
CREATE INDEX idx_value_boolean ON attribute_values (value_boolean);
CREATE INDEX idx_value_date ON attribute_values (value_date);
CREATE INDEX idx_value_float ON attribute_values (value_float);
CREATE INDEX idx_value_integer ON attribute_values (value_integer);

-- Тут наши типы
INSERT INTO attribute_types (type_name, sql_type)
VALUES ('Текст', 'VARCHAR'),
       ('Логический', 'BOOLEAN'),
       ('Дата', 'DATE'),
       ('Числовой', 'FLOAT'),
       ('Целочисленный', 'FLOAT');

-- Добавляем фильмы
INSERT INTO movies (title, release_year)
VALUES ('Начало', 2020),
       ('Титаник', 2021),
       ('Интерстеллар', 2023),
       ('Матрица', 2024);

-- Добавляем аттрибуты
INSERT INTO attributes (attribute_name, attribute_type_id)
VALUES ('Рецензии критиков', 1),
       ('Оскар', 2),
       ('Премьера', 3),
       ('Сборы в прокате', 4),
       ('Начало продаж', 3),
       ('Запуск события', 3),
       ('Количество проданных билетов', 5);


-- Для фильма Начало
INSERT INTO attribute_values (movie_id, attribute_id, value_text, value_boolean, value_date, value_float, value_integer)
VALUES (1, 1,
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum.',
        NULL, NULL, NULL, NULL),
       (1, 2, NULL, TRUE, NULL, NULL, NULL),
       (1, 3, NULL, NULL, '2020-07-16', NULL, NULL),
       (1, 4, NULL, NULL, NULL, 829.9, NULL),
       (1, 5, NULL, NULL, '2020-06-01', NULL, NULL),
       (1, 6, NULL, NULL, '2020-05-15', NULL, NULL),
       (1, 7, NULL, NULL, NULL, NULL, 58666);

-- Для фильма Титаник
INSERT INTO attribute_values (movie_id, attribute_id, value_text, value_boolean, value_date, value_float, value_integer)
VALUES (2, 1,
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla.',
        NULL, NULL, NULL, NULL),
       (2, 2, NULL, TRUE, NULL, NULL, NULL),
       (2, 3, NULL, NULL, '2021-12-19', NULL, NULL),
       (2, 4, NULL, NULL, NULL, 2187.5, NULL),
       (2, 5, NULL, NULL, '2021-11-01', NULL, NULL),
       (2, 6, NULL, NULL, '2021-10-20', NULL, NULL),
       (2, 6, NULL, NULL, NULL, NULL, 546515);

-- Для фильма Интерстеллар
INSERT INTO attribute_values (movie_id, attribute_id, value_text, value_boolean, value_date, value_float, value_integer)
VALUES (3, 1,
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc.',
        NULL, NULL, NULL, NULL),
       (3, 2, NULL, FALSE, NULL, NULL, NULL),
       (3, 3, NULL, NULL, '2023-11-07', NULL, NULL),
       (3, 4, NULL, NULL, NULL, 677.5, NULL),
       (3, 5, NULL, NULL, '2023-09-25', NULL, NULL),
       (3, 6, NULL, NULL, '2023-09-10', NULL, NULL),
       (3, 6, NULL, NULL, NULL, NULL, 658565);

-- Для фильма Матрица
INSERT INTO attribute_values (movie_id, attribute_id, value_text, value_boolean, value_date, value_float, value_integer)
VALUES (4, 1,
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam.',
        NULL, NULL, NULL, NULL),
       (4, 2, NULL, TRUE, NULL, NULL, NULL),
       (4, 3, NULL, NULL, '2024-03-31', NULL, NULL),
       (4, 4, NULL, NULL, NULL, 466.3, NULL),
       (4, 5, NULL, NULL, '2024-02-10', NULL, NULL),
       (4, 6, NULL, NULL, '2024-01-25', NULL, NULL),
       (4, 6, NULL, NULL, NULL, NULL, 213212);

CREATE VIEW service_tasks AS
SELECT m.title          AS movie_title,
       a.attribute_name AS task_name,
       av.value_date    AS task_date
FROM movies m
         JOIN attribute_values av ON m.movie_id = av.movie_id
         JOIN attributes a ON av.attribute_id = a.attribute_id
         JOIN attribute_types at ON a.attribute_type_id = at.attribute_type_id
WHERE at.sql_type = 'DATE'
  AND (av.value_date = CURRENT_DATE OR av.value_date = CURRENT_DATE + INTERVAL '20 day');


CREATE VIEW marketing_data AS
SELECT m.title                        AS movie_title,
       at.type_name                   AS attribute_type,
       a.attribute_name               AS attribute_name,
       COALESCE(av.value_text::TEXT, av.value_boolean::TEXT, av.value_date::TEXT,
                av.value_float::TEXT) AS attribute_value
FROM movies m
         JOIN attribute_values av ON m.movie_id = av.movie_id
         JOIN attributes a ON av.attribute_id = a.attribute_id
         JOIN attribute_types at ON a.attribute_type_id = at.attribute_type_id;
