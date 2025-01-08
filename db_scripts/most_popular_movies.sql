-- EXPLAIN (ANALYZE, BUFFERS)
SELECT m.id, m.name, SUM(t.price * (1 - t.discount_percent / 100)) AS revenue
FROM ticket t
JOIN session s ON t.session_id = s.id
JOIN movie m ON s.movie_id = m.id
WHERE t.is_sold = TRUE 
    AND s.start BETWEEN CURRENT_DATE - INTERVAL '7 days' AND CURRENT_DATE
GROUP BY m.id, m.name
ORDER BY revenue DESC
LIMIT 3;
