--отсортированные списки (по 5 значений) самых часто и редко используемых индексов

SELECT indexrelname,  idx_scan FROM pg_stat_user_indexes ORDER BY idx_scan DESC LIMIT 5;

/*результат выполнения запроса*/

/*
            indexrelname             | idx_scan
-------------------------------------+----------
 seats_pkey                          |       12
 cinema_show_seat_pkey               |        8
 cinema_shows_pkey                   |        8
 idx_cinema_show_seat_cinema_show_id |        3
 years_pkey                          |        0
(5 rows)

*/