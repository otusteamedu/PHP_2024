SELECT m.movie_id, m.title AS movie_title, SUM(t.price) AS total_revenue
FROM db.movies m
         INNER JOIN db.sessions s ON m.movie_id = s.movie_id
         INNER JOIN db.tickets t ON s.session_id = t.session_id
GROUP BY m.movie_id
ORDER BY total_revenue DESC
LIMIT 1;
