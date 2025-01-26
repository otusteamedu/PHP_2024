SELECT
    relname AS table_name,
    indexrelname AS index_name,
    idx_scan AS index_scans
FROM
    pg_stat_user_indexes
ORDER BY
    idx_scan DESC
    LIMIT 5;

-- table_name | index_name     | index_scans
-- -----------+----------------+-------------
-- session    | session_pkey   | 20040040
-- movie      | movie_pkey     | 11165676
-- hall       | hall_pkey      | 10035026
-- seat_type  | seat_type_pkey | 10035000
-- seat       | seat_pkey      | 10020040
