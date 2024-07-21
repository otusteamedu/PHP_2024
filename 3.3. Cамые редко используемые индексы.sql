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

    +------------------------------+----------+-----------+
    |index_name                    |table_name|usage_count|
    +------------------------------+----------+-----------+
    |tickets_pkey                  |tickets   |0          |
    |customers_email_key           |customers |0          |
    |tickets_session_id_seat_id_key|tickets   |18         |
    |genres_pkey                   |genres    |1036       |
    |cinemas_pkey                  |cinemas   |41033      |
    +------------------------------+----------+-----------+
 */

/**
    Таблица с результатами ~ 100.000 данных (после оптимизации)

    +--------------------------+----------+-----------+
    |index_name                |table_name|usage_count|
    +--------------------------+----------+-----------+
    |tickets_pkey              |tickets   |0          |
    |customers_email_key       |customers |0          |
    |idx_sessions_start_time   |sessions  |2          |
    |idx_tickets_purchased_date|tickets   |9          |
    |idx_sessions_start_date   |sessions  |15         |
    +--------------------------+----------+-----------+
 */
