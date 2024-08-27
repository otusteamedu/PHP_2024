SELECT  f.name, SUM(p.price) AS total_sum
    FROM tickets t
    LEFT JOIN prices p on p.id = t.price_id
    LEFT JOIN sessions_films sf on sf.id = p.session_id
    LEFT JOIN films f on f.id = sf.film_id
GROUP BY f.id
ORDER BY total_sum DESC
    LIMIT 1
