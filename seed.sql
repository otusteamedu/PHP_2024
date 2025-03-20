INSERT IGNORE INTO movies
values (1, 'Титаник'),
       (2, 'Аватар');

INSERT IGNORE INTO attribute_types
values (1, 'text'),
       (2, 'boolean'),
       (3, 'date'),
       (4, 'service_date'),
       (5, 'float'),
       (6, 'integer');

INSERT IGNORE INTO attributes (id, type_id, name)
values (1, 1, 'Рецензия'),
       (2, 2, 'Премия Оскар'),
       (3, 2, 'Премия Ника'),
       (4, 3, 'Мировая премьера'),
       (5, 4, 'Начало продаж билетов'),
       (6, 4, 'Реклама на ТВ'),
       (7, 5, 'Рейтинг'),
       (8, 6, 'Кассовые сборы');

-- Титаник
INSERT INTO values (movie_id, attribute_id, text_value) VALUES (1, 1, 'Отличный романтическо-приключенческий фильм');
INSERT INTO values (movie_id, attribute_id, boolean_value) VALUES (1, 2, TRUE);
INSERT INTO values (movie_id, attribute_id, boolean_value) VALUES (1, 3, FALSE);
INSERT INTO values (movie_id, attribute_id, date_value) VALUES (1, 4, '1997-09-17');
INSERT INTO values (movie_id, attribute_id, date_value) VALUES (1, 5, CURRENT_DATE);
INSERT INTO values (movie_id, attribute_id, date_value) VALUES (1, 6, CURRENT_DATE);
INSERT INTO values (movie_id, attribute_id, float_value) VALUES (1, 7, 9.89);
INSERT INTO values (movie_id, attribute_id, float_value) VALUES (1, 8, 900000);

-- Аватар
INSERT INTO values (movie_id, attribute_id, text_value) values (2, 1, 'Фантсатика, заставляет задуматься...');
INSERT INTO values (movie_id, attribute_id, boolean_value) values (2, 2, TRUE);
INSERT INTO values (movie_id, attribute_id, boolean_value) values (2, 3, FALSE);
INSERT INTO values (movie_id, attribute_id, date_value) values (2, 4, '2009-09-17');
INSERT INTO values (movie_id, attribute_id, date_value) values (2, 5, CURRENT_DATE);
INSERT INTO values (movie_id, attribute_id, date_value) values (2, 6, CURRENT_DATE+20);
INSERT INTO values (movie_id, attribute_id, float_value) values (2, 7, 9.99);
INSERT INTO values (movie_id, attribute_id, float_value) values (2, 8, 1900000);

