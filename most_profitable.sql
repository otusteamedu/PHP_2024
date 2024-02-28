select
    movies.id,
    movies."name"
from
    sales
    join tickets on sales.ticket_id = tickets.id
    join shows on tickets.show_id = shows.id
    join movies on shows.movie_id = movies.id
group by
    movies.id,
    movies."name"
order by
    sum(sales.amount) desc
limit
    1