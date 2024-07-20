explain analyze
SELECT m.id         AS movie_id,
       m.title      AS movie_title,
       g.name       AS genre_name,
       s.start_time AS session_start_time,
       c.name       AS cinema_name
FROM movies m
         JOIN sessions s ON m.id = s.movie_id
         JOIN halls h ON s.hall_id = h.id
         JOIN cinemas c ON h.cinema_id = c.id
         JOIN genres g ON m.genre_id = g.id
WHERE DATE (s.start_time) = CURRENT_DATE;
