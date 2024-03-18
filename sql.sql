SELECT m.title, SUM(t.price / 100) AS summ
FROM movies as m
         INNER JOIN movies_sessions as ms ON ms.movie_id = m.id
         INNER JOIN tickets as t ON t.session_id = ms.id
GROUP BY m.id
ORDER BY summ DESC LIMIT 1;
