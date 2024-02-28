SELECT films.name, SUM(tickets.price) AS total FROM films
LEFT JOIN movie_sessions AS ms ON ms.film_id = films.id
LEFT JOIN tickets ON tickets.session_id = ms.id
WHERE tickets.sold = true
GROUP BY films.id
ORDER BY total DESC
LIMIT 1