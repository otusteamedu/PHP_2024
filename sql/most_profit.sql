SELECT films.name, sum(tickets.price) as profit from tickets
join cinema_show_seat on tickets.cinema_show_seat_id = cinema_show_seat.id
join cinema_shows on cinema_show_seat.cinema_show_id = cinema_shows.id
join films on cinema_shows.film_id = films.id
group by films.id
order by profit DESC LIMIT 1