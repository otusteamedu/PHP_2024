SELECT id, title, sum_price FROM (
    SELECT m.id as id, m.title, sum(pp.price) as sum_price FROM ticket as t
    INNER JOIN price_place as pp
    ON t.price_place_id = pp.id
    INNER JOIN movie_session as ms
    ON pp.movie_session_id = ms.id
    INNER JOIN movie as m
    ON ms.movie_id = m.id
    GROUP BY m.id
) AS aggregated_prices
ORDER BY sum_price DESC
LIMIT 1;