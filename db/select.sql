SELECT movie.id, movie.name, sum(ticket.price) as total
FROM movie
         JOIN movie_showing showing on movie.id = showing.movie_id
         JOIN movie_showing_schedule shedule ON showing.id = shedule.movie_showing_id
         JOIN ticket ON shedule.id = ticket.movie_showing_schedule_id
GROUP BY movie.id, movie.name
ORDER BY total DESC
LIMIT 1
