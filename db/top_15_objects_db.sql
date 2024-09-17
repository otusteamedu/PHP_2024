--отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

select relname as table_name,
    pg_size_pretty(pg_total_relation_size(relid)) as total_size,
    pg_size_pretty(pg_relation_size(relid)) as data_size,
    pg_size_pretty(pg_total_relation_size(relid) - pg_relation_size(relid))
      as external_size
from pg_catalog.pg_statio_user_tables
order by pg_total_relation_size(relid) desc,
         pg_relation_size(relid) desc
limit 15;


/*результат выполнения запроса*/

/*
    table_name    | total_size | data_size  | external_size
------------------+------------+------------+---------------
 cinema_show_seat | 1021 MB    | 686 MB     | 335 MB
 tickets          | 802 MB     | 460 MB     | 343 MB
 orders           | 623 MB     | 398 MB     | 225 MB
 seats            | 16 MB      | 11 MB      | 4416 kB
 cinema_shows     | 40 kB      | 8192 bytes | 32 kB
 films            | 32 kB      | 8192 bytes | 24 kB
 age_limits       | 24 kB      | 8192 bytes | 16 kB
 years            | 24 kB      | 8192 bytes | 16 kB
 genres           | 24 kB      | 8192 bytes | 16 kB
 users            | 24 kB      | 8192 bytes | 16 kB
 countries        | 24 kB      | 8192 bytes | 16 kB
 seats_type       | 24 kB      | 8192 bytes | 16 kB
 films_countries  | 24 kB      | 8192 bytes | 16 kB
 films_genres     | 24 kB      | 8192 bytes | 16 kB
 halls            | 24 kB      | 8192 bytes | 16 kB
(15 rows)

*/