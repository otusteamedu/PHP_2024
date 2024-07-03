SELECT SUM(t.price) AS profit, m.title FROM tickets as t
    LEFT JOIN sessions s ON s.id = t.session_id
    LEFT JOIN movies m ON m.id = s.movie_id
WHERE t.deleted_at IS NULL
  AND s.deleted_at IS NULL
  AND m.deleted_at IS NULL
  AND t.id IN
      (SELECT o.ticket_id FROM orders AS o WHERE o.status_id = 2 AND o.deleted_at IS NULL)
GROUP BY m.title
ORDER BY profit DESC
LIMIT 1;