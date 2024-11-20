SELECT m.id, m.title, SUM(t.price) AS total_revenue
FROM ticket t
JOIN showtime s ON t.showtime_id = s.id
JOIN movie m ON s.movie_id = m.id
GROUP BY m.id, m.title
ORDER BY total_revenue DESC LIMIT 1;
