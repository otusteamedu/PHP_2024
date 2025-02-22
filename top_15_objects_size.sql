SELECT
	relname AS relation_name,
	pg_size_pretty(pg_total_relation_size(c.oid)) AS size
FROM
	pg_class c
WHERE
	relnamespace = 'public'::regnamespace
	AND c.relkind IN ('r', 'i')
ORDER BY
	pg_total_relation_size(c.oid) DESC
LIMIT
	15
;

--     relation_name    |  size   
-- ---------------------+---------
--  tickets             | 524 MB
--  sales               | 299 MB
--  tickets_pk          | 129 MB
--  sales_pk            | 75 MB
--  tickets_show_id_idx | 51 MB
--  shows               | 43 MB
--  sales_date_idx      | 23 MB
--  shows_pk            | 11 MB
--  prices              | 1488 kB
--  seats               | 896 kB
--  prices_unique       | 536 kB
--  seats_unique        | 344 kB
--  prices_pk           | 240 kB
--  seats_pk            | 152 kB
--  movies              | 104 kB