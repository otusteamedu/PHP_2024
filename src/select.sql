SELECT
    m.id AS movie_id,
    m.title AS movie_title,
    SUM(t.price) AS total_profit
FROM movies m
    JOIN shows s ON m.id = s.movie_id
    JOIN tickets t ON s.id = t.show_id
GROUP BY m.id
ORDER BY total_profit DESC
    LIMIT 1;