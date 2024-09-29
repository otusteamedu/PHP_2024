SELECT movie.name as Name
FROM ticket
	JOIN session ON ticket.session_id = session.id
	JOIN movie ON session.movie_id = movie.id
	JOIN seat ON ticket.seat_id = seat.id
	JOIN seat_type ON seat.seat_type_id = seat_type.id
	JOIN price ON price.seat_type_id = seat_type.id AND price.session_id = session.id
WHERE ticket.is_sold IS TRUE
GROUP BY
	movie.name
ORDER BY
	sum(price.value) DESC
LIMIT
	1