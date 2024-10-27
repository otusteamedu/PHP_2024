SET profiling = 1;
ANALYZE
SELECT f.name, SUM(t.price) AS total_revenue
FROM films f
JOIN sessions s ON f.id = s.film_id
JOIN tickets t ON s.id = t.session_id
WHERE t.sold_at >= NOW() - INTERVAL 1 WEEK
GROUP BY f.name
ORDER BY total_revenue DESC
LIMIT 3;

SHOW PROFILES;
-- для 10 000
-- время выполнения без индекса 0.00051708
-- время выполнения с индексом  0.00036059


-- для 1000 000
-- время выполнения без индекса 0.00218172
-- время выполнения с индексом 0.00045799