-- 1 Выбор всех фильмов на сегодня
------------------------------------------------------------------------------------------------------------------------
SELECT
    m.*
FROM
    movies m
WHERE
    m.release_date <= CURRENT_DATE;

-- 2 Подсчёт проданных билетов за неделю
------------------------------------------------------------------------------------------------------------------------
SELECT
    COUNT(*)
FROM
    tickets t
WHERE
    t.sold_at >= CURRENT_TIMESTAMP - '1 week'::interval AND
    t.sold_at < CURRENT_TIMESTAMP;

-- 3  Формирование афиши (фильмы, которые показывают сегодня)
------------------------------------------------------------------------------------------------------------------------
SELECT
    m.title, s.starts_at
FROM movies m
    INNER JOIN sessions s ON m.id = s.movie_id AND
      s.starts_at >= CURRENT_DATE AND
      s.starts_at < CURRENT_DATE + '1 day'::interval
ORDER BY s.starts_at;

--4 Поиск 3 самых прибыльных фильмов за неделю
------------------------------------------------------------------------------------------------------------------------
SELECT m.title, SUM(t.price) as total_price
FROM tickets t
    INNER JOIN sessions s ON t.session_id = s.id
    INNER JOIN movies m ON s.movie_id = m.id
WHERE
    t.sold_at >= CURRENT_TIMESTAMP - '1 week'::interval AND
    t.sold_at < CURRENT_TIMESTAMP
GROUP BY m.title
ORDER BY total_price DESC;

--5 Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
------------------------------------------------------------------------------------------------------------------------
SELECT
    st.row_number,
    st.seat_number,
    CASE
        WHEN t.sold_at IS NOT NULL THEN '+'
        ELSE ' '
    END AS state
FROM
    sessions s
        INNER JOIN seats st ON s.hall_id = st.hall_id AND s.id = 1
        LEFT JOIN tickets t ON st.id = t.seat_id AND t.session_id = s.id
ORDER BY
    st.row_number,
    st.seat_number;

--6 Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
------------------------------------------------------------------------------------------------------------------------
SELECT
    MAX(t.price),
    MIN(t.price)
FROM tickets t
WHERE t.session_id = 1;