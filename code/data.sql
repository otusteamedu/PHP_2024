-- Наполнение таблицы movies (Фильмы)
INSERT INTO movies (id, name)
VALUES (1, 'Форсаж 7'),
       (2, 'Железный человек');

-- Наполнение таблицы attribute_types (Типы аттрибутов)
INSERT INTO attribute_types (id, name, type)
VALUES (1, 'Рецензия', 'text'),
       (2, 'Премия', 'boolean'),
       (3, 'Важные даты', 'date'),
       (4, 'Служебные даты', 'date'),
       (5, 'Часть', 'integer'),
       (6, 'Деньги', 'float');

-- Наполнение таблицы attributes (Аттрибуты)
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (1, 'Рецензии на IMDb', 1),
       (2, 'Рецензии на Кинопоиск', 1),
       (3, 'Премия Оскар', 2),
       (4, 'Премия Золотой глобус', 2),
       (5, 'Мировая премьера', 3),
       (6, 'Премьера в РФ', 3),
       (7, 'Дата начала продажи билетов', 4),
       (8, 'Дата рекламы на ТВ', 4),
       (9, 'Часть фильма', 5),
       (10, 'Кассовые сборы', 6),
       (11, 'Бюджет фильма', 6);

-- Наполнение таблицы values (Значения)
INSERT INTO values (id, attribute_id, movie_id, text_value, boolean_value, date_value, integer_value, float_value)
VALUES (1, 1, 1, 'Один из лучших боевиков, которые существуют, и определенно лучший в серии «Форсаж»...',
        NULL, NULL, NULL, NULL),
       (2, 2, 1, 'Фильм дарит положительные эмоции от всего того драйва, который открывается перед зрителем ...',
        NULL, NULL, NULL, NULL),
       (3, 3, 1, NULL, 'false', NULL, NULL, NULL),
       (4, 4, 1, NULL, 'true', NULL, NULL, NULL),
       (5, 5, 1, NULL, NULL, '2014-07-11', NULL, NULL),
       (6, 6, 1, NULL, NULL, '2015-04-09', NULL, NULL),
       (7, 7, 1, NULL, NULL, '2014-07-10', NULL, NULL),
       (8, 8, 1, NULL, NULL, '2014-02-01', NULL, NULL),
       (9, 9, 1, NULL, NULL, NULL, 7, NULL),
       (10, 10, 1, NULL, NULL, NULL, NULL, 1516045911),
       (11, 11, 1, NULL, NULL, NULL, NULL, 250000000),
       (12, 1, 2, 'Фильм для людей, которые никогда не знали Железного человека в комиксах. Персонажи получили...',
        NULL, NULL, NULL, NULL),
       (13, 2, 2, 'Без сомнений данная фантастическая кинокартина снята очень качественно с визуальными эффектами...',
        NULL, NULL, NULL, NULL),
       (14, 3, 2, NULL, 'true', NULL, NULL, NULL),
       (15, 4, 2, NULL, 'false', NULL, NULL, NULL),
       (16, 5, 2, NULL, NULL, '2008-04-30', NULL, NULL),
       (17, 6, 2, NULL, NULL, '2008-05-01', NULL, NULL),
       (18, 7, 2, NULL, NULL, '2008-04-29', NULL, NULL),
       (19, 8, 2, NULL, NULL, '2008-01-01', NULL, NULL),
       (20, 9, 2, NULL, NULL, NULL, 1, NULL),
       (21, 10, 2, NULL, NULL, NULL, NULL, 585796247),
       (22, 11, 2, NULL, NULL, NULL, NULL, 140000000);


