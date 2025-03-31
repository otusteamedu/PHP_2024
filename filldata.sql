Create or replace function random_string(length integer) returns text as
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length loop
            result := result || chars[1+random()*(array_length(chars, 1)-1)];
        end loop;
    return result;
end;
$$ language plpgsql;

-- truncate

-- Отключаем проверку внешних ключей на время выполнения очистки
SET CONSTRAINTS ALL DEFERRED;

-- Очищаем таблицы в порядке от зависимых к независимым
TRUNCATE TABLE ticket CASCADE;
TRUNCATE TABLE price_list CASCADE;
TRUNCATE TABLE customer CASCADE;
TRUNCATE TABLE schedule CASCADE;
TRUNCATE TABLE seat CASCADE;
TRUNCATE TABLE movie CASCADE;
TRUNCATE TABLE hall CASCADE;
TRUNCATE TABLE cinema CASCADE;

-- Сбрасываем счетчики последовательностей для всех таблиц
ALTER SEQUENCE ticket_id_seq RESTART WITH 1;
ALTER SEQUENCE price_list_id_seq RESTART WITH 1;
ALTER SEQUENCE customer_id_seq RESTART WITH 1;
ALTER SEQUENCE schedule_id_seq RESTART WITH 1;
ALTER SEQUENCE seat_id_seq RESTART WITH 1;
ALTER SEQUENCE movie_id_seq RESTART WITH 1;
ALTER SEQUENCE hall_id_seq RESTART WITH 1;
ALTER SEQUENCE cinema_id_seq RESTART WITH 1;

-- Включаем проверку внешних ключей обратно
SET CONSTRAINTS ALL IMMEDIATE;

-- cinema

INSERT INTO cinema (name)
VALUES ('Анапа'),
       ('Краснодар');

-- hall

INSERT INTO hall (cinema_id, name, capacity)
SELECT random(1, 2),
       CONCAT('hall_', random_string(10)),
       random(50, 100)
FROM generate_series(1, 10) AS id;

-- seat

WITH hall_data AS (
    SELECT
        h.id AS hall_id,
        h.capacity,
        CEIL(SQRT(h.capacity::float))::int AS max_rows
    FROM hall h
),
     seat_generation AS (
         SELECT
             hd.hall_id,
             r AS row_number,
             s AS seat_number
         FROM hall_data hd
                  CROSS JOIN generate_series(1, hd.max_rows) AS r
                  CROSS JOIN generate_series(1, CEIL(hd.capacity::float / hd.max_rows)::int) AS s
         WHERE (r - 1) * CEIL(hd.capacity::float / hd.max_rows)::int + s <= hd.capacity
     )
INSERT INTO seat (hall_id, row_number, seat_number)
SELECT hall_id, row_number, seat_number
FROM seat_generation;

-- movie

INSERT INTO movie (title, duration, release_date)
SELECT CONCAT('movie_', random_string(10)),
       random(1, 3),
       CURRENT_DATE + (random() * 40)::int
FROM generate_series(1, 20) AS id;

-- schedule

WITH date_range AS (
    -- Создаем диапазон дат для расписания
    SELECT generate_series(
                           CURRENT_DATE,
                           CURRENT_DATE + 40,
                           interval '1 day'
           )::date AS show_date),
     movie_dates AS (
         -- Связываем фильмы с датами, когда они доступны для показа
         SELECT m.id                           AS movie_id,
                m.duration * interval '1 hour' AS duration,
                dr.show_date
         FROM movie m
                  JOIN date_range dr ON dr.show_date >= m.release_date),
     time_slots AS (
         -- Создаем временные слоты с 9:00 до 22:00 используя интервалы
         SELECT ('09:00:00'::time + (s * interval '30 minutes'))::time AS start_time
         FROM generate_series(0, 26) AS s -- 26 получасовых интервалов от 9:00 до 22:00
         WHERE ('09:00:00'::time + (s * interval '30 minutes'))::time <=
               '19:00:00'::time -- Максимум 19:00, чтобы фильм длиной 3 часа закончился к 22:00
     ),
     possible_shows AS (
         -- Создаем все возможные показы
         SELECT md.movie_id,
                h.id                         AS hall_id,
                md.show_date + ts.start_time AS show_time,
                md.duration
         FROM movie_dates md
                  CROSS JOIN hall h
                  CROSS JOIN time_slots ts
         WHERE (ts.start_time + md.duration) <= '22:00:00'::time),
     daily_movie_counts AS (
         -- Для каждого фильма и дня выбираем показы
         SELECT movie_id,
                hall_id,
                show_time,
                duration,
                ROW_NUMBER() OVER (PARTITION BY movie_id, show_time::date, hall_id ORDER BY random()) AS movie_show_rank
         FROM possible_shows),
     selected_shows AS (
         -- Выбираем минимум 2 показа для каждого фильма в день
         SELECT movie_id,
                hall_id,
                show_time,
                show_time + duration + interval '30 minutes' AS end_time_with_buffer
         FROM daily_movie_counts
         WHERE movie_show_rank <= 2),
     non_overlapping_shows AS (
         -- Исключаем накладывающиеся друг на друга показы
         SELECT hall_id,
                movie_id,
                show_time
         FROM (SELECT ss.hall_id,
                      ss.movie_id,
                      ss.show_time,
                      ss.end_time_with_buffer,
                      LAG(ss.end_time_with_buffer) OVER (PARTITION BY ss.hall_id ORDER BY ss.show_time) AS prev_end_time
               FROM selected_shows ss) AS ordered_shows
         WHERE prev_end_time IS NULL
            OR show_time >= prev_end_time)
