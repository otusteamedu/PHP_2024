CREATE TABLE films
(
    film_id   SERIAL PRIMARY KEY,
    film_name VARCHAR(255) NOT NULL
);

CREATE TYPE value_type_enum AS ENUM ('TEXT', 'BOOLEAN', 'DATE');

CREATE TABLE attribute_types
(
    attribute_type_id SERIAL PRIMARY KEY,
    attribute_name    VARCHAR(255)    NOT NULL,
    value_type        value_type_enum NOT NULL
);

CREATE TABLE attributes
(
    attribute_id      SERIAL PRIMARY KEY,
    film_id           INT NOT NULL,
    attribute_type_id INT NOT NULL,
    FOREIGN KEY (film_id) REFERENCES films (film_id),
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (attribute_type_id)
);

CREATE TABLE attribute_values
(
    attribute_value_id SERIAL PRIMARY KEY,
    attribute_id       INT NOT NULL,
    value_text         TEXT,
    value_boolean      BOOLEAN,
    value_date         DATE,
    FOREIGN KEY (attribute_id) REFERENCES attributes (attribute_id)
);

INSERT INTO films (film_name)
VALUES ('Начало'),
       ('Крестный отец'),
       ('Паразиты'),
       ('Интерстеллар');

INSERT INTO attribute_types (attribute_name, value_type)
VALUES ('Рецензия критиков', 'TEXT'),
       ('Оскар', 'BOOLEAN'),
       ('Премьера', 'DATE'),
       ('Дата начала продажи билетов', 'DATE'),
       ('Дата рекламной компании', 'DATE');

INSERT INTO attributes (film_id, attribute_type_id)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4),
       (1, 5),
       (2, 1),
       (2, 2),
       (2, 3),
       (2, 4),
       (2, 5),
       (3, 1),
       (3, 2),
       (3, 3),
       (3, 4),
       (3, 5),
       (4, 1),
       (4, 2),
       (4, 3),
       (4, 4),
       (4, 5);

INSERT INTO attribute_values (attribute_id, value_text, value_boolean, value_date)
VALUES (1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', NULL, NULL),
       (2, NULL, TRUE, NULL),
       (3, NULL, NULL, '2010-07-16'),
       (4, NULL, NULL, '2010-06-01'),
       (5, NULL, NULL, '2010-06-10'),
       (6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', NULL, NULL),
       (7, NULL, TRUE, NULL),
       (8, NULL, NULL, '1972-03-24'),
       (9, NULL, NULL, '1972-03-01'),
       (10, NULL, NULL, '1972-03-05'),
       (11, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', NULL,
        NULL),
       (12, NULL, TRUE, NULL),
       (13, NULL, NULL, '2019-05-30'),
       (14, NULL, NULL, '2019-04-20'),
       (15, NULL, NULL, '2019-04-25'),
       (16, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        NULL, NULL),
       (17, NULL, FALSE, NULL),
       (18, NULL, NULL, '2014-11-07'),
       (19, NULL, NULL, '2014-10-01'),
       (20, NULL, NULL, '2014-10-05');

CREATE INDEX idx_films_film_id ON films (film_id);
CREATE INDEX idx_attribute_types_attribute_type_id ON attribute_types (attribute_type_id);
CREATE INDEX idx_attributes_film_id ON attributes (film_id);
CREATE INDEX idx_attributes_attribute_type_id ON attributes (attribute_type_id);
CREATE INDEX idx_attribute_values_attribute_id ON attribute_values (attribute_id);
CREATE INDEX idx_attribute_values_value_date ON attribute_values (value_date);

CREATE VIEW service_tasks AS
SELECT f.film_name       AS "Фильм",
       at.attribute_name AS "Задача",
       av.value_date     AS "Дата"
FROM films f
         JOIN attributes a ON f.film_id = a.film_id
         JOIN attribute_types at ON a.attribute_type_id = at.attribute_type_id
JOIN attribute_values av ON a.attribute_id = av.attribute_id
WHERE at.attribute_name IN ('Дата начала показа', 'Дата рекламной компании')
AND (av.value_date = CURRENT_DATE OR av.value_date = CURRENT_DATE + INTERVAL '20 days');

CREATE VIEW marketing_data AS
SELECT f.film_name       AS "Фильм",
       at.attribute_name AS "Тип атрибута",
       CASE
           WHEN at.value_type = 'TEXT' THEN av.value_text
           WHEN at.value_type = 'BOOLEAN' THEN CASE WHEN av.value_boolean THEN 'Да' ELSE 'Нет' END
           WHEN at.value_type = 'DATE' THEN TO_CHAR(av.value_date, 'YYYY-MM-DD')
           END           AS "Значение"
FROM films f
         JOIN attributes a ON f.film_id = a.film_id
         JOIN attribute_types at ON a.attribute_type_id = at.attribute_type_id
JOIN attribute_values av ON a.attribute_id = av.attribute_id;