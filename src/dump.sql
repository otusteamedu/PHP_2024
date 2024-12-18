INSERT INTO `movies` (`title`, `genre`, `duration`, `release_date`, `description`)
VALUES ('Oppenheimer', 'Genre 1', 120, '2020-01-01', 'Description 1'),
       ('Killers of the Flower Moon', 'Genre 2', 150, '2021-02-02', 'Description 2');

INSERT INTO `attribute_types` (`type`)
VALUES ('text'),
       ('date'),
       ('bool'),
       ('int');

INSERT INTO `attributes` (`name`, `movie_id`, `attribute_type_id`, `is_service`)
VALUES ('Описание', 1, 1, 0),
       ('Премьера', 1, 2, 0),
       ('Жанр', 1, 1, 0),
       ('Старт рекламы', 1, 1, 1),
       ('Старт продажи билетов', 1, 1, 1),
       ('Оскар', 1, 3, 0),
       ('Каннский фестиваль', 1, 3, 0);

INSERT INTO `attribute_values` (`attribute_id`, `value_text`)
VALUES (1, 'Описание фильма'),
       (3, 'Жанр фильма');

INSERT INTO `attribute_values` (`attribute_id`, `value_date`)
VALUES (2, '2025-04-01');

INSERT INTO `attribute_values` (`attribute_id`, `value_date`)
VALUES (4, '2025-01-01'),
       (5, '2025-03-01');

INSERT INTO `attribute_values` (`attribute_id`, `value_bool`)
VALUES (6, 1),
       (7, 0);