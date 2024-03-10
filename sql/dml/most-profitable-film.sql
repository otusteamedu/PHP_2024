SELECT m.id, name, SUM(amount)
FROM movies m
    JOIN moviesSessions ms ON m.id = ms.movie_id
    JOIN tickets t ON t.session_id = ms.id
GROUP BY m.id, name
ORDER BY sum DESC LIMIT 1;