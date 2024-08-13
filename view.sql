CREATE VIEW MostProfitableMovie AS
SELECT m.title, SUM(t.price) AS total_revenue
FROM movies m
         JOIN sessions s ON m.id = s.movie_id
         JOIN tickets t ON s.id = t.session_id
GROUP BY m.title
ORDER BY total_revenue DESC
LIMIT 1;