-- insert
INSERT INTO attribute_type (name, data_type)
VALUES ('рецензии', 'text'),
       ('премия', 'boolean'),
       ('важные даты', 'date'),
       ('служебные даты', 'timestamp'),
       ('целочисленные значения', 'int'),
       ('дробные значения', 'float');
       
INSERT INTO films (name)
VALUES ('Interstellar'),
       ('Leon'),
       ('Dune');

INSERT INTO attribute (name, attribute_type_id)
    VALUES ('Рецензии известных критиков', (SELECT id FROM attribute_type WHERE name = 'рецензии')),
        ('Рецензии пользователей кинопоиска', (SELECT id FROM attribute_type WHERE name = 'рецензии')),
        ('Оскар', (SELECT id FROM attribute_type WHERE name = 'премия')),
        ('Ника', (SELECT id FROM attribute_type WHERE name = 'премия')),
        ('Золотой глобус', (SELECT id FROM attribute_type WHERE name = 'премия')),
        ('Премьера в мире', (SELECT id FROM attribute_type WHERE name = 'важные даты')),
        ('дата старта продаж билетов', (SELECT id FROM attribute_type WHERE name = 'служебные даты')),
        ('дата старта рекламной акции', (SELECT id FROM attribute_type WHERE name = 'служебные даты')),
        ('Продолжительность (в мин)', (SELECT id FROM attribute_type WHERE name = 'целочисленные значения')),
        ('Количеств оценок пользователей', (SELECT id FROM attribute_type WHERE name = 'целочисленные значения')),
        ('Рейтинг кинопоиска', (SELECT id FROM attribute_type WHERE name = 'дробные значения')),
        ('Рейтинг imdb', (SELECT id FROM attribute_type WHERE name = 'дробные значения'));
--value_text
INSERT INTO attribute_value (film_id, attribute_id, value_text)
    VALUES ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'Рецензии известных критиков'), 'Тут будет рецензия известного критика на фильм Interstellar'),
        ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'Рецензии пользователей кинопоиска'), 'Тут будет рецензия пользователя Х кипоноиска на фильм Interstellar'),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'Рецензии известных критиков'), 'Тут будет рецензия известного критика на фильм Leon'),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'Рецензии пользователей кинопоиска'), 'Тут будет рецензия пользователя Х кипоноиска на фильм Leon'),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'Рецензии известных критиков'), 'Тут будет рецензия известного критика на фильм Dune'),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'Рецензии пользователей кинопоиска'), 'Тут будет рецензия пользователя Х кипоноиска на фильм Dune');

--value_boolean
INSERT INTO attribute_value (film_id, attribute_id, value_boolean)
    VALUES ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'Оскар'), TRUE),
        ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'Ника'), FALSE),
        ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'Золотой глобус'), TRUE),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'Оскар'), FALSE),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'Ника'), FALSE),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'Золотой глобус'), TRUE),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'Оскар'), FALSE),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'Ника'), TRUE),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'Золотой глобус'), FALSE);

--value_date
INSERT INTO attribute_value (film_id, attribute_id, value_date)
    VALUES ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'дата старта продаж билетов'), '2023-01-01'),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'дата старта продаж билетов'), '2024-09-15'),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'дата старта продаж билетов'), '2024-08-01');

--value_timestamp
INSERT INTO attribute_value (film_id, attribute_id, value_timestamp)
    VALUES ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'дата старта рекламной акции'), '2022-12-15 00:00:00'),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'дата старта рекламной акции'), '2024-09-01 08:00:00'),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'дата старта рекламной акции'), '2024-07-15 12:00:00');

--value_int
INSERT INTO attribute_value (film_id, attribute_id, value_int)
    VALUES ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'Продолжительность (в мин)'), 120),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'Продолжительность (в мин)'), 156),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'Продолжительность (в мин)'), 103),
        ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'Количеств оценок пользователей'), 67801),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'Количеств оценок пользователей'), 778),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'Количеств оценок пользователей'), 5478);

--value_float
INSERT INTO attribute_value (film_id, attribute_id, value_float)
    VALUES ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'Рейтинг кинопоиска'), 8.2),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'Рейтинг кинопоиска'), 7.8),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'Рейтинг кинопоиска'), 7.5),
        ((SELECT id FROM films WHERE name = 'Interstellar'), (SELECT id FROM attribute WHERE name = 'Рейтинг imdb'), 8.6),
        ((SELECT id FROM films WHERE name = 'Leon'), (SELECT id FROM attribute WHERE name = 'Рейтинг imdb'), 8.0),
        ((SELECT id FROM films WHERE name = 'Dune'), (SELECT id FROM attribute WHERE name = 'Рейтинг imdb'), 7.3);