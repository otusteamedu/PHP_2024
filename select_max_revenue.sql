SELECT movies.name AS movie_name,
       SUM(tickets.price) AS revenue
FROM tickets_sold ts
JOIN tickets ON ts.ticket_id = tickets.id
JOIN sessions ON tickets.session_id = sessions.id
JOIN movies ON sessions.movie_id = movies.id
GROUP BY movies.name
ORDER BY revenue DESC LIMIT 1;