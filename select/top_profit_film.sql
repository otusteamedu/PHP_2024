-- Самый продаваемый фильм (в денежном измерении)
SELECT SUM(session.price) AS profit_sum, movie.name AS movie_name
FROM ticket
LEFT JOIN session
    ON session.id = ticket.session_id
LEFT JOIN movie
    ON movie.id = session.movie_id
GROUP BY movie.name
ORDER BY profit_sum DESC
LIMIT 1;