-- Фильмы
INSERT INTO movies (title, description, release_year)
VALUES ('Inception', 'A mind-bending thriller by Christopher Nolan.', 2010),
       ('The Matrix', 'A cyberpunk action film by Wachowski siblings.', 1999);

-- Типы атрибутов
INSERT INTO attribute_types (name, data_type)
VALUES ('рецензии', 'text'),
       ('премия', 'boolean'),
       ('важные даты', 'date'),
       ('служебные даты', 'date'),
       ('оценка', 'number');

-- Атрибуты и значения
-- Фильм: Inception
INSERT INTO values (attribute_id, value_text)
VALUES (1, 'Отличный фильм с глубоким смыслом.');

INSERT INTO values (attribute_id, value_boolean)
VALUES (2, TRUE);

INSERT INTO values (attribute_id, value_date)
VALUES (3, '2010-07-16');

INSERT INTO values (attribute_id, value_timestamp)
VALUES (4, CURRENT_TIMESTAMP + INTERVAL '5 days');

INSERT INTO values (attribute_id, value_decimal)
VALUES (5, 9.50);

-- Фильм: The Matrix
INSERT INTO values (attribute_id, value_text)
VALUES (6, 'Революция в мире кино.');

INSERT INTO values (attribute_id, value_boolean)
VALUES (7, TRUE);

INSERT INTO values (attribute_id, value_date)
VALUES (8, '1999-03-31');

INSERT INTO values (attribute_id, value_timestamp)
VALUES (9, CURRENT_TIMESTAMP + INTERVAL '10 days');

INSERT INTO values (attribute_id, value_decimal)
VALUES (10, 9.00);
