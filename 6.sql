SET profiling = 1;
 ANALYZE
SELECT MIN(price) AS min_price, MAX(price) AS max_price
FROM tickets
WHERE session_id = 1;

SHOW PROFILES;
-- для 10 000
-- время выполнения без индекса 0.00126271
-- время выполнения с индексом  0.00030886


-- для 1000 000
-- время выполнения без индекса 0.00054043
-- время выполнения с индексом 0.00190827