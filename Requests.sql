-- 1. Выбор всех фильмов на сегодня

SELECT DISTINCT name Фильм FROM films JOIN sessions s on films.id = s.film_id;

-- 2. Подсчет проданных билетов за неделю

SELECT SUM(amount) FROM tickets WHERE date between CURRENT_DATE - INTERVAL '7 days' AND CURRENT_DATE;

-- 3. Формирование афиши (фильмы, которые показывают сегодня)

SELECT name Фильм,s.timebegin Время_начала FROM films JOIN sessions s on films.id = s.film_id;

-- 4. Поиск 3 самых прибыльных фильмов за неделю

SELECT f.name, SUM(amount) FROM tickets
    JOIN sessions s on tickets.session_id = s.id
    JOIN films f on f.id = s.film_id
WHERE date between CURRENT_DATE - INTERVAL '7 days' AND CURRENT_DATE
GROUP BY f.name ORDER BY sum DESC LIMIT 3
;

-- 1. Выбор всех фильмов на сегодня
-- 1. Выбор всех фильмов на сегодня