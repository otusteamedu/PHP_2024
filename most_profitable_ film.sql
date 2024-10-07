SELECT movie.name as Name
FROM ticket
JOIN session ON ticket.session_id = session.id
JOIN movie ON session.movie_id = movie.id
WHERE ticket.is_sold IS TRUE
GROUP BY movie.name
ORDER BY sum((ticket.price - (ticket.price / 100 * ticket.discount_percent))) DESC
LIMIT 1;
	
