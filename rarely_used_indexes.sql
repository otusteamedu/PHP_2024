SELECT
	indexrelname index_name,
	idx_scan scan_count
FROM
	pg_catalog.pg_stat_user_indexes
WHERE
	schemaname = 'public'
ORDER BY
	idx_scan
LIMIT
	5
;

--    index_name    | scan_count 
-- -----------------+------------
--  prices_pk       |          0
--  seats_unique    |          0
--  sales_pk        |          0
--  tickets_pk      |          1
--  cinema_halls_pk |          2