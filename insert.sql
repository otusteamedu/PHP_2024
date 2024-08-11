CREATE OR REPLACE FUNCTION generate_random_date(start_date DATE, end_date DATE) RETURNS DATE AS
$$
DECLARE
    random_days INTEGER;
BEGIN
    random_days := (SELECT random() * (end_date - start_date) + 1);
    RETURN start_date + random_days;
END;
$$ LANGUAGE plpgsql;

INSERT INTO movies (title)
SELECT 'Фильм ' || seq.num
FROM generate_series(10000, 10000000) AS seq(num);

INSERT INTO attributes_types (name)
VALUES ('Рецензии'),
       ('Премия'),
       ('Важные даты'),
       ('Служебные даты');

INSERT INTO attributes_names (name, attributes_types_id)
VALUES ('Рецензии критиков', 1),
       ('отзыв неизвестной киноакадемии', 1),
       ('Оскар', 2),
       ('Глас народа', 2),
       ('Мировая премьера', 3),
       ('Премьера в РФ', 3),
       ('Дата начала продажи билетов', 4),
       ('Дата запуска рекламы на ТВ', 4);

INSERT INTO attributes_values (movies_id, attributes_names_id, value_date)
VALUES (1, 5, '2023-11-01'),
       (2, 5, '1980-05-17'),
       (3, 5, '2021-09-03'),
       (1, 8, CURRENT_DATE),
       (2, 8, CURRENT_DATE),
       (3, 8, CURRENT_DATE),
       (1, 7, CURRENT_DATE + '20 days'::interval),
       (2, 7, CURRENT_DATE + '20 days'::interval),
       (3, 7, CURRENT_DATE + '20 days'::interval);

INSERT INTO halls (name)
SELECT 'Зал ' || seq.num
FROM generate_series(1, 10000) AS seq(num);


INSERT INTO sessions (hall_id, movie_id, start_time)
SELECT seq.num % 10000 + 1,
       seq.num % 10000 + 1,
       CURRENT_DATE + (seq.num % 30) * INTERVAL '1 day'
FROM generate_series(1, 10000) AS seq(num);

INSERT INTO seats (hall_id, row_number, seat_number)
SELECT seq.num % 30 + 1,
       seq.num % 2 + 1,
       seq.num % 20 + 1
FROM generate_series(1, 10000) AS seq(num);

INSERT INTO clients (name, phone)
SELECT 'Клиент ' || seq.num,
       '+7' || lpad((seq.num % 9999999 + 1)::text, 7, '0')
FROM generate_series(1, 10000) AS seq(num);

INSERT INTO tickets (session_id, seat_id, price, client_id, date)
SELECT seq.num % 10000 + 1,
       seq.num % 10000 + 1,
       (seq.num % 10 + 1) * 50,
       seq.num % 10000 + 1,
       generate_random_date('2024-01-01', CURRENT_DATE)
FROM generate_series(1, 10000) AS seq(num);

