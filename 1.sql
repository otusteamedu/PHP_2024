SET profiling = 1;
 ANALYZE
SELECT f.name, s.session_date
FROM films f
JOIN sessions s ON f.id = s.film_id
WHERE s.session_date = CURRENT_DATE;


SHOW PROFILES;
-- для 10 000
-- время выполнения без индекса 39.35788988
-- время выполнения с индексом 0.00276958


-- для 1000 000
-- время выполнения без индекса 137.22241131
-- время выполнения с индексом 0.00032869