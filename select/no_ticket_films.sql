-- Фильмы на которые не было куплено ни одного билета
SELECT name
FROM movie
WHERE id NOT IN (
    SELECT DISTINCT movie.id
    FROM movie
    INNER JOIN session
        ON session.movie_id = movie.id
    INNER JOIN ticket
        ON ticket.session_id = session.id
    );



