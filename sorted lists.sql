-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
SELECT nspname || '.' || relname                     AS name,
       pg_size_pretty(pg_total_relation_size(C.oid)) AS totalsize,
       pg_size_pretty(pg_relation_size(C.oid))       AS relsize
FROM pg_class C
         LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname = 'public'
  AND C.relkind IN ('r', 'i')
ORDER BY pg_total_relation_size(C.oid) DESC
    LIMIT 15;

         name          | totalsize | relsize
-----------------------+-----------+---------
 public.tickets        | 1116 MB   | 498 MB
 public.sessions       | 856 MB    | 575 MB
 public.movies         | 719 MB    | 504 MB
 public.halls          | 637 MB    | 423 MB
 public.idx_price      | 215 MB    | 215 MB
 public.tickets_pkey   | 214 MB    | 214 MB
 public.movies_pkey    | 214 MB    | 214 MB
 public.sessions_pkey  | 214 MB    | 214 MB
 public.halls_pkey     | 214 MB    | 214 MB
 public.idx_session_id | 188 MB    | 188 MB
 public.idx_date       | 66 MB     | 66 MB

 -- отсортированные списки (по 5 значений) самых часто и редко используемых индексов
SELECT indexrelname AS index_name,
       idx_scan     AS scan_count
FROM pg_catalog.pg_stat_user_indexes
WHERE schemaname = 'public'
ORDER BY idx_scan DESC
    LIMIT 5;

   index_name   | scan_count
----------------+------------
 movies_pkey    |     467139
 sessions_pkey  |       1765
 halls_pkey     |        402
 tickets_pkey   |         18
 idx_session_id |          3