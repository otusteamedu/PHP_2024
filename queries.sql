-- 1. Выбор всех фильмов на сегодня
SELECT m.title
FROM movies m
         JOIN sessions s ON s.movie_id = m.id
WHERE s.date = CURRENT_DATE;


-- 2. Подсчёт проданных билетов за неделю
SELECT COUNT(*)
FROM tickets t
         JOIN sessions s ON t.session_id = s.id
WHERE s.date >= CURRENT_DATE - INTERVAL '7 days'
  AND s.date < CURRENT_DATE;


-- 3. Формирование афиши (фильмы, которые показывают сегодня)
SELECT m.title,
       s.start_time
FROM sessions s
         JOIN movies m ON s.movie_id = m.id
WHERE date = CURRENT_DATE;

-- 4. Поиск 3 самых прибыльных фильма за неделю
SELECT m.id,
       m.title,
       SUM(t.price) AS total_price
FROM movies m
         JOIN sessions s ON m.id = s.movie_id
         JOIN tickets t ON t.session_id = s.id
         JOIN order_tickets ot ON ot.ticket_id = t.id
WHERE s.date >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY m.id
ORDER BY total_price DESC
LIMIT 3;

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT m.title AS "Фильм",
       s.date AS "Дата",
       s.start_time AS "Начало",
       h."name" AS "Зал",
       p."row" AS "Ряд",
       p."seat" AS "Место",
       CASE
           WHEN EXISTS(SELECT * FROM order_tickets WHERE t.id = order_tickets.ticket_id)  THEN 'Занято'
           ELSE 'Свободно'
           END AS seat_status
FROM halls h
         JOIN sessions s ON h.id = s.hall_id
         JOIN tickets t ON s.id = t.session_id
         JOIN movies m ON m.id = s.movie_id
         JOIN places p ON p.id = t.place_id
WHERE s.id = 1; -- выбранный сеанс

-- 6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
SELECT MIN(price) AS "Мин. цена",
       MAX(price) AS "Макс. цена"
FROM tickets t
         JOIN sessions s ON s.id = t.session_id
WHERE s.id = 1; -- выбранный сеанс