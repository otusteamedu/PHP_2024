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

-- результат
-- |_. Таблица/Индекс |_. Размер |_. Тип объекта |
-- | orders        | 845 MB | таблица/обычный индекс |
-- | clients       | 730 MB | таблица/обычный индекс |
-- | movies        | 651 MB | таблица/обычный индекс |
-- | halls         | 498 MB | таблица/обычный индекс |
-- | tickets       | 498 MB | таблица/обычный индекс |
-- | sessions      | 498 MB | таблица/обычный индекс |
-- | order_tickets | 498 MB | таблица/обычный индекс |
-- | places        | 422 MB | таблица/обычный индекс |
-- | orders_pkey   | 225 MB | первичный ключ |
-- | movies_pkey   | 214 MB | первичный ключ |
-- | clients_pkey  | 214 MB | первичный ключ |
-- | sessions_pkey | 214 MB | первичный ключ |
-- | halls_pkey    | 214 MB | первичный ключ |
-- | places_pkey   | 214 MB | первичный ключ |
-- | tickets_pkey  | 214 MB | первичный ключ |


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

-- результат
-- |_. index_name  |_. scan_count |
-- | clients_pkey  | 10026047 |
-- | movies_pkey   | 10000105 |
-- | sessions_pkey | 10000061 |
-- | halls_pkey    | 10000048 |
-- | places_pkey   | 10000023 |


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

-- результат
-- |_. index_name |_. scan_count |
-- | order_tickets_pkey | 0 |
-- | idx_ticket_id      | 6 |
-- | idx_movie_id       | 22 |
-- | idx_session_id     | 25 |
-- | idx_date           | 29 |

