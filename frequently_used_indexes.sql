SELECT
	indexrelname index_name,
	idx_scan scan_count
FROM
	pg_catalog.pg_stat_user_indexes
WHERE
	schemaname = 'public'
ORDER BY
	idx_scan DESC
LIMIT
	5
;

--      index_name      | scan_count 
-- ---------------------+------------
--  prices_unique       |         13
--  seats_pk            |         13
--  sales_date_idx      |         12
--  shows_pk            |          4
--  tickets_show_id_idx |          3