SELECT
    m.title AS movie_title,
    SUM(t.price) AS total_revenue
FROM
    Tickets t
        JOIN
    Sessions s ON t.session_id = s.session_id
        JOIN
    Movies m ON s.movie_id = m.movie_id
GROUP BY
    m.title
ORDER BY
    total_revenue DESC
LIMIT 1;
