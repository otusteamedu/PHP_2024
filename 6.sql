EXPLAIN ANALYZE
SELECT MIN(price) AS min_price, MAX(price) AS max_price
FROM tickets
WHERE session_id = <specific_session_id>;
