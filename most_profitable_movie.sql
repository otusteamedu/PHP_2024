SELECT movies.id, movies.title, SUM(order_tickets.price)
FROM movies
         INNER JOIN sessions ON sessions.movie_id = movies.id
         INNER JOIN tickets ON tickets.session_id = sessions.id
         INNER JOIN order_tickets ON order_tickets.ticket_id = tickets.id
GROUP BY movies.id, movies.title
ORDER BY SUM(order_tickets.price) DESC
LIMIT 1