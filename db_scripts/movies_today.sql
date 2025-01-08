-- EXPLAIN (ANALYZE, BUFFERS)
SELECT DISTINCT m.id, m.name
FROM movie m
JOIN session s ON m.id = s.movie_id
WHERE s.start >= CURRENT_DATE AND s.start < CURRENT_DATE + INTERVAL '1 day';
