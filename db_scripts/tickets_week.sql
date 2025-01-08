-- EXPLAIN (ANALYZE, BUFFERS)
SELECT COUNT(*) AS sold_tickets
FROM ticket
WHERE is_sold = TRUE 
    AND session_id IN (
        SELECT id 
        FROM session 
        WHERE start BETWEEN CURRENT_DATE - INTERVAL '7 days' AND CURRENT_DATE
);