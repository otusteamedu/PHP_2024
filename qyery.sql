USE `cinema_db`;
WITH revenue
         AS (SELECT f.id,
                    f.rental_cost,
                    f.title,
                    SUM(pwp.price) AS revenue_sum
             FROM tickets t
                      JOIN cinema_db.pivot_with_prices pwp on pwp.id = t.id_pivot_with_prices
                      JOIN cinema_db.films f on f.id = pwp.film_id
             GROUP BY f.id, f.rental_cost, f.title)
SELECT r.title,
       (r.revenue_sum - r.rental_cost) AS income
FROM revenue r
ORDER BY income desc
LIMIT 1;