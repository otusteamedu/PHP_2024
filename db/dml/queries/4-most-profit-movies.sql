-- Поиск 3 самых прибыльных фильмов
EXPLAIN
ANALYZE
SELECT m.id, name, SUM(price)
FROM movies m
    JOIN movies_sessions ms ON m.id = ms.movie_id
    JOIN tickets t ON t.session_id = ms.id
GROUP BY m.id, name
ORDER BY sum DESC LIMIT 3;
