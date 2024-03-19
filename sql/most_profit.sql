SELECT
  m.movie_id,
  m.name,
  COUNT(t.id) AS tickets_sold,
  SUM(t.selling_price) AS revenue
FROM
  ticket AS t
  INNER JOIN session AS s ON s.id = t.session_id
  INNER JOIN movie AS m ON m.movie_id = s.movie_id
GROUP BY
  m.movie_id
ORDER BY
  revenue DESC
LIMIT
 1