-- EXPLAIN (ANALYZE, BUFFERS)
SELECT DISTINCT m.id, m.name, m.duration
FROM movie m
JOIN session s ON m.id = s.movie_id
WHERE DATE(s.start) = CURRENT_DATE;

/*улучшенный запрос без DATE, чтобы использовались индексы*/
SELECT DISTINCT m.id, m.name, m.duration
FROM movie m
JOIN session s ON m.id = s.movie_id
WHERE s.start >= CURRENT_DATE AND s.start < CURRENT_DATE + INTERVAL '1 day';