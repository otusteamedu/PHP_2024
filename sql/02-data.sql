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
INSERT INTO attributes (movie_id, attribute_type_id, name)
VALUES (1, 1, 'Рецензия критика'),
       (1, 2, 'Оскар'),
       (1, 3, 'Мировая премьера'),
       (1, 4, 'Дата начала продажи билетов'),
       (1, 5, 'Оценка зрителей');

INSERT INTO values (attribute_id, value_text)
VALUES (1, 'Отличный фильм с глубоким смыслом.');
INSERT INTO values (attribute_id, value_boolean)
VALUES (2, TRUE);
INSERT INTO values (attribute_id, value_date)
VALUES (3, '2010-07-16');
INSERT INTO values (attribute_id, value_date)
VALUES (4, CURRENT_DATE + INTERVAL '5 days');
INSERT INTO values (attribute_id, value_number)
VALUES (5, 9.5);

-- Фильм: The Matrix
INSERT INTO attributes (movie_id, attribute_type_id, name)
VALUES (2, 1, 'Рецензия критика'),
       (2, 2, 'Оскар'),
       (2, 3, 'Мировая премьера'),
       (2, 4, 'Дата начала продажи билетов'),
       (2, 5, 'Оценка зрителей');

INSERT INTO values (attribute_id, value_text)
VALUES (6, 'Революция в мире кино.');
INSERT INTO values (attribute_id, value_boolean)
VALUES (7, TRUE);
INSERT INTO values (attribute_id, value_date)
VALUES (8, '1999-03-31');
INSERT INTO values (attribute_id, value_date)
VALUES (9, CURRENT_DATE + INTERVAL '10 days');
INSERT INTO values (attribute_id, value_number)
VALUES (10, 9.0);
