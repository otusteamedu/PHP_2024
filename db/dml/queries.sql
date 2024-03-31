--Выбор всех фильмов на сегодня
SELECT m.name,
	ms.scheduled_at::date
FROM movies_sessions ms
JOIN movies m
	ON m.id = ms.movie_id
WHERE ms.scheduled_at::date = now()::date
ORDER BY scheduled_at;

-- Подсчёт проданных билетов за неделю
SELECT count(*)
FROM tickets t
JOIN movies_sessions ms ON t.session_id = ms.id
WHERE ms.scheduled_at::date >= now()::date - INTERVAL '7 days'
AND ms.scheduled_at::date <= now()::date;

-- Формирование афиши (фильмы, которые показывают сегодня)
SELECT m.name
FROM tickets t
JOIN movies_sessions ms ON t.session_id = ms.id
JOIN movies m ON m.id = ms.movie_id
WHERE ms.scheduled_at::date = now()::date
ORDER BY ms.scheduled_at;

-- Поиск 3 самых прибыльных фильмов за неделю
SELECT m.id, name, SUM(price)
FROM movies m
    JOIN movies_sessions ms ON m.id = ms.movie_id
    JOIN tickets t ON t.session_id = ms.id
GROUP BY m.id, name
ORDER BY sum DESC LIMIT 3;

-- План выполнения для 10000 строк, без индексов

-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT *
FROM
(
	SELECT *
	FROM seats s
	WHERE s.hall_id = (
		SELECT hall_id
		FROM movies_sessions ms
		WHERE ms.id = 5
	)
	ORDER BY s.row_number, s.seat_number
) as hall_places
LEFT JOIN (
	SELECT seat_id
	FROM seats s
	JOIN tickets t ON s.id = t.seat_id AND t.session_id = 5
	WHERE s.hall_id = (
		SELECT hall_id
		FROM movies_sessions ms
		WHERE ms.id = 5
	)
	ORDER BY t.session_id
) as sold_places ON hall_places.id = sold_places.seat_id;
-- План выполнения для 10000 строк, без индексов

-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
SELECT
	min_price.session_id,
	min_price.min,
	max_price.max
FROM (
	SELECT t.session_id, max(price)
	FROM tickets t
	WHERE t.session_id = 2
	GROUP BY t.session_id
) as max_price
JOIN (
	SELECT t.session_id, min(price)
	FROM tickets t
	WHERE t.session_id = 2
	GROUP BY t.session_id
) as min_price ON max_price.session_id = min_price.session_id;

-- План выполнения для 10000 строк, без индексов
--"Nested Loop  (cost=0.00..399.58 rows=9 width=24)"
--"  Join Filter: (t.session_id = t_1.session_id)"
--"  ->  GroupAggregate  (cost=0.00..199.14 rows=9 width=16)"
--"        Group Key: t.session_id"
--"        ->  Seq Scan on tickets t  (cost=0.00..199.00 rows=9 width=16)"
--"              Filter: (session_id = 2)"
--"  ->  Materialize  (cost=0.00..199.27 rows=9 width=16)"
--"        ->  GroupAggregate  (cost=0.00..199.14 rows=9 width=16)"
--"              Group Key: t_1.session_id"
--"              ->  Seq Scan on tickets t_1  (cost=0.00..199.00 rows=9 width=16)"
--"                    Filter: (session_id = 2)"