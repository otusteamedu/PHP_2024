select movie.title, sum(show.price_per_ticket) as profit
from ticket
         join seat on ticket.seat_id = seat.id
         join show on ticket.show_id = show.id
         join movie on show.movie_id = movie.id
group by movie.id
order by profit DESC
limit 1