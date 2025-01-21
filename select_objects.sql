-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

select object_name,
       pg_size_pretty(object_size) as size,
       type
from (SELECT relname                 as object_name,
    pg_relation_size(relid) as object_size,
    'table'                 as type
    FROM pg_catalog.pg_statio_user_tables
    union
    SELECT ii.indexname           as object_name,
    PG_INDEXES_SIZE(relid) AS object_size,
    'index'                as type
    FROM pg_stat_all_indexes i
    JOIN pg_class c ON i.relid = c.oid
    JOIN pg_indexes ii ON i.indexrelname = ii.indexname
    WHERE i.schemaname NOT LIKE 'pg_%') as o
order by object_size desc
    limit 15;


-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов

select *
from pg_stat_user_indexes
order by idx_tup_read desc limit 5; -- часто
select *
from pg_stat_user_indexes
order by idx_tup_read limit 5; -- редко