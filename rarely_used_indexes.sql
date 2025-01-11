SELECT
    indexrelname index_title,
    idx_scan scan_count
FROM
    pg_catalog.pg_stat_user_indexes
WHERE
    schemaname = 'public'
ORDER BY
    idx_scan
LIMIT 5;

-- index_title        | scan_count
genres_pkey,            0
genres_title_key,       0
film_genres_pkey,       0
directors_pkey,         0
film_directors_pkey,    0
