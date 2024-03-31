--Выбор всех фильмов на сегодня
EXPLAIN
ANALYZE
SELECT m.name,
	ms.scheduled_at::date
FROM movies_sessions ms
JOIN movies m
	ON m.id = ms.movie_id
WHERE ms.scheduled_at::date = now()::date
ORDER BY scheduled_at;
