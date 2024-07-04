SELECT films.name, sum(order_tickets.price) as profit from order_tickets
join tickets on order_tickets.ticket_id = tickets.id
join cinema_shows on tickets.cinema_show_id = cinema_shows.id
join films on cinema_shows.film_id = films.id
group by films.id
order by profit DESC LIMIT 1