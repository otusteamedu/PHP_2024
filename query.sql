--1. Выбор всех фильмов на сегодня
SELECT *
FROM
    films
WHERE
    start_date <= CURRENT_DATE AND end_date >= CURRENT_DATE;

--2. Подсчёт проданных билетов за неделю
SELECT COUNT(*)
FROM
    tickets
WHERE
    DATE(purchase_time) >= CURRENT_DATE - INTERVAL '7 day';

--3. Формирование афиши (фильмы, которые показывают сегодня)
SELECT DISTINCT *
FROM films f
     JOIN sessions s ON f.film_id = s.film_id
WHERE
    DATE(s.start_time) <= CURRENT_DATE AND DATE(s.end_time) >= CURRENT_DATE;

--4. Поиск 3 самых прибыльных фильмов за неделю
SELECT f.title, SUM(t.price) AS total
FROM tickets t
     JOIN sessions s ON t.session_id = s.session_id
     JOIN films f ON s.film_id = f.film_id
WHERE DATE(t.purchase_time) >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY f.film_id
ORDER BY total DESC
LIMIT 3;

--5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT
    s.seat_row,
    s.seat_number,
    CASE
        WHEN t.ticket_id IS NULL THEN 'свободно'
        ELSE 'занято'
        END AS seat_status
FROM
    seats s
        INNER JOIN
    halls h ON s.hall_id = h.hall_id
        LEFT JOIN
    tickets t ON s.seat_id = t.seat_id
        LEFT JOIN
    sessions ses ON t.session_id = ses.session_id
WHERE
        ses.session_id = 1 -- ID сеанса
ORDER BY
    s.seat_row,
    s.seat_number;

--6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

SELECT
    MIN(price) AS min_price, MAX(price) AS max_price
FROM
    tickets
WHERE
    session_id = 1; -- ID сеанса