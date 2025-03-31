-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
SELECT
    relname AS "Таблица/Индекс",
    pg_size_pretty(pg_relation_size(pg_class.oid)) AS "Размер",
    CASE WHEN indisclustered THEN 'кластеризованный индекс'
         WHEN indisprimary THEN 'первичный ключ'
         WHEN indisunique THEN 'уникальный индекс'
         ELSE 'таблица/обычный индекс'
        END AS "Тип объекта"
FROM pg_class
         JOIN pg_namespace ON pg_namespace.oid = pg_class.relnamespace
         LEFT JOIN pg_index ON pg_class.oid = pg_index.indexrelid
WHERE pg_class.relkind IN ('r', 'i') -- 'r' для таблиц, 'i' для индексов
ORDER BY pg_relation_size(pg_class.oid) DESC
LIMIT 15;

-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов
-- Самые часто используемые индексы
SELECT
    n.nspname || '.' || c.relname AS index_name,
    i.idx_scan AS scan_count
FROM pg_stat_all_indexes i
         JOIN pg_class c ON i.indexrelid = c.oid
         JOIN pg_namespace n ON c.relnamespace = n.oid
WHERE schemaname = 'public'
ORDER BY i.idx_scan DESC
LIMIT 5;

-- Самые редко используемые индексы
SELECT
    c.relname AS index_name,
    i.idx_scan AS scan_count
FROM pg_stat_all_indexes i
         JOIN pg_class c ON i.indexrelid = c.oid
         JOIN pg_namespace n ON c.relnamespace = n.oid
WHERE schemaname = 'public'
ORDER BY i.idx_scan
LIMIT 5;