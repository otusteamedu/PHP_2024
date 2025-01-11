SELECT
    indexrelname index_title,
    idx_scan scan_count
FROM
    pg_catalog.pg_stat_user_indexes
WHERE
        schemaname = 'public'
ORDER BY
    idx_scan DESC
LIMIT 5;

-- index_title        | scan_count
sessions_pkey,          3442908
halls_pkey,             2748766
seats_pkey,             1720287
hall_seat_unique,       1720223
customers_pkey,         1720216
