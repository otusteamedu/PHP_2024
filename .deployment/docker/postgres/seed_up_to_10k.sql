CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
    RETURNS INT AS
$$
BEGIN
    RETURN floor(random()* (high-low + 1) + low);
END;
$$ language 'plpgsql' STRICT;


-- Заполнение таблицы стран
INSERT INTO country (name)
VALUES ('США'),
       ('Великобритания'),
       ('Франция'),
       ('Россия'),
       ('Италия'),
       ('Канада');

-- Заполнение таблицы жанров
INSERT INTO genre (name)
VALUES ('Комедия'),
       ('Драма'),
       ('Фантастика'),
       ('Триллер'),
       ('Документальный'),
       ('Мультфильм');

-- Заполнение таблицы кинозалов
INSERT INTO hall (name, capacity)
VALUES ('Большой зал', 316),
       ('Средний зал', 215),
       ('Малый зал', 130),
       ('ATMOS', 130);

-- Добавление фильмов
INSERT INTO movie (name, description, country_id, produced_at)
VALUES ('Путешествие времени', 'Документальный фильм о космосе', 1, '2019-05-20'),
       ('Звездные войны: Новая надежда', 'Эпическая космическая опера', 3, '1977-05-25'),
       ('Властелин колец: Братство кольца', 'Фэнтезийный приключенческий фильм', 3, '2001-12-19'),
       ('Интерстеллар', 'Научно-фантастический фильм о космических путешествиях', 2, '2014-11-07'),
       ('Матрица', 'Научно-фантастический экшн', 3, '1999-03-31'),
       ('Джокер', 'Психологический триллер', 4, '2019-08-31');

-- Связь фильмов с жанрами
INSERT INTO movie_genre (movie_id, genre_id)
VALUES (1, 1),
       (2, 3),
       (3, 2),
       (4, 3),
       (5, 3),
       (6, 4);

-- Цены на фильмы
INSERT INTO movie_price (movie_id, price, type, started_at)
VALUES (1, 250, 'first', '2024-01-01'),
       (1, 350, 'second', '2024-01-01'),
       (1, 500, 'third', '2024-01-01'),
       (2, 450, 'first', '2024-01-01'),
       (2, 650, 'second', '2024-01-01'),
       (2, 800, 'third', '2024-01-01'),
       (3, 450, 'first', '2024-01-01'),
       (3, 650, 'second', '2024-01-01'),
       (3, 800, 'third', '2024-01-01'),
       (4, 250, 'first', '2024-01-01'),
       (4, 350, 'second', '2024-01-01'),
       (4, 500, 'third', '2024-01-01'),
       (5, 258, 'first', '2024-01-01'),
       (5, 354, 'second', '2024-01-01'),
       (5, 560, 'third', '2024-01-01'),
       (6, 245, 'first', '2024-01-01'),
       (6, 324, 'second', '2024-01-01'),
       (6, 450, 'third', '2024-01-01');

-- Места в кинозале
WITH halls AS (SELECT * FROM hall)

-- Большой
-- INSERT INTO seat (number, row, hall_id, type)
-- SELECT
-- FROM generate_series(1, 10000) AS sess_data
-- VALUES (1, 1, 4, 'first'),
--        (2, 1, 1, 'second'),
--        (3, 1, 1, 'third'),
--        (4, 2, 1, 'first'),
--        (5, 2, 1, 'second'),
--        (6, 2, 1, 'third');

-- Сеансы
INSERT INTO session (hall_id, movie_id, scheduled_at, duration)
SELECT
    (SELECT random_between(1, 4)),
    (SELECT random_between(1, 6)),
    NOW() + random() * (INTERVAL '1 day' * 30),
    (SELECT random_between(9000, 10800))
FROM generate_series(1, 10000) AS sess_data
