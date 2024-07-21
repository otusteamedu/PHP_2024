/**
    Запрос
 */
SELECT relname                                                                 AS object_name,
       pg_size_pretty(pg_total_relation_size(relid))                           AS total_size,
       pg_size_pretty(pg_relation_size(relid))                                 AS table_size,
       pg_size_pretty(pg_total_relation_size(relid) - pg_relation_size(relid)) AS indexes_size
FROM pg_catalog.pg_statio_user_tables
ORDER BY pg_total_relation_size(relid) DESC
LIMIT 15;

/**
    Таблица с результатами ~ 10.000 данных.

    +-----------+----------+----------+------------+
    |object_name|total_size|table_size|indexes_size|
    +-----------+----------+----------+------------+
    |customers  |1872 kB   |752 kB    |1120 kB     |
    |seats      |1184 kB   |520 kB    |664 kB      |
    |tickets    |1080 kB   |512 kB    |568 kB      |
    |sessions   |864 kB    |592 kB    |272 kB      |
    |halls      |200 kB    |104 kB    |96 kB       |
    |movies     |184 kB    |104 kB    |80 kB       |
    |cinemas    |144 kB    |64 kB     |80 kB       |
    |genres     |56 kB     |8192 bytes|48 kB       |
    +-----------+----------+----------+------------+
 */

/**
   Таблица с результатами ~ 100.000 данных.

    +-----------+----------+----------+------------+
    |object_name|total_size|table_size|indexes_size|
    +-----------+----------+----------+------------+
    |customers  |20 MB     |8224 kB   |12 MB       |
    |seats      |17 MB     |6624 kB   |11 MB       |
    |tickets    |12 MB     |5096 kB   |7672 kB     |
    |sessions   |10112 kB  |5888 kB   |4224 kB     |
    |halls      |2840 kB   |1936 kB   |904 kB      |
    |cinemas    |1616 kB   |1120 kB   |496 kB      |
    |movies     |1488 kB   |992 kB    |496 kB      |
    |genres     |56 kB     |8192 bytes|48 kB       |
    +-----------+----------+----------+------------+
 */
