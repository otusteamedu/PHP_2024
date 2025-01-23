SELECT m.title      AS movie_title,
       SUM(t.price) AS total_revenue
FROM ticket t
INNER JOIN session s ON t.session_id = s.id
INNER JOIN movie m ON s.movie_id = m.id
GROUP BY m.title
ORDER BY total_revenue DESC LIMIT 1;
