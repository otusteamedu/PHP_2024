-- Топ-3 продаваемых (в денежном измерении) жанра
SELECT genre.name AS genre_name, SUM(session.price) AS profit_sum
FROM ticket
LEFT JOIN session
    ON session.id = ticket.session_id
LEFT JOIN movie
    ON movie.id = session.movie_id
INNER JOIN movie_genre
    ON movie_genre.movie_id = movie.id
LEFT JOIN genre
    ON genre.id = movie_genre.genre_id
GROUP BY genre.name
ORDER BY profit_sum DESC
LIMIT 3;