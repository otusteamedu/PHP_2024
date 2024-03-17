SELECT m.title, SUM(pc.price) AS summ
FROM movies as m
         INNER JOIN movies_sessions as ms ON ms.movie_id = m.id
         INNER JOIN tickets as t ON t.session_id = ms.id
         INNER JOIN price_category as pc ON pc.id = t.price_category_id
GROUP BY m.id
ORDER BY summ DESC LIMIT 1;

//VIA CTE
WITH cte AS (
SELECT SUM(pc.price) AS summ, ms.movie_id
FROM price_category as pc
INNER JOIN tickets as t ON pc.id = t.price_category_id
INNER JOIN movies_sessions as ms ON t.session_id = ms.id
GROUP BY ms.id)
SELECT m.title, MAX(cte.summ)
FROM movies as m
         INNER JOIN cte ON cte.movie_id = m.id
