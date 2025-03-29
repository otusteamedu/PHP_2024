INSERT INTO MOVIES (NAME)
VALUES ('Разделение');

INSERT INTO attribute_types (value_type, code)
VALUES ('Text', 'text'),
       ('Boolean', 'bool'),
       ('Date', 'date'),
       ('Int', 'int'),
       ('Float', 'float'),
       ('Date', 'business_date');

INSERT INTO attribute (attribute_type_id, name)
VALUES (1, 'Рецензия критиков'),
       (2, 'Оскар'),
       (3, 'Мировая премьера'),
       (6, 'Дата старта рекламы'),
       (4, 'Средняя цена билета'),
       (5, 'Средний вес актера'),
       (6, 'Дата конца рекламы');

INSERT INTO attribute_values (movie_id, attribute_id, value_text)
VALUES (1, 1, 'Идеальный сериал, отличная игра актеров!');
INSERT INTO attribute_values (movie_id, attribute_id, value_boolean)
VALUES (1, 2, TRUE);
INSERT INTO attribute_values (movie_id, attribute_id, value_date)
VALUES (1, 3, '2025-03-25');
INSERT INTO attribute_values (movie_id, attribute_id, value_date)
VALUES (1, 4, '2025-03-29');
INSERT INTO attribute_values (movie_id, attribute_id, value_date)
VALUES (1, 7, '2025-04-18');
INSERT INTO attribute_values (movie_id, attribute_id, value_int)
VALUES (1, 5, '80');
INSERT INTO attribute_values (movie_id, attribute_id, value_float)
VALUES (1, 6, '80.24');