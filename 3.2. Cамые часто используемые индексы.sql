/**
    Запрос
 */
SELECT indexrelname AS index_name,
       relname      AS table_name,
       idx_scan     AS usage_count
FROM pg_stat_user_indexes
ORDER BY idx_scan DESC
LIMIT 5;

/**
    Таблица с результатами ~ 100.000 данных (до оптимизации)

    +--------------+----------+-----------+
    |index_name    |table_name|usage_count|
    +--------------+----------+-----------+
    |halls_pkey    |halls     |478968     |
    |movies_pkey   |movies    |190024     |
    |sessions_pkey |sessions  |154239     |
    |seats_pkey    |seats     |154234     |
    |customers_pkey|customers |154216     |
    +--------------+----------+-----------+
 */

/**
   Таблица с результатами ~ 100.000 данных (после оптимизации)
 */
