SELECT name, sumFilm
FROM (
         SELECT films.name, SUM(orders.sum) AS sumFilm
         FROM orders
                  INNER JOIN screenings ON screenings.id = orders.screening_id
                  INNER JOIN films ON films.id = screenings.film_id
         GROUP BY films.id
     ) AS subquery
ORDER BY sumFilm DESC
LIMIT 1;