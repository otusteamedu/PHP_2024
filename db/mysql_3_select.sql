with revenue as (
    select film.id, sum(ticket.price) as total_revenue
    from film
             inner join showtime on film.id = showtime.film_id
             inner join ticket on showtime.id = ticket.showtime_id
             inner join ticket_purchase on ticket_purchase.ticket_id = ticket.id
    group by film.id
    order by total_revenue desc
    limit 1
)
select film.title, revenue.total_revenue
    from film
    inner join revenue on film.id = revenue.id
;
