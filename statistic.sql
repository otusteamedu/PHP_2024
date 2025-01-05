-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

SELECT relname AS "Объект", pg_size_pretty(pg_total_relation_size(oid)) AS "Размер"
FROM pg_class
ORDER BY pg_total_relation_size(oid) DESC
LIMIT 15;

-- tickets	917 MB
-- tickets_pkey	412 MB
-- tickets_session_date_idx	63 MB
-- pg_proc	1232 kB
-- pg_attribute	912 kB
-- pg_rewrite	728 kB
-- pg_description	608 kB
-- pg_toast_2618	552 kB
-- pg_statistic	408 kB
-- pg_depend	368 kB
-- pg_proc_proname_args_nsp_index	256 kB
-- pg_class	248 kB
-- pg_type	240 kB
-- pg_collation	240 kB
-- pg_operator	232 kB



-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов
-- редкие
SELECT
    idxstat.relname AS "Таблица",
    indexrelname AS "Индекс",
    idxstat.idx_scan AS "Количество"
FROM pg_stat_all_indexes AS idxstat
         JOIN pg_index i ON idxstat.indexrelid = i.indexrelid
WHERE idxstat.schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
ORDER BY idxstat.idx_scan ASC
LIMIT 5;

-- films	films_title_idx	0
-- seats	seats_num_row_hall_id_key	0
-- sessions	sessions_start_time_idx	0
-- films	films_start_date_idx	0
-- halls	halls_title_idx	0



-- частые
SELECT
    idxstat.relname AS "Таблица",
    indexrelname AS "Индекс",
    idxstat.idx_scan AS "Количество"
FROM pg_stat_all_indexes AS idxstat
         JOIN pg_index i ON idxstat.indexrelid = i.indexrelid
WHERE idxstat.schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
ORDER BY idxstat.idx_scan DESC
LIMIT 5;

-- pivot_with_base_prices	pivot_with_base_prices_pkey	10093093
-- seats	seats_pkey	10093081
-- halls	halls_pkey	1266
-- sessions	sessions_pkey	976
-- films	films_pkey	966
