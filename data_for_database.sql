-- Заполняем фильмы
INSERT INTO films (name)
VALUES ('Соник'),
       ('Соник 2');

-- Заполняем типы атрибутов
INSERT INTO attribute_types (name)
VALUES ('Рецензии'),
       ('Премия'),
       ('Важные даты'),
       ('Служебные даты');

-- Заполняем атрибуты
INSERT INTO attributes (attribute_type_id, name)
VALUES (1, 'Рецензия критиков'),
       (1, 'Отзыв неизвестной киноакадемии'),
       (2, 'Оскар'),
       (2, 'Ника'),
       (3, 'Мировая премьера'),
       (3, 'Премьера в РФ'),
       (4, 'Начало продажи билетов'),
       (4, 'Запуск рекламы на ТВ');

-- Заполняем значения
INSERT INTO attribute_values (film_id, attribute_id, value_text, value_date, value_boolean)
VALUES (1, 1, 'Фильм блестящий!', NULL, NULL),
       (1, 3, NULL, NULL, TRUE),
       (1, 5, NULL, '2025-01-15', NULL),
       (1, 7, NULL, '2025-01-06', NULL),
       (2, 2, 'Неоднозначный отзыв', NULL, NULL),
       (2, 4, NULL, NULL, TRUE),
       (2, 6, NULL, '2025-02-01', NULL),
       (2, 8, NULL, '2025-01-26', NULL);
