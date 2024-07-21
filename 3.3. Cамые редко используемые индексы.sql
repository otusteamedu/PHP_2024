/**
    Запрос
 */
SELECT indexrelname AS index_name,
       relname      AS table_name,
       idx_scan     AS usage_count
FROM pg_stat_user_indexes
ORDER BY idx_scan
LIMIT 5;

/**
    Таблица с результатами ~ 100.000 данных (до оптимизации)
 */

/**
   Таблица с результатами ~ 100.000 данных (после оптимизации)
 */
