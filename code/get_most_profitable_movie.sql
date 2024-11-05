SELECT m.title, SUM(tp.price) AS total_revenue
FROM movies m
         INNER JOIN sessions s ON m.id = s.movie_id
         INNER JOIN ticket_prices tp ON s.id = tp.session_id
         INNER JOIN tickets t ON tp.id = t.ticket_price_id
GROUP BY m.id
ORDER BY total_revenue DESC
    LIMIT 1;
