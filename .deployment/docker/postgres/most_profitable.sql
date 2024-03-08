SELECT
    movie.id,
    movie."name"
FROM
    ticket_sale
        INNER JOIN ticket ON ticket_sale.ticket_id = ticket.id
        INNER JOIN session ON ticket.session_id = session.id
        INNER JOIN movie ON session.movie_id = movie.id
GROUP BY
    movie.id,
    movie."name"
ORDER BY
    SUM(ticket_sale.amount) DESC
LIMIT 1;
