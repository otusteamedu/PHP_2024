-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
select
    relname,
    pg_size_pretty(pg_total_relation_size(oid)) as rel_size
from pg_class
order by pg_total_relation_size(oid) desc
limit 15;

-- relname               | pg_size_pretty 
-- -------------------------------------+----------------
--  tickets                             | 252 MB
--  movies                              | 238 MB
--  shows                               | 171 MB
--  idx_tickets_showid_soldprice_soldat | 53 MB
--  tickets_pkey                        | 43 MB
--  shows_pkey                          | 43 MB
--  movies_pkey                         | 43 MB
--  idx_tickets_showid_seatid           | 40 MB
--  idx_tickets_soldat                  | 17 MB
--  idx_shows_startat_date              | 13 MB
--  pg_proc                             | 1216 kB
--  pg_attribute                        | 760 kB
--  pg_rewrite                          | 728 kB
--  pg_description                      | 616 kB
--  pg_toast_2618                       | 560 kB
-- (15 rows)


-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов
select
    idx_stat.indexrelname as index_name,
    idx_stat.idx_scan as index_scans
from pg_stat_user_indexes as idx_stat
join pg_stat_user_tables as tbl_stat
on idx_stat.relid = tbl_stat.relid
order by idx_stat.idx_scan desc
limit 5;

--  index_name  | index_scans 
-- -------------+-------------
--  shows_pkey  |     5493171
--  halls_pkey  |     4011042
--  seats_pkey  |     2010120
--  movies_pkey |     2002856
--  rows_pkey   |        2396
-- (5 rows)

select
    idx_stat.indexrelname as index_name,
    idx_stat.idx_scan as index_scans
from pg_stat_user_indexes as idx_stat
join pg_stat_user_tables as tbl_stat
on idx_stat.relid = tbl_stat.relid
where idx_stat.idx_scan > 0
order by idx_stat.idx_scan asc
limit 5;

--              index_name              | index_scans 
-- -------------------------------------+-------------
--  idx_shows_startat_date              |          42
--  idx_tickets_soldat                  |          42
--  idx_tickets_showid_soldprice_soldat |         190
--  idx_tickets_showid_seatid           |         377
--  rows_pkey                           |        2396
-- (5 rows)
