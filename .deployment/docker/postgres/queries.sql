-- 1) Все фильмы на сегодня

SELECT m.id, m.name, s.scheduled_at
FROM movie m
         JOIN session s ON m.id = s.movie_id
WHERE s.scheduled_at::date = CURRENT_DATE;

-- 2) Всего продано билетов за неделю

SELECT COUNT(ts.id)
FROM ticket_sale ts
WHERE ts.created_at BETWEEN CURRENT_DATE AND (CURRENT_DATE + '7 days'::interval);

-- 3) Афиша для фильмов на сегодня

SELECT m.id, m.name, m.description, s.scheduled_at, g.name AS genre, c.name AS country
FROM movie m
         JOIN session s ON m.id = s.movie_id
         JOIN movie_genre mg ON m.id = mg.movie_id
         JOIN genre g ON mg.genre_id = g.id
         JOIN country c ON m.country_id = c.id
WHERE s.scheduled_at::date = CURRENT_DATE;

-- 4) Три самых прибыльных фильма за неделю

SELECT m.id, m.name
FROM movie m
         JOIN session s ON m.id = s.movie_id
         JOIN ticket t ON s.id = t.session_id
         JOIN ticket_sale ts ON t.id = ts.ticket_id
WHERE ts.created_at BETWEEN CURRENT_DATE AND (CURRENT_DATE + '7 days'::interval)
GROUP BY m.id
ORDER BY SUM(ts.amount) DESC;

-- 5) Схема зала для конкретного сеанса


-- 6) Диапазон минимальной и максимальной цены за билет на конкретный сеанс

SELECT MIN(mp.price) AS min_price,
       MAX(mp.price) AS max_price
FROM session s
         JOIN movie m ON s.movie_id = m.id
         JOIN movie_price mp ON m.id = mp.movie_id
         JOIN seat st ON s.hall_id = st.hall_id AND st.type = mp.type
WHERE s.id = 10;
