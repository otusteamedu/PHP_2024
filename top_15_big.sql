SELECT
    relname AS table_name,
    pg_size_pretty(pg_total_relation_size(c.oid)) AS size
FROM
    pg_class c
WHERE
        relnamespace = 'public'::regnamespace
  AND c.relkind IN ('r', 'i')
ORDER BY
    pg_total_relation_size(c.oid) DESC
LIMIT
    15;

-- table_name    |  size
films,              2538 MB
tickets,            276 MB
customers,          209 MB
films_pkey,         206 MB
sessions,           200 MB
seats,              103 MB
tickets_pkey,       68 MB
idx_sessions_time,  49 MB
idx_tickets_date,   37 MB
sessions_pkey,      35 MB
customers_pkey,     35 MB
hall_seat_unique,   33 MB
seats_pkey,         24 MB
idx_tickets_price,  22 MB
halls,              13 MB
