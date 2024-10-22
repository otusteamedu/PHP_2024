EXPLAIN ANALYZE
SELECT f.name, SUM(t.price) AS total_revenue
FROM films f
JOIN sessions s ON f.id = s.film_id
JOIN tickets t ON s.id = t.session_id
WHERE t.sold_at >= NOW() - INTERVAL '1 week'
GROUP BY f.name
ORDER BY total_revenue DESC
LIMIT 3;
