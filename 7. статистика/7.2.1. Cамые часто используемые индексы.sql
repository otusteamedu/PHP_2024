SELECT indexrelname AS index_name,
       relname      AS table_name,
       idx_scan     AS usage_count
FROM pg_stat_user_indexes
ORDER BY idx_scan DESC
LIMIT 5;
