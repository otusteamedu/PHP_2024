-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

SELECT relname AS "Объект", pg_size_pretty(pg_total_relation_size(oid)) AS "Размер"
FROM pg_class
ORDER BY pg_total_relation_size(oid) DESC
    LIMIT 15;

-- tickets,1186 MB
-- tickets_session_date_idx,139 MB
-- pg_proc,1232 kB
-- pg_attribute,920 kB
-- pg_rewrite,752 kB
-- pg_description,608 kB
-- pg_toast_2618,576 kB
-- pg_statistic,400 kB
-- pg_depend,344 kB
-- pg_proc_proname_args_nsp_index,256 kB
-- pg_class,248 kB
-- pg_type,240 kB
-- pg_collation,240 kB
-- pg_operator,232 kB
-- pg_amop,224 kB

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

-- films,films_end_date_idx,0
-- films,films_start_date_idx,0
-- sessions,sessions_start_time_idx,2
-- tickets,tickets_session_date_idx,6
-- sessions,sessions_pkey,1200

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

-- random_tickets_with_base_prices,random_tickets_with_base_prices_pkey,21035622
-- seats,seats_pkey,21035598
-- halls,halls_pkey,1703
-- films,films_pkey,1201
-- sessions,sessions_pkey,1200