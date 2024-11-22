-- Выбор всех фильмов на сегодня
SELECT *
FROM Movies
WHERE release_date = CURRENT_DATE;

-- Формирование афиши (фильмы, которые показывают сегодня)
SELECT DISTINCT Movies.*
FROM Movies
     JOIN Sessions ON Movies.id = Sessions.movie_id
WHERE DATE (Sessions.start_time) = CURRENT_DATE;

-- Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
SELECT MIN(price) AS min_price, MAX(price) AS max_price
FROM Tickets
WHERE session_id = 1; -- id сеанса


-- Сложные запросы (связи между таблицами, агрегатные функции):
-- Подсчёт проданных билетов за неделю
SELECT COUNT(*) AS tickets_sold
FROM Tickets
WHERE session_id IN (
    SELECT id
    FROM Sessions
    WHERE start_time >= CURRENT_DATE - INTERVAL '7 days'
  AND start_time < CURRENT_DATE
    );

-- Поиск 3 самых прибыльных фильмов за неделю
SELECT Movies.title, SUM(TicketSales.total_amount) AS total_revenue
FROM TicketSales
         JOIN Tickets ON TicketSales.ticket_id = Tickets.id
         JOIN Sessions ON Tickets.session_id = Sessions.id
         JOIN Movies ON Sessions.movie_id = Movies.id
WHERE TicketSales.sale_time >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY Movies.id
ORDER BY total_revenue DESC
    LIMIT 3;

-- Сформировать схему зала и показать свободные/занятые места на конкретный сеанс
SELECT
    Seats.row,
    Seats.seat_number,
    CASE
        WHEN Tickets.id IS NOT NULL THEN 'Занято'
        ELSE 'Свободно'
        END AS seat_status
FROM Seats
         LEFT JOIN Tickets ON Seats.id = Tickets.seat_id AND Tickets.session_id = <идентификатор сеанса>
WHERE Seats.hall_id = (
    SELECT hall_id
    FROM Sessions
    WHERE id = <идентификатор сеанса>
    );
