/* №1 ----- Выбор всех фильмов на сегодня -----*/

/*
 * - Explain analyze на 10000 строк
 *
 * Nested Loop  (cost=0.29..73.21 rows=5 width=12) (actual time=0.155..0.393 rows=35 loops=1)
  ->  Seq Scan on sessions  (cost=0.00..31.70 rows=5 width=8) (actual time=0.142..0.152 rows=35 loops=1)
        Filter: ((started_at)::date = (now())::date)
        Rows Removed by Filter: 1050
  ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=20) (actual time=0.007..0.007 rows=1 loops=35)
        Index Cond: (id = sessions.movie_id)
Planning Time: 2.177 ms
Execution Time: 0.408 ms
 *
 * */

explain analyze
select movies.name as movies_name
from movies
         join sessions on movies.id = sessions.movie_id
where sessions.started_at::date = now()::date;

/** Добавим индекс для поля movie_id
 *
 * - Explain analyze на 10000 строк
 *
 * Nested Loop  (cost=0.29..73.21 rows=5 width=12) (actual time=0.186..0.656 rows=35 loops=1)
  ->  Seq Scan on sessions  (cost=0.00..31.70 rows=5 width=8) (actual time=0.168..0.195 rows=35 loops=1)
        Filter: ((started_at)::date = (now())::date)
        Rows Removed by Filter: 1050
  ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=20) (actual time=0.012..0.012 rows=1 loops=35)
        Index Cond: (id = sessions.movie_id)
Planning Time: 0.520 ms
Execution Time: 0.673 ms

   Вывод: ускорения нет, необходимо искать нужный индекс дальше.
 * **/

create index public_sessions_movie_id_index on public.sessions using btree ("movie_id");

drop index if exists public_sessions_movie_id_index;

/** Добавим индекс для поля started_at
 *
 * - Explain analyze на 10000 строк
 *
 * Nested Loop  (cost=0.29..73.21 rows=5 width=12) (actual time=0.109..0.164 rows=35 loops=1)
  ->  Seq Scan on sessions  (cost=0.00..31.70 rows=5 width=8) (actual time=0.104..0.109 rows=35 loops=1)
        Filter: ((started_at)::date = (now())::date)
        Rows Removed by Filter: 1050
  ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=20) (actual time=0.001..0.001 rows=1 loops=35)
        Index Cond: (id = sessions.movie_id)
Planning Time: 0.210 ms
Execution Time: 0.176 ms

   Вывод: ускорения нет, необходимо искать нужный индекс дальше
 * **/

create index public_sessions_started_at_index on public.sessions using btree (started_at);

drop index if exists public_sessions_started_at_index;

/** Добавим функциональный индекс для поля started_at
 *
 * - Explain analyze на 10000 строк
 *
 * Nested Loop  (cost=4.48..54.22 rows=5 width=12) (actual time=0.029..0.144 rows=35 loops=1)
  ->  Bitmap Heap Scan on sessions  (cost=4.20..12.71 rows=5 width=8) (actual time=0.022..0.026 rows=35 loops=1)
        Recheck Cond: ((started_at)::date = (now())::date)
        Heap Blocks: exact=2
        ->  Bitmap Index Scan on public_sessions_started_at_index  (cost=0.00..4.19 rows=5 width=0) (actual time=0.019..0.019 rows=35 loops=1)
              Index Cond: ((started_at)::date = (now())::date)
  ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=20) (actual time=0.003..0.003 rows=1 loops=35)
        Index Cond: (id = sessions.movie_id)
Planning Time: 0.297 ms
Execution Time: 0.174 ms

   Вывод: ускорение есть, индекс используется при выборке данных по дате
 * **/

create index public_sessions_started_at_index on public.sessions using btree ((started_at::date));

/* №2 ----- Подсчёт проданных билетов за неделю -----*/

/*
 * - Explain analyze на 10000 строк
 *
 * Sort  (cost=387.49..393.24 rows=2301 width=38) (actual time=1.498..1.560 rows=2238 loops=1)
  Sort Key: sale_at DESC
  Sort Method: quicksort  Memory: 236kB
  ->  Seq Scan on tickets  (cost=0.00..259.00 rows=2301 width=38) (actual time=0.006..1.269 rows=2238 loops=1)
        Filter: (sale_at >= (now() - '7 days'::interval))
        Rows Removed by Filter: 7762
Planning Time: 0.084 ms
Execution Time: 1.609 ms
 * */

explain analyze
select *
from tickets
where tickets.sale_at >= now() - interval '7 days'
order by sale_at desc;