INSERT
INTO schedule (hall_id, movie_id, show_time)
SELECT hall_id,
       movie_id,
       show_time
FROM non_overlapping_shows
ORDER BY hall_id, show_time;

-- customer

INSERT INTO customer (name, email, phone)
SELECT
    -- Создаем случайные имена
    CASE
        WHEN random() < 0.5 THEN
            (ARRAY['Александр', 'Иван', 'Дмитрий', 'Сергей', 'Андрей', 'Максим', 'Алексей', 'Артём', 'Михаил', 'Никита'])[1 + floor(random() * 10)]
        ELSE
            (ARRAY['Елена', 'Анна', 'Мария', 'Ольга', 'Татьяна', 'Наталья', 'Екатерина', 'Ирина', 'Светлана', 'Юлия'])[1 + floor(random() * 10)]
        END || ' ' ||
    (ARRAY['Иванов', 'Смирнов', 'Кузнецов', 'Попов', 'Васильев', 'Петров', 'Соколов', 'Михайлов', 'Новиков', 'Морозов',
        'Волков', 'Лебедев', 'Козлов', 'Семёнов', 'Павлов', 'Макаров', 'Никитин', 'Зайцев', 'Соловьёв', 'Орлов'])[1 + floor(random() * 20)] ||
    CASE WHEN random() < 0.5 THEN 'а' ELSE '' END AS name,

    -- Уникальный email
    LOWER(random_string(8)) || '@' ||
    (ARRAY['mail.ru', 'gmail.com', 'yandex.ru', 'outlook.com', 'hotmail.com', 'list.ru', 'rambler.ru', 'protonmail.com', 'icloud.com', 'inbox.ru'])[1 + floor(random() * 10)] AS email,

    -- Телефон в формате +7XXXXXXXXXX
    '+7' ||
    (ARRAY['900', '901', '902', '903', '905', '906', '908', '909', '910', '912', '913', '914', '915', '916', '917', '918', '919', '920', '921', '922'])[1 + floor(random() * 20)] ||
    LPAD(floor(random() * 10000000)::text, 7, '0') AS phone

FROM generate_series(1, 1000);

-- price_list

INSERT INTO price_list (seat_id, schedule_id, price)
WITH all_schedule_seats AS (
    -- Получаем все сеансы и места для них
    SELECT s.id                                             AS schedule_id,
           se.id                                            AS seat_id,
           se.row_number,
           se.seat_number,
           EXTRACT(HOUR FROM s.show_time)                   AS hour_of_day,
           -- Вычисляем максимальное количество рядов для каждого зала
           MAX(se.row_number) OVER (PARTITION BY s.hall_id) AS max_row
    FROM schedule s
             JOIN
         seat se ON s.hall_id = se.hall_id)
SELECT seat_id,
       schedule_id,
       -- Базовая цена 300 рублей
       (300 +
           -- Прибавляем до 100 рублей в зависимости от времени дня (чем позже, тем дороже)
        (hour_of_day - 9) * 10 +
           -- Прибавляем до 100 рублей в зависимости от ряда (первые ряды дороже)
        (max_row - row_number + 1) * 100 / max_row)::NUMERIC(10, 2) AS price
FROM all_schedule_seats;


-- ticket

WITH available_price_list AS (
    -- Получаем все доступные билеты из прайс-листа
    SELECT id AS price_list_id
    FROM price_list
),
     random_price_list AS (
         -- Выбираем случайную половину билетов
         SELECT price_list_id
         FROM available_price_list
         ORDER BY random()
         LIMIT (SELECT COUNT(*) / 2 FROM price_list)
     ),
     random_customers AS (
         -- Выбираем случайных клиентов для каждого билета
         SELECT
             rpl.price_list_id,
             c.id AS customer_id,
             -- Генерируем случайную дату покупки в пределах последних 30 дней
             NOW() - (random() * 30 * interval '1 day') AS purchased_at
         FROM
             random_price_list rpl
                 CROSS JOIN LATERAL (
                 SELECT id
                 FROM customer
                 ORDER BY random()
                 LIMIT 1
                 ) c
     )
INSERT INTO ticket (price_list_id, customer_id, purchased_at)
SELECT
    price_list_id,
    customer_id,
    purchased_at
FROM
    random_customers;
