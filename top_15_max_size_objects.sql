SELECT
    relname AS object_name,
    CASE
        WHEN relkind = 'r' THEN 'table'
        WHEN relkind = 'i' THEN 'index'
        ELSE 'other'
        END AS object_type,
    pg_size_pretty(pg_total_relation_size(oid)) AS total_size,
    pg_size_pretty(pg_relation_size(oid)) AS relation_size,
    pg_size_pretty(pg_indexes_size(oid)) AS indexes_size
FROM
    pg_class
WHERE
    relkind IN ('r', 'i')  -- 'r' = таблица, 'i' = индекс
ORDER BY
    pg_total_relation_size(oid) DESC
    LIMIT 15;

-- object_name                | object_type | total_size | relation_size | indexes_size
-- ---------------------------+-------------+------------+---------------+---------------
-- movie                      | table   	| 3396 MB    | 3114 MB       | 281 MB
-- ticket                     | table   	| 1191 MB    | 574 MB        | 616 MB
-- price                      | table   	| 900 MB     | 498 MB        | 402 MB
-- session                    | table   	| 855 MB     | 574 MB        | 281 MB
-- handle_ticket_sold_at      | index   	| 214 MB     | 214 MB        | 0 bytes
-- movie_pkey                 | index   	| 214 MB     | 214 MB        | 0 bytes
-- session_pkey               | index   	| 214 MB     | 214 MB        | 0 bytes
-- price_pkey                 | index   	| 214 MB     | 214 MB        | 0 bytes
-- ticket_pkey                | index   	| 214 MB     | 214 MB        | 0 bytes
-- idx_ticket_session_id      | index   	| 188 MB     | 188 MB        | 0 bytes
-- idx_price_session_id       | index   	| 188 MB     | 188 MB        | 0 bytes
-- handle_movie_release_date  | index   	| 66 MB      | 66 MB         | 0 bytes
-- handle_session_start_time  | index   	| 66 MB      | 66 MB         | 0 bytes
-- pg_proc                    | table   	| 1216 kB    | 784 kB        | 344 kB
-- pg_attribute               | table   	| 768 kB     | 504 kB        | 232 kB
