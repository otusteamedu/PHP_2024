-- 3 "ПРОСТЫХ" ЗАПРОСА:
--1. Выбор всех фильмов на сегодня
SELECT * FROM sessions 
    WHERE date = CURRENT_DATE;

-- 2. Подсчёт проданных билетов за неделю
SELECT count(*)
    FROM tickets t 
        JOIN sessions s ON t.session_id = s.id 
    WHERE s.date >= CURRENT_DATE - INTERVAL '7 days' AND s.date < CURRENT_DATE;

-- 3. Формирование афиши (фильмы, которые показывают сегодня)
SELECT m.name, s.begin_time, s.duration
    FROM sessions s 
        JOIN movies m ON s.movie_id = m.id 
    WHERE date = CURRENT_DATE;


-- 3 "СЛОЖНЫХ" ЗАПРОСА:
-- 4. Поиск 3 самых прибыльных фильма за неделю
SELECT m.name, sum(t.price) AS total_price
    FROM movies m 
        JOIN sessions s ON m.id = s.movie_id 
        JOIN tickets t ON t.session_id = s.id 
    WHERE s.date >= CURRENT_DATE - INTERVAL '7 days' AND t.is_sold 
    GROUP BY m.id 
    ORDER BY total_price DESC 
        LIMIT 3;

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT h.number AS hall_number,
       m.name AS movie_name,
       t.seat_number AS seat_number,
       t.price AS price,
       CASE
            WHEN t.is_sold THEN 'Занято'
            ELSE 'Свободно'
            END AS seat_status
    FROM halls h
        JOIN sessions s ON h.id = s.hall_id
        JOIN tickets t ON s.id = t.session_id
        JOIN movies m ON m.id = s.movie_id
    WHERE s.id = <sessionID>;

-- 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
SELECT MIN(price) AS min_price,
       MAX(price) AS man_price
    FROM sessions s
        JOIN tickets t ON s.id = t.session_id
    WHERE s.id = <sessionID>;