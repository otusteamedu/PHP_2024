\c  cinema_db
WITH revenue AS (
    SELECT
        f.id,
        f.rental_cost,
        f.title,
        SUM(CASE WHEN t.real_price IS NULL THEN pwp.base_price ELSE t.real_price END) AS revenue_sum
    FROM
        tickets t
            JOIN
        pivot_with_base_prices pwp ON pwp.id = t.id_pivot_with_base_prices
            JOIN
        films f ON f.id = pwp.film_id
    GROUP BY
        f.id, f.rental_cost, f.title
)
SELECT
    r.title,
    (r.revenue_sum - r.rental_cost) AS income
FROM
    revenue r
ORDER BY
    income DESC
LIMIT 1;