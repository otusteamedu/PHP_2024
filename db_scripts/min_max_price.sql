-- EXPLAIN (ANALYZE, BUFFERS)
SELECT MIN(p.value) AS min_price, MAX(p.value) AS max_price
FROM price p
WHERE p.session_id = :session_id;