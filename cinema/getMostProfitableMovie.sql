select movies.name, sum(tickets.soldPrice) from tickets
  join shows on shows.id = tickets.showId
  join movies on shows.movieId = movies.id
  group by movies.name
  order by sum desc;
