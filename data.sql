INSERT INTO movies (title) VALUES ('Интерстеллар');

INSERT INTO attribute_types (name, data_type) VALUES
    ('рецензии', 'TEXT'),
    ('премия', 'BOOLEAN'),
    ('важные даты', 'DATE'),
    ('служебные даты', 'DATE');

INSERT INTO attributes (type_id, name) VALUES
    (1, 'Рецензия критиков'),
    (2, 'Оскар'),
    (3, 'Мировая премьера'),
    (4, 'Дата старта рекламы');

INSERT INTO values (movie_id, attribute_id, value_text) VALUES (1, 1, 'Отличный фильм!');
INSERT INTO values (movie_id, attribute_id, value_boolean) VALUES (1, 2, TRUE);
INSERT INTO values (movie_id, attribute_id, value_date) VALUES (1, 3, '2024-01-17');
INSERT INTO values (movie_id, attribute_id, value_date) VALUES (1, 4, '2024-11-05');
