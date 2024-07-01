SELECT m.title,
       SUM(t.price) AS total_revenue
FROM movies m
         JOIN
     movie_sessions ms ON m.id = ms.movie_id
         JOIN
     sessions s ON ms.session_id = s.id
         JOIN
     tickets t ON s.id = t.session_id
GROUP BY m.title
ORDER BY total_revenue DESC LIMIT 1;