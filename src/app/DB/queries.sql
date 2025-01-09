--1. Выбор всех фильмов на сегодня
SELECT *
FROM shows
WHERE start::date = CURRENT_DATE;

-- 2. Подсчёт проданных билетов за неделю
SELECT count(*)
FROM purchase_tickets pt
         JOIN tickets t ON pt.ticket_id = t.id
         JOIN shows s ON t.show_id = s.id
WHERE s.start::date >= CURRENT_DATE - INTERVAL '7 days'
  AND s.start::date < CURRENT_DATE;

-- 3. Формирование афиши (фильмы, которые показывают сегодня)
SELECT m.title, m.genre, s.start, h.title
FROM shows s
         JOIN movies m ON s.movie_id = m.id
         JOIN cinema_halls h ON s.cinema_hall_id = h.id
WHERE s.start::date = CURRENT_DATE;

-- 4. Поиск 3 самых прибыльных фильма за неделю
SELECT m.title, sum(t.price) AS total_price
FROM purchase_tickets pt
         JOIN tickets t ON pt.ticket_id = t.id
         JOIN shows s ON t.show_id = s.id
         JOIN movies m ON s.movie_id = m.id
WHERE s.start::date >= CURRENT_DATE - INTERVAL '7 days'
  AND s.start::date < CURRENT_DATE
GROUP BY m.id
ORDER BY total_price DESC
LIMIT 3;

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT t.row, t.seat, t.price, t.available
FROM tickets t
         JOIN shows s ON t.show_id = s.id
         JOIN movies m ON m.id = s.movie_id
WHERE s.id = 1;

-- 6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
SELECT MIN(t.price) AS min_price,
       MAX(t.price) AS man_price
FROM tickets t
         JOIN shows s ON t.show_id = s.id
WHERE s.id = 1;