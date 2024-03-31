-- Подсчёт проданных билетов за неделю
EXPLAIN
ANALYZE
SELECT count(*)
FROM tickets t
JOIN movies_sessions ms ON t.session_id = ms.id
WHERE ms.scheduled_at::date >= now()::date - INTERVAL '7 days'
AND ms.scheduled_at::date <= now()::date;
