EXPLAIN ANALYZE
SELECT f.name, s.session_date
FROM films f
JOIN sessions s ON f.id = s.film_id
WHERE s.session_date = CURRENT_DATE;
