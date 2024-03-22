-- Транзакция внесения тестовых данных
BEGIN TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

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
INSERT INTO hall (name, capacity, rows_count)
VALUES ('Большой зал', 316, 13),
       ('Средний зал', 215, 11),
       ('Малый зал', 130, 10),
       ('ATMOS', 316, 13);

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
SELECT public.fill_cinema_halls();

-- Сеансы
INSERT INTO session (hall_id, movie_id, scheduled_at, duration)
SELECT random_between(1, 4),
       random_between(1, 6),
       NOW() + random() * (INTERVAL '1 day' * 30),
       random_between(9000, 10800)
FROM generate_series(1, 10000) AS sess_data;

-- Билеты
INSERT INTO ticket (seat_id, session_id, is_sold)
SELECT seat.id, s.id, true
FROM session s
         JOIN hall h ON h.id = s.hall_id
         JOIN seat ON h.id = seat.hall_id
;

INSERT INTO ticket_sale (ticket_id, amount, customer_email, created_at)
SELECT t.id,
       mp.price,
       (SELECT CONCAT('user_', SUBSTRING(md5(RANDOM()::text), 1, 10), '@example.com') AS random_email),
       s.scheduled_at
FROM ticket t
         JOIN session s ON t.session_id = s.id
         JOIN movie m ON s.movie_id = m.id
         JOIN seat st ON t.seat_id = st.id
         JOIN movie_price mp ON m.id = mp.movie_id AND st.type = mp.type
ORDER BY t.id;

COMMIT;