/**
 * Добавляем индекс для поля sale_at
 *
 * Explain на 10000 строк
 *
 * Sort  (cost=298.88..304.63 rows=2301 width=38) (actual time=0.604..0.673 rows=2238 loops=1)
  Sort Key: sale_at DESC
  Sort Method: quicksort  Memory: 236kB
  ->  Bitmap Heap Scan on tickets  (cost=46.12..170.39 rows=2301 width=38) (actual time=0.182..0.379 rows=2238 loops=1)
        Recheck Cond: (sale_at >= (now() - '7 days'::interval))
        Heap Blocks: exact=84
        ->  Bitmap Index Scan on public_tickets_sale_at_index  (cost=0.00..45.55 rows=2301 width=0) (actual time=0.154..0.154 rows=2238 loops=1)
              Index Cond: (sale_at >= (now() - '7 days'::interval))
Planning Time: 0.129 ms
Execution Time: 0.775 ms

   Вывод: ускорение есть с 259 до 170, индекс используется при выборке данных по дате.
 */

create index public_tickets_sale_at_index on public.tickets using btree (sale_at);

/* №3 ----- Формирование афиши (фильмы, которые показывают сегодня) -----*/

/*
 * - Explain analyze на 10000 строк
 *
 * Sort  (cost=127.42..127.45 rows=11 width=263) (actual time=0.993..0.996 rows=70 loops=1)
  Sort Key: m.id, s.started_at, h.id
  Sort Method: quicksort  Memory: 30kB
  ->  Nested Loop  (cost=4.81..127.23 rows=11 width=263) (actual time=0.091..0.933 rows=70 loops=1)
        ->  Nested Loop  (cost=4.66..109.34 rows=11 width=45) (actual time=0.054..0.856 rows=70 loops=1)
              ->  Bitmap Heap Scan on sessions s  (cost=4.37..22.01 rows=11 width=32) (actual time=0.040..0.088 rows=70 loops=1)
                    Recheck Cond: ((started_at)::date = (now())::date)
                    Heap Blocks: exact=4
                    ->  Bitmap Index Scan on public_sessions_started_at_index  (cost=0.00..4.37 rows=11 width=0) (actual time=0.031..0.032 rows=70 loops=1)
                          Index Cond: ((started_at)::date = (now())::date)
              ->  Index Scan using movies_pkey on movies m  (cost=0.29..7.94 rows=1 width=21) (actual time=0.011..0.011 rows=1 loops=70)
                    Index Cond: (id = s.movie_id)
        ->  Memoize  (cost=0.16..3.81 rows=1 width=226) (actual time=0.001..0.001 rows=1 loops=70)
              Cache Key: s.hall_id
              Cache Mode: logical
              Hits: 65  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
              ->  Index Scan using halls_pkey on halls h  (cost=0.15..3.80 rows=1 width=226) (actual time=0.007..0.007 rows=1 loops=5)
                    Index Cond: (id = s.hall_id)
Planning Time: 0.829 ms
Execution Time: 1.037 ms
 * */

select m.name, h.name, s.ended_at
from sessions s
         join movies m on m.id = s.movie_id
         join halls h on s.hall_id = h.id
where s.started_at::date = now()::date;

/**
 * Добавляем индекс для полей movie_id и hall_id
 *
 * Explain на 10000 строк
 *
 * Sort  (cost=127.42..127.45 rows=11 width=263) (actual time=0.247..0.251 rows=70 loops=1)
  Sort Key: m.id, s.started_at, h.id
  Sort Method: quicksort  Memory: 30kB
  ->  Nested Loop  (cost=4.81..127.23 rows=11 width=263) (actual time=0.031..0.222 rows=70 loops=1)
        ->  Nested Loop  (cost=4.66..109.34 rows=11 width=45) (actual time=0.024..0.184 rows=70 loops=1)
              ->  Bitmap Heap Scan on sessions s  (cost=4.37..22.01 rows=11 width=32) (actual time=0.018..0.029 rows=70 loops=1)
                    Recheck Cond: ((started_at)::date = (now())::date)
                    Heap Blocks: exact=4
                    ->  Bitmap Index Scan on public_sessions_started_at_index  (cost=0.00..4.37 rows=11 width=0) (actual time=0.013..0.013 rows=70 loops=1)
                          Index Cond: ((started_at)::date = (now())::date)
              ->  Index Scan using movies_pkey on movies m  (cost=0.29..7.94 rows=1 width=21) (actual time=0.002..0.002 rows=1 loops=70)
                    Index Cond: (id = s.movie_id)
        ->  Memoize  (cost=0.16..3.81 rows=1 width=226) (actual time=0.000..0.000 rows=1 loops=70)
              Cache Key: s.hall_id
              Cache Mode: logical
              Hits: 65  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
              ->  Index Scan using halls_pkey on halls h  (cost=0.15..3.80 rows=1 width=226) (actual time=0.001..0.001 rows=1 loops=5)
                    Index Cond: (id = s.hall_id)
Planning Time: 0.276 ms
Execution Time: 0.299 ms

   Вывод: ускорение незначительное, но есть (возможно потому, что при создании структуры таблицы, были добавлены внешние ключи movie_id и hall_id),
индекс используется при выборке данных по внешним ключам movie_id и hall_id,
а так же за счет ранее добавленного функционального индекса для поля started_at.
 */

