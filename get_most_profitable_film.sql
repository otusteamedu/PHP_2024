SELECT
    f.title AS film_title,
    SUM(t.price) AS total
FROM
    films f
        JOIN sessions s ON f.film_id = s.film_id
        JOIN tickets t ON t.session_id = s.session_id
GROUP BY
    f.film_id
ORDER BY
    total DESC
LIMIT
    1;