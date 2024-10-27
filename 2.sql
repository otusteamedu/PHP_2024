SET profiling = 1;
ANALYZE
SELECT COUNT(*) AS tickets_sold
FROM tickets
WHERE sold_at >= NOW() - INTERVAL 1 WEEK;
SHOW PROFILES;
-- для 10 000
-- время выполнения без индекса 0.00115569
-- время выполнения с индексом  0.00030325


-- для 1000 000
-- время выполнения без индекса 0.00113378
-- время выполнения с индексом 0.00177166