select movies.title, sum(tickets.total_price) as total_sales
from tickets
         left join shows on shows.id = tickets.show_id
         left join movies on movies.id = shows.movie_id
group by movies.title
order by total_sales desc limit 1;
