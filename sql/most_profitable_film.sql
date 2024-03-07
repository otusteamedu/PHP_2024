SELECT
  f.film_id,
  f.title,
  COUNT(t.ticket_id) AS tickets_sold,
  SUM(t.selling_price) AS total_revenue
FROM
  tickets AS t
  INNER JOIN sessions AS s ON s.session_id = t.session_id
  INNER JOIN films AS f ON f.film_id = s.film_id
GROUP BY
  f.film_id
ORDER BY
  tickets_sold DESC
LIMIT
  1