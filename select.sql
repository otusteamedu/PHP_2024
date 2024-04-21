SELECT id, title, sum_with_discount, sum_without_discount FROM (
    SELECT m.id as id, m.title, sum(t.actual_price) as sum_with_discount, sum(pp.price) as sum_without_discount FROM tickets as t
    INNER JOIN price_place as pp
    ON t.price_place_id = pp.id
    INNER JOIN movie_session as ms
    ON pp.movie_session_id = ms.id
    INNER JOIN movie as m
    ON ms.movie_id = m.id
    GROUP BY m.id
) AS aggregated_prices
ORDER BY sum_with_discount DESC
LIMIT 1;