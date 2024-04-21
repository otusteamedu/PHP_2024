-- 1. Выбор всех фильмов на сегодня

SELECT DISTINCT name FROM films JOIN sessions s on films.id = s.film_id;

-- 2. Подсчет проданных билетов за неделю

SELECT SUM(amount) FROM tickets WHERE date between CURRENT_DATE - INTERVAL '7 days' AND CURRENT_DATE;

-- 1. Выбор всех фильмов на сегодня
-- 1. Выбор всех фильмов на сегодня
-- 1. Выбор всех фильмов на сегодня
-- 1. Выбор всех фильмов на сегодня