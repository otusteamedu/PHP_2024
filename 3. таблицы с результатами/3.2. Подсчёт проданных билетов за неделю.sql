explain analyze
SELECT count(*) AS tickets_sold
FROM tickets t
WHERE DATE(t.purchased_at) >= CURRENT_DATE - INTERVAL '1 week';
