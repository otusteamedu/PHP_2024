SELECT m.id          AS movie_id,
       m.title       AS movie_title,
       SUM(ms.price) AS total_revenue
FROM tickets t
         JOIN
     sessions s ON t.session_id = s.id
         JOIN
     movie_sessions ms ON s.id = ms.session_id
         JOIN
     movies m ON ms.movie_id = m.id
GROUP BY m.id, m.title
ORDER BY total_revenue DESC LIMIT 1;
