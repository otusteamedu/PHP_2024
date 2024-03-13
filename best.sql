SELECT movie.id, movie.title, SUM(ticket.price) AS price
FROM db.movies as movie
         INNER JOIN db.sessions as session ON movie.id = session.movie_id
         INNER JOIN db.tickets ticket ON session.id = ticket.session_id
GROUP BY movie.id
ORDER BY price DESC
LIMIT 1;