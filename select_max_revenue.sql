SELECT movies.name       AS movie_name,
       SUM(prices.price) AS revenue
FROM tickets
         JOIN prices ON tickets.ticket_id = prices.id
         JOIN sessions ON prices.session_id = sessions.id
         JOIN movies ON sessions.movie_id = movies.id
GROUP BY movies.name
ORDER BY revenue DESC LIMIT 1;
