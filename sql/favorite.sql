SELECT f.name, SUM(t.price) AS total
FROM films f
         LEFT JOIN films_sessions s ON s.film_id = f.id
         LEFT JOIN tickets t ON t.session_id = s.id
GROUP BY f.id
ORDER BY total DESC
LIMIT 1;
