CREATE TABLE films
(
    film_id   SERIAL PRIMARY KEY,
    film_name VARCHAR(255) NOT NULL
);

CREATE TYPE value_type_enum AS ENUM ('TEXT', 'BOOLEAN', 'DATE', 'NUMBER', 'FLOAT');

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
    value_number       BIGINT,
    value_float        NUMERIC,
    FOREIGN KEY (attribute_id) REFERENCES attributes (attribute_id)
);

INSERT INTO films (film_name)
VALUES ('Начало'),
       ('Крестный отец'),
       ('Паразиты'),
       ('Интерстеллар')
;

INSERT INTO attribute_types (attribute_name, value_type)
VALUES ('Рецензия критиков', 'TEXT'),
       ('Оскар', 'BOOLEAN'),
       ('Премьера', 'DATE'),
       ('Дата начала продажи билетов', 'DATE'),
       ('Дата рекламной компании', 'DATE'),
       ('Год выпуска', 'NUMBER'),
       ('Сборы', 'FLOAT')
;

INSERT INTO attributes (film_id, attribute_type_id)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4),
       (1, 5),
       (1, 6),
       (1, 7),
       (2, 1),
       (2, 2),
       (2, 3),
       (2, 4),
       (2, 5),
       (2, 6),
       (2, 7),
       (3, 1),
       (3, 2),
       (3, 3),
       (3, 4),
       (3, 5),
       (3, 6),
       (3, 7),
       (4, 1),
       (4, 2),
       (4, 3),
       (4, 4),
       (4, 5),
       (4, 6),
       (4, 7)
;

INSERT INTO attribute_values (attribute_id, value_text, value_boolean, value_date, value_number, value_float)
VALUES (1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...', NULL, NULL, NULL, NULL),
       (2, NULL, TRUE, NULL, NULL, NULL),
       (3, NULL, NULL, '2010-07-16', NULL, NULL),
       (4, NULL, NULL, '2010-06-01', NULL, NULL),
       (5, NULL, NULL, '2010-06-10', NULL, NULL),
       (6, NULL, NULL, NULL, 2010, NULL),
       (7, 'Lorem ipsum dolor sit amet...', NULL, NULL, NULL, NULL),
       (8, NULL, TRUE, NULL, NULL, NULL),
       (9, NULL, NULL, '1972-03-24', NULL, NULL),
       (10, NULL, NULL, '1972-03-01', NULL, NULL),
       (11, NULL, NULL, '1972-03-05', NULL, NULL),
       (12, NULL, NULL, NULL, 1972, NULL),
       (13, 'Lorem ipsum dolor sit amet...', NULL, NULL, NULL, NULL),
       (14, NULL, TRUE, NULL, NULL, NULL),
       (15, NULL, NULL, '2019-05-30', NULL, NULL),
       (16, NULL, NULL, '2019-04-20', NULL, NULL),
       (17, NULL, NULL, '2019-04-25', NULL, NULL),
       (18, NULL, NULL, NULL, 2019, NULL),
       (19, 'Lorem ipsum dolor sit amet...', NULL, NULL, NULL, NULL),
       (20, NULL, FALSE, NULL, NULL, NULL),
       (21, NULL, NULL, '2014-11-07', NULL, NULL),
       (22, NULL, NULL, '2014-10-01', NULL, NULL),
       (23, NULL, NULL, '2014-10-05', NULL, NULL),
       (24, NULL, NULL, NULL, 2014, NULL),
       (25, NULL, NULL, NULL, NULL, 1.1),
       (26, NULL, NULL, NULL, NULL, 3.33),
       (27, NULL, NULL, NULL, NULL, 10.3),
       (28, NULL, NULL, NULL, NULL, 100.3)
;

CREATE INDEX idx_films_film_id ON films (film_id);
CREATE INDEX idx_attribute_types_attribute_type_id ON attribute_types (attribute_type_id);
CREATE INDEX idx_attributes_film_id ON attributes (film_id);
CREATE INDEX idx_attributes_attribute_type_id ON attributes (attribute_type_id);
CREATE INDEX idx_attribute_values_attribute_id ON attribute_values (attribute_id);
CREATE INDEX idx_attribute_values_date ON attribute_values (value_date);
CREATE INDEX idx_attribute_values_float ON attribute_values (value_float);
CREATE INDEX idx_attribute_values_boolean ON attribute_values (value_boolean);
CREATE INDEX idx_attribute_values_number ON attribute_values (value_number);

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
           WHEN at.value_type = 'NUMBER' THEN av.value_number
           WHEN at.value_type = 'FLOAT' THEN av.value_float
           END           AS "Значение"
FROM films f
         JOIN attributes a ON f.film_id = a.film_id
         JOIN attribute_types at ON a.attribute_type_id = at.attribute_type_id
         JOIN attribute_values av ON a.attribute_id = av.attribute_id;
