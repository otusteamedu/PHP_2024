SELECT movies.name, SUM(tickets.price) AS total_sum
FROM movies
         INNER JOIN sessions ON movies.id = sessions.movie_id
         INNER JOIN prices ON sessions.id = prices.session_id
         INNER JOIN tickets ON prices.id = tickets.price_id
GROUP BY movies.id
ORDER BY total_sum DESC
LIMIT 1;