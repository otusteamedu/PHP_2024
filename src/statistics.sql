-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

SELECT
    c.relname as name,
    pg_size_pretty(pg_relation_size(c.oid, 'main')) AS data_size,
    pg_size_pretty(pg_table_size(c.oid)) AS data_with_service_info_size,
    pg_size_pretty(pg_total_relation_size(c.oid)) AS total_size
FROM
    pg_class c INNER JOIN pg_namespace ns ON c.relnamespace = ns.oid
WHERE ns.nspname = 'public'
ORDER by pg_total_relation_size(c.oid) DESC LIMIT 15;

/*
| name                                 | data_size | data_with_service_info_size | total_size |
| ------------------------------------ | --------- | --------------------------- | ---------- |
| tickets                              | 537 MB    | 538 MB                      | 1824 MB    |
| index__tickets__session_id__price    | 301 MB    | 301 MB                      | 301 MB     |
| index__tickets__session_id           | 301 MB    | 301 MB                      | 301 MB     |
| tickets_pkey                         | 214 MB    | 214 MB                      | 214 MB     |
| tickets__session_id__seat_id__unique | 214 MB    | 214 MB                      | 214 MB     |
| index__tickets__sold_at              | 193 MB    | 193 MB                      | 193 MB     |
| index__tickets__seat_id              | 63 MB     | 63 MB                       | 63 MB      |
| sessions                             | 2944 kB   | 2976 kB                     | 8456 kB    |
| movies                               | 5872 kB   | 5912 kB                     | 6368 kB    |
| movies_genres                        | 1072 kB   | 1104 kB                     | 2480 kB    |
| sessions__hall_id__starts_at__unique | 2168 kB   | 2168 kB                     | 2168 kB    |
| movies_directors                     | 464 kB    | 496 kB                      | 1248 kB    |
| movies_countries                     | 464 kB    | 496 kB                      | 1232 kB    |
| index__sessions__starts_at           | 1112 kB   | 1112 kB                     | 1112 kB    |
| sessions_pkey                        | 1112 kB   | 1112 kB                     | 1112 kB    |
*/

-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов
-- часто используемые
SELECT
    indexrelname AS index_name,
    idx_scan AS scan_count
FROM pg_catalog.pg_stat_user_indexes
WHERE schemaname = 'public'
ORDER BY scan_count DESC LIMIT 5;

/*
| index_name    | scan_count |
| ------------- | ---------- |
| sessions_pkey | 10000016   |
| seats_pkey    | 10000008   |
| movies_pkey   | 106260     |
| halls_pkey    | 51000      |
| genres_pkey   | 30173      |
*/

-- редко используемые
SELECT
    indexrelname AS index_name,
    idx_scan AS scan_count
FROM pg_catalog.pg_stat_user_indexes
WHERE schemaname = 'public'
ORDER BY scan_count LIMIT 5;

/*
| index_name                           | scan_count |
| ------------------------------------ | ---------- |
| index__movies_directors__movie_id    | 0          |
| movies_directors_pkey                | 0          |
| genres__name__unique                 | 0          |
| countries__name__uniqie              | 0          |
| index__movies_directors__director_id | 0          |
*/

-- полностью
SELECT
    indexrelname AS index_name,
    idx_scan AS scan_count
FROM pg_catalog.pg_stat_user_indexes
WHERE schemaname = 'public'
ORDER BY scan_count DESC

/*
| index_name                                      | scan_count |
| ----------------------------------------------- | ---------- |
| sessions_pkey                                   | 10000016   |
| seats_pkey                                      | 10000008   |
| movies_pkey                                     | 106260     |
| halls_pkey                                      | 51000      |
| genres_pkey                                     | 30173      |
| countries_pkey                                  | 12981      |
| directors_pkey                                  | 12914      |
| index__sessions__movie_id                       | 24         |
| index__tickets__sold_at                         | 12         |
| index__tickets__seat_id                         | 8          |
| index__tickets__session_id__price               | 8          |
| index__seats__hall_id                           | 4          |
| index__movies__release_date                     | 3          |
| index__tickets__session_id                      | 3          |
| index__sessions__starts_at                      | 1          |
| movies_genres_pkey                              | 0          |
| index__movies_genres__movie_id                  | 0          |
| index__movies_genres__genre_id                  | 0          |
| movies_countries_pkey                           | 0          |
| halls__name__unique                             | 0          |
| index__movies_directors__director_id            | 0          |
| seats__hall_id__row_number__seat_number__unique | 0          |
| index__movies_directors__movie_id               | 0          |
| movies_directors_pkey                           | 0          |
| sessions__hall_id__starts_at__unique            | 0          |
| genres__name__unique                            | 0          |
| index__sessions__hall_id                        | 0          |
| tickets_pkey                                    | 0          |
| tickets__session_id__seat_id__unique            | 0          |
| countries__name__uniqie                         | 0          |
| index__movies_countries__country_id             | 0          |
| index__movies_countries__movie_id               | 0          |
 */