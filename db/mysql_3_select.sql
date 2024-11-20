with sales as (
    select film.id as film_id, sum(ticket.price) as revenue
    from film
         inner join showtime on film.id = showtime.film_id
         inner join ticket on showtime.id = ticket.showtime_id
    group by film.id
    order by revenue desc
--    limit 1
)
select film.title, sales.revenue
    from sales
    inner join film on film.id = sales.film_id
    order by sales.revenue desc
;