create index public_sessions_movie_id_index on public.sessions using btree (movie_id);
create index public_sessions_halls_id_index on public.sessions using btree (hall_id);

/* №4 ----- Поиск 3 самых прибыльных фильмов за неделю -----*/

/*
 * - Explain analyze на 10000 строк
 *
 * Limit  (cost=11098.92..11098.92 rows=3 width=53) (actual time=101.239..104.841 rows=3 loops=1)
  ->  Sort  (cost=11098.92..11104.66 rows=2296 width=53) (actual time=101.237..104.838 rows=3 loops=1)
        Sort Key: (sum(t.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=10786.12..11069.24 rows=2296 width=53) (actual time=100.371..104.733 rows=470 loops=1)
              Group Key: m.id
              ->  Gather Merge  (cost=10786.12..11026.19 rows=1914 width=53) (actual time=100.351..104.333 rows=1116 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=9786.10..9805.24 rows=957 width=53) (actual time=95.800..96.180 rows=372 loops=3)
                          Group Key: m.id
                          ->  Sort  (cost=9786.10..9788.49 rows=957 width=27) (actual time=95.779..95.928 rows=758 loops=3)
                                Sort Key: m.id
                                Sort Method: quicksort  Memory: 67kB
                                Worker 0:  Sort Method: quicksort  Memory: 66kB
                                Worker 1:  Sort Method: quicksort  Memory: 64kB
                                ->  Hash Join  (cost=639.79..9738.72 rows=957 width=27) (actual time=25.003..94.973 rows=758 loops=3)
                                      Hash Cond: (s.movie_id = m.id)
                                      ->  Hash Join  (cost=266.79..9363.20 rows=957 width=14) (actual time=12.711..82.142 rows=758 loops=3)
                                            Hash Cond: (p.session_id = s.id)
                                            ->  Hash Join  (cost=198.96..9292.87 rows=957 width=14) (actual time=9.156..78.112 rows=758 loops=3)
                                                  Hash Cond: (p.id = t.price_id)
                                                  ->  Parallel Seq Scan on prices p  (cost=0.00..7999.33 rows=289333 width=16) (actual time=0.180..48.173 rows=231467 loops=3)
                                                  ->  Hash  (cost=170.26..170.26 rows=2296 width=14) (actual time=8.478..8.479 rows=2274 loops=3)
                                                        Buckets: 4096  Batches: 1  Memory Usage: 139kB
                                                        ->  Bitmap Heap Scan on tickets t  (cost=46.08..170.26 rows=2296 width=14) (actual time=1.225..7.534 rows=2274 loops=3)
                                                              Recheck Cond: (sale_at >= (now() - '7 days'::interval))
                                                              Heap Blocks: exact=84
                                                              ->  Bitmap Index Scan on public_tickets_sale_at_index  (cost=0.00..45.51 rows=2296 width=0) (actual time=1.142..1.142 rows=2274 loops=3)
                                                                    Index Cond: (sale_at >= (now() - '7 days'::interval))
                                            ->  Hash  (cost=40.70..40.70 rows=2170 width=16) (actual time=3.423..3.423 rows=2170 loops=3)
                                                  Buckets: 4096  Batches: 1  Memory Usage: 134kB
                                                  ->  Seq Scan on sessions s  (cost=0.00..40.70 rows=2170 width=16) (actual time=0.063..1.724 rows=2170 loops=3)
                                      ->  Hash  (cost=248.00..248.00 rows=10000 width=21) (actual time=12.115..12.115 rows=10000 loops=3)
                                            Buckets: 16384  Batches: 1  Memory Usage: 646kB
                                            ->  Seq Scan on movies m  (cost=0.00..248.00 rows=10000 width=21) (actual time=0.032..8.765 rows=10000 loops=3)
Planning Time: 2.736 ms
Execution Time: 105.024 ms
 * */

