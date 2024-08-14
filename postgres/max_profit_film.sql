SELECT film_name
FROM (
  SELECT film.name AS film_name, SUM(ticket.price) AS price_sum
  FROM film, session, ticket 
  WHERE ticket.session_id = session.id 
  AND session.film_id = film.id
  GROUP BY film.name
  )
AS profit
ORDER BY profit.price_sum DESC LIMIT 1;
