-- Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN
ANALYZE
SELECT m.name
FROM tickets t
JOIN movies_sessions ms ON t.session_id = ms.id
JOIN movies m ON m.id = ms.movie_id
WHERE ms.scheduled_at::date = now()::date
ORDER BY ms.scheduled_at;