explain analyze
select m.id, m.name, sum(t.price) as total
from movies m
         join public.sessions s on m.id = s.movie_id
         join public.prices p on s.id = p.session_id
         join public.tickets t on p.id = t.price_id
where t.sale_at >= now() - interval '7 days'
group by m.id
order by total desc
limit 3;

/* №5 ----- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс -----*/

/*
 * - Explain analyze на 10000 строк
 *
 * Sort  (cost=3695.35..3695.75 rows=159 width=9) (actual time=8.603..8.617 rows=160 loops=1)
  Sort Key: seats."row", seats.number
  Sort Method: quicksort  Memory: 31kB
  ->  Nested Loop  (cost=3473.27..3689.54 rows=159 width=9) (actual time=7.474..8.572 rows=160 loops=1)
        ->  Index Only Scan using sessions_pkey on sessions  (cost=0.28..4.29 rows=1 width=8) (actual time=0.004..0.013 rows=1 loops=1)
              Index Cond: (id = 1085)
              Heap Fetches: 0
        ->  Hash Join  (cost=3472.99..3683.65 rows=159 width=24) (actual time=7.468..8.540 rows=160 loops=1)
              Hash Cond: (prices.seat_id = seats.id)
              ->  Hash Right Join  (cost=3448.99..3659.24 rows=159 width=24) (actual time=7.313..8.352 rows=160 loops=1)
                    Hash Cond: (tickets.price_id = prices.id)
                    ->  Seq Scan on tickets  (cost=0.00..184.00 rows=10000 width=16) (actual time=0.008..0.452 rows=10000 loops=1)
                    ->  Hash  (cost=3447.00..3447.00 rows=159 width=24) (actual time=7.274..7.280 rows=160 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 17kB
                          ->  Seq Scan on prices  (cost=0.00..3447.00 rows=159 width=24) (actual time=5.551..7.245 rows=160 loops=1)
                                Filter: (session_id = 1085)
                                Rows Removed by Filter: 173440
              ->  Hash  (cost=14.00..14.00 rows=800 width=16) (actual time=0.121..0.121 rows=800 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 46kB
                    ->  Seq Scan on seats  (cost=0.00..14.00 rows=800 width=16) (actual time=0.007..0.059 rows=800 loops=1)
Planning Time: 0.192 ms
Execution Time: 8.649 ms
 * */

explain analyze
select number, row, (case when tickets.id isnull then true else false end) as avaliable
from seats
         left join prices on prices.seat_id = seats.id
         left join sessions on prices.session_id = sessions.id
         left join tickets on tickets.price_id = prices.id
where sessions.id = 1085
order by row, number;

/*
 * Добавляем индекс для полей prices.seat_id, prices.session_id и tickets.price_id
 *
 * - Explain analyze на 10000 строк
 *
 * Sort  (cost=701.64..702.04 rows=159 width=9) (actual time=1.235..1.241 rows=160 loops=1)
  Sort Key: seats."row", seats.number
  Sort Method: quicksort  Memory: 31kB
  ->  Nested Loop  (cost=479.55..695.83 rows=159 width=9) (actual time=0.317..1.105 rows=160 loops=1)
        ->  Index Only Scan using sessions_pkey on sessions  (cost=0.28..4.29 rows=1 width=8) (actual time=0.012..0.013 rows=1 loops=1)
              Index Cond: (id = 1085)
              Heap Fetches: 0
        ->  Hash Join  (cost=479.27..689.94 rows=159 width=24) (actual time=0.302..1.078 rows=160 loops=1)
              Hash Cond: (prices.seat_id = seats.id)
              ->  Hash Right Join  (cost=455.27..665.52 rows=159 width=24) (actual time=0.167..0.924 rows=160 loops=1)
                    Hash Cond: (tickets.price_id = prices.id)
                    ->  Seq Scan on tickets  (cost=0.00..184.00 rows=10000 width=16) (actual time=0.002..0.335 rows=10000 loops=1)
                    ->  Hash  (cost=453.29..453.29 rows=159 width=24) (actual time=0.144..0.145 rows=160 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 17kB
                          ->  Bitmap Heap Scan on prices  (cost=5.53..453.29 rows=159 width=24) (actual time=0.033..0.130 rows=160 loops=1)
                                Recheck Cond: (session_id = 1085)
                                Heap Blocks: exact=160
                                ->  Bitmap Index Scan on public_prices_session_id_index  (cost=0.00..5.49 rows=159 width=0) (actual time=0.020..0.020 rows=160 loops=1)
                                      Index Cond: (session_id = 1085)
              ->  Hash  (cost=14.00..14.00 rows=800 width=16) (actual time=0.130..0.130 rows=800 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 46kB
                    ->  Seq Scan on seats  (cost=0.00..14.00 rows=800 width=16) (actual time=0.008..0.067 rows=800 loops=1)
Planning Time: 0.358 ms
Execution Time: 1.279 ms
Вывод: ускорение есть, индексы используются, улучшение с 3695 до 702 и с 3447 до 453.
 * */

