SELECT
    relname AS table_name,
    indexrelname AS index_name,
    idx_scan AS index_scans
FROM
    pg_stat_user_indexes
ORDER BY
    idx_scan ASC
    LIMIT 5;

-- table_name      | index_name                | index_scans
-- ----------------+---------------------------+-------------
-- ticket          | ticket_pkey               | 0
-- attribute       | attribute_pkey            | 0
-- attribute_value | attribute_value_pkey      | 0
-- price           | price_pkey                | 0
-- movie           | handle_movie_release_date | 2
