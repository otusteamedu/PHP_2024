EXPLAIN ANALYZE
SELECT COUNT(*) AS tickets_sold
FROM tickets
WHERE sold_at >= NOW() - INTERVAL '1 week';
