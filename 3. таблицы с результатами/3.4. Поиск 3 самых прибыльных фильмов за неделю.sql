explain analyze
WITH weekly_revenue AS (SELECT m.id,
                               m.title                  AS movie_title,
                               SUM(s.price + se.markup) AS session_revenue
                        FROM tickets t
                                 JOIN sessions s ON t.session_id = s.id
                                 JOIN movies m ON s.movie_id = m.id
                                 JOIN seats se ON t.seat_id = se.id
                        WHERE DATE(t.purchased_at) >= CURRENT_DATE - INTERVAL '1 week'
                        GROUP BY m.id)
SELECT wr.id,
       wr.movie_title,
       wr.session_revenue
FROM weekly_revenue wr
ORDER BY wr.session_revenue DESC
LIMIT 3;
