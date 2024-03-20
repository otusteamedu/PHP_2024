SELECT * FROM pg_stat_all_indexes where schemaname = 'public'
order by idx_scan desc ;