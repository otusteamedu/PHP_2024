SELECT movie.movie_id, movie.title, SUM(ticket.price) AS price
FROM db.movies as movie
         INNER JOIN db.sessions as session ON movie.movie_id = session.movie_id
         INNER JOIN db.tickets ticket ON session.session_id = ticket.session_id
GROUP BY movie.movie_id
ORDER BY price DESC
LIMIT 1;