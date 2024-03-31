SELECT
       pgstat.relname AS table_name,
       indexrelname AS index_name,
       pgstat.idx_scan AS index_scan_count,
       pg_size_pretty(pg_relation_size(indexrelid)) AS index_size,
       tabstat.idx_scan AS table_reads_index_count,
       tabstat.seq_scan AS table_reads_seq_count,
       tabstat.seq_scan + tabstat.idx_scan AS table_reads_count,
       n_tup_upd + n_tup_ins + n_tup_del AS table_writes_count,
       pg_size_pretty(pg_relation_size(pgstat.relid)) AS table_size
FROM
       pg_stat_user_indexes AS pgstat
           JOIN
       pg_indexes
       ON
           indexrelname = indexname
               AND
           pgstat.schemaname = pg_indexes.schemaname
           JOIN
       pg_stat_user_tables AS tabstat
       ON
           pgstat.relid = tabstat.relid
WHERE
       indexdef !~* 'unique'
ORDER BY
       pgstat.idx_scan DESC,
       pg_relation_size(indexrelid) DESC;