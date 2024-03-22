SELECT movies.title, SUM(price) as total_price
FROM tickets
    INNER JOIN sessions ON tickets.session_id = sessions.id
    INNER JOIN movies ON sessions.movie_id = movies.id
WHERE tickets.is_sold = TRUE
GROUP BY movies.title
ORDER BY total_price DESC
LIMIT 1;
