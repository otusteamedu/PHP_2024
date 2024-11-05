-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
select
    relname,
    pg_size_pretty(pg_total_relation_size(oid)) as rel_size
from pg_class
order by pg_total_relation_size(oid) desc
limit 15;

-- +----------------------------------------------+--------+
-- |relname                                       |rel_size|
-- +----------------------------------------------+--------+
-- |tickets                                       |1707 MB |
-- |ticket_prices                                 |1089 MB |
-- |idx_tickets_ticket_price_id_price_purchased_at|362 MB  |
-- |idx_tickets_ticket_price_id                   |271 MB  |
-- |ticket_prices_id                              |201 MB  |
-- |idx_tickets_purchased_at                      |201 MB  |
-- |tickets_pkey                                  |201 MB  |
-- |ticket_prices_pkey                            |201 MB  |
-- |idx_ticket_prices_session_id                  |78 MB   |
-- |idx_ticket_prices_seat_id                     |71 MB   |
-- |idx_tickets_customer_id                       |63 MB   |
-- |sessions                                      |3072 kB |
-- |pg_proc                                       |1216 kB |
-- |pg_attribute                                  |800 kB  |
-- |pg_rewrite                                    |736 kB  |
-- +----------------------------------------------+--------+



-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов
select
    idx_stat.indexrelname as index_name,
    idx_stat.idx_scan as index_scans
from pg_stat_user_indexes as idx_stat
         join pg_stat_user_tables as tbl_stat
              on idx_stat.relid = tbl_stat.relid
order by idx_stat.idx_scan desc
limit 5;

-- +------------------+-----------+
-- |index_name        |index_scans|
-- +------------------+-----------+
-- |ticket_prices_pkey|9381258    |
-- |customers_pkey    |9381250    |
-- |sessions_pkey     |9371266    |
-- |seats_pkey        |9371258    |
-- |halls_pkey        |27260      |
-- +------------------+-----------+

select
    idx_stat.indexrelname as index_name,
    idx_stat.idx_scan as index_scans
from pg_stat_user_indexes as idx_stat
         join pg_stat_user_tables as tbl_stat
              on idx_stat.relid = tbl_stat.relid
where idx_stat.idx_scan > 0
order by idx_stat.idx_scan asc
limit 5;

-- +----------------------------------------------+-----------+
-- |index_name                                    |index_scans|
-- +----------------------------------------------+-----------+
-- |idx_sessions_start_time                       |2          |
-- |idx_tickets_ticket_price_id                   |6          |
-- |idx_ticket_prices_seat_id                     |8          |
-- |ticket_prices_id                              |8          |
-- |idx_tickets_ticket_price_id_price_purchased_at|10         |
-- +----------------------------------------------+-----------+
