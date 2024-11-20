SELECT m.id, m.title AS movie_title, SUM(t.price) AS total_revenue
FROM db.movies m
         INNER JOIN db.sessions s ON m.id = s.movie_id
         INNER JOIN db.tickets t ON s.id = t.session_id
GROUP BY m.id
ORDER BY total_revenue DESC
LIMIT 1;
