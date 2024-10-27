
SET profiling = 1;
ANALYZE
SELECT f.name, s.session_date
FROM films f
JOIN sessions s ON f.id = s.film_id
WHERE s.session_date = CURRENT_DATE;
SHOW PROFILES;
-- для 10 000
-- время выполнения без индекса 40.74051108
-- время выполнения с индексом 0.00036262


-- для 1000 000
-- время выполнения без индекса 10.79665050
-- время выполнения с индексом 0.00042943