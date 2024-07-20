explain analyze
SELECT m.id    AS movie_id,
       m.title AS movie_title
FROM movies m
         JOIN sessions s ON m.id = s.movie_id
WHERE DATE(s.start_time) = CURRENT_DATE;