create index public_prices_session_id_index on public.prices using btree (session_id);
create index public_prices_seat_id_index on public.prices using btree (seat_id);
create index public_tickets_price_id_index on public.tickets using btree (price_id);

/* №6 ----- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс -----*/

/**
 * Explain analyze на 10000 строк
 *
 * Aggregate  (cost=454.08..454.09 rows=1 width=64) (actual time=0.298..0.299 rows=1 loops=1)
  ->  Bitmap Heap Scan on prices p  (cost=5.53..453.29 rows=159 width=6) (actual time=0.051..0.259 rows=160 loops=1)
        Recheck Cond: (session_id = 1085)
        Heap Blocks: exact=160
        ->  Bitmap Index Scan on public_prices_session_id_index  (cost=0.00..5.49 rows=159 width=0) (actual time=0.029..0.029 rows=160 loops=1)
              Index Cond: (session_id = 1085)
Planning Time: 0.158 ms
Execution Time: 0.336 ms
 */

explain analyze
select min(price), max(price)
from prices p
where session_id = 1085;


/**
 * Самые большие по размеру объекты БД (таблицы, включая индексы, сами индексы)
    name                                 |totalsize|relsize |
    -------------------------------------+---------+--------+
    public.prices                        |16 MB    |10216 kB|
    public.prices_pkey                   |3832 kB  |3832 kB |
    public.movies                        |1456 kB  |1184 kB |
    public.tickets                       |1424 kB  |672 kB  |
    public.public_prices_seat_id_index   |1184 kB  |1184 kB |
    public.public_prices_session_id_index|1176 kB  |1176 kB |
    pg_toast.pg_toast_2618               |560 kB   |512 kB  |
    pg_toast.pg_toast_2619               |272 kB   |224 kB  |
    public.clients                       |248 kB   |160 kB  |
    public.movies_pkey                   |240 kB   |240 kB  |
    public.tickets_pkey                  |240 kB   |240 kB  |
    public.public_tickets_sale_at_index  |240 kB   |240 kB  |
    public.public_tickets_price_id_index |240 kB   |240 kB  |
    public.sessions                      |224 kB   |80 kB   |
    public.seats                         |112 kB   |48 kB   |
 */

select nspname || '.' || relname                     as name,
       pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
       pg_size_pretty(pg_relation_size(C.oid))       as relsize
from pg_class C
         left join pg_namespace N ON (N.oid = C.relnamespace)
where nspname not in ('pg_catalog', 'information_schema')
order by pg_total_relation_size(C.oid) desc
limit 15;

/* ----- Самые часто и редко используемые индексов -----*/

/**
    index_name   |index_scans|
    -------------+-----------+
    seats_pkey   |     173638|
    sessions_pkey|     173623|
    prices_pkey  |      10042|
    genres_pkey  |      10000|
    clients_pkey |      10000|
 */

select idx_stat.indexrelname as index_name,
       idx_stat.idx_scan     as index_scans
from pg_stat_user_indexes as idx_stat
         join pg_stat_user_tables as tbl_stat
              on idx_stat.relid = tbl_stat.relid
order by idx_stat.idx_scan desc
limit 5;

/**
    index_name                      |index_scans|
    --------------------------------+-----------+
    public_tickets_sale_at_index    |         12|
    public_prices_seat_id_index     |         26|
    public_sessions_started_at_index|         29|
    public_prices_session_id_index  |         64|
    public_tickets_price_id_index   |         76|
 */

select idx_stat.indexrelname as index_name,
       idx_stat.idx_scan     as index_scans
from pg_stat_user_indexes as idx_stat
         join pg_stat_user_tables as tbl_stat
              on idx_stat.relid = tbl_stat.relid
where idx_stat.idx_scan > 0
order by idx_stat.idx_scan asc
limit 5;

