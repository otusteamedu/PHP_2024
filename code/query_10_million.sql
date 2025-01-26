/* №1 ----- Выбор всех фильмов на сегодня -----*/

/*
 * - Explain analyze на 10000000 строк
 *
 * Merge Join  (cost=1824.19..2252.98 rows=319 width=12) (actual time=14.792..17.944 rows=35 loops=1)
  Merge Cond: (movies.id = sessions.movie_id)
  ->  Index Scan using movies_pkey on movies  (cost=0.42..40761.94 rows=1000000 width=20) (actual time=0.006..2.593 rows=9709 loops=1)
  ->  Sort  (cost=1823.77..1824.56 rows=319 width=8) (actual time=14.726..14.732 rows=35 loops=1)
        Sort Key: sessions.movie_id
        Sort Method: quicksort  Memory: 25kB
        ->  Seq Scan on sessions  (cost=0.00..1810.50 rows=319 width=8) (actual time=0.280..14.718 rows=35 loops=1)
              Filter: ((started_at)::date = (now())::date)
              Rows Removed by Filter: 63840
Planning Time: 0.708 ms
Execution Time: 17.976 ms
 *
 * */

explain analyze
select movies.name as movies_name
from movies
         join sessions on movies.id = sessions.movie_id
where sessions.started_at::date = now()::date;

/** Добавим индекс для поля movie_id
 *
 * - Explain analyze на 10000000 строк
 *
 * Merge Join  (cost=1824.19..2252.98 rows=319 width=12) (actual time=11.006..12.590 rows=35 loops=1)
  Merge Cond: (movies.id = sessions.movie_id)
  ->  Index Scan using movies_pkey on movies  (cost=0.42..40761.94 rows=1000000 width=20) (actual time=0.009..1.110 rows=9709 loops=1)
  ->  Sort  (cost=1823.77..1824.56 rows=319 width=8) (actual time=10.950..10.953 rows=35 loops=1)
        Sort Key: sessions.movie_id
        Sort Method: quicksort  Memory: 25kB
        ->  Seq Scan on sessions  (cost=0.00..1810.50 rows=319 width=8) (actual time=0.301..10.938 rows=35 loops=1)
              Filter: ((started_at)::date = (now())::date)
              Rows Removed by Filter: 63840
Planning Time: 0.329 ms
Execution Time: 12.625 ms

   Вывод: ускорения нет, необходимо искать нужный индекс дальше.
 * **/

create index public_sessions_movie_id_index on public.sessions using btree ("movie_id");

drop index if exists public_sessions_movie_id_index;

/** Добавим индекс для поля started_at
 *
 * - Explain analyze на 10000000 строк
 *
 * Merge Join  (cost=1824.19..2252.98 rows=319 width=12) (actual time=18.285..21.825 rows=35 loops=1)
  Merge Cond: (movies.id = sessions.movie_id)
  ->  Index Scan using movies_pkey on movies  (cost=0.42..40761.94 rows=1000000 width=20) (actual time=0.008..2.518 rows=9709 loops=1)
  ->  Sort  (cost=1823.77..1824.56 rows=319 width=8) (actual time=18.175..18.182 rows=35 loops=1)
        Sort Key: sessions.movie_id
        Sort Method: quicksort  Memory: 25kB
        ->  Seq Scan on sessions  (cost=0.00..1810.50 rows=319 width=8) (actual time=0.236..18.162 rows=35 loops=1)
              Filter: ((started_at)::date = (now())::date)
              Rows Removed by Filter: 63840
Planning Time: 0.437 ms
Execution Time: 21.868 ms

   Вывод: ускорения нет, необходимо искать нужный индекс дальше
 * **/

create index public_sessions_started_at_index on public.sessions using btree (started_at);

drop index if exists public_sessions_started_at_index;

/** Добавим функциональный индекс для поля started_at
 *
 * - Explain analyze на 10000000 строк
 *
 * Merge Join  (cost=509.47..938.26 rows=319 width=12) (actual time=0.117..3.159 rows=35 loops=1)
  Merge Cond: (movies.id = sessions.movie_id)
  ->  Index Scan using movies_pkey on movies  (cost=0.42..40761.94 rows=1000000 width=20) (actual time=0.010..2.053 rows=9709 loops=1)
  ->  Sort  (cost=509.04..509.84 rows=319 width=8) (actual time=0.033..0.039 rows=35 loops=1)
        Sort Key: sessions.movie_id
        Sort Method: quicksort  Memory: 25kB
        ->  Bitmap Heap Scan on sessions  (cost=6.77..495.77 rows=319 width=8) (actual time=0.017..0.022 rows=35 loops=1)
              Recheck Cond: ((started_at)::date = (now())::date)
              Heap Blocks: exact=1
              ->  Bitmap Index Scan on public_sessions_started_at_index  (cost=0.00..6.69 rows=319 width=0) (actual time=0.011..0.011 rows=35 loops=1)
                    Index Cond: ((started_at)::date = (now())::date)
Planning Time: 0.266 ms
Execution Time: 3.201 ms

   Вывод: ускорение есть, индекс используется при выборке данных по дате
 * **/

create index public_sessions_started_at_index on public.sessions using btree ((started_at::date));

/* №2 ----- Подсчёт проданных билетов за неделю -----*/

/*
 * - Explain analyze на 10000000 строк
 *
 * Gather Merge  (cost=158567.27..162903.37 rows=37164 width=38) (actual time=1056.467..1070.837 rows=43799 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=157567.25..157613.70 rows=18582 width=38) (actual time=988.269..990.157 rows=14600 loops=3)
        Sort Key: sale_at DESC
        Sort Method: quicksort  Memory: 1323kB
        Worker 0:  Sort Method: quicksort  Memory: 1305kB
        Worker 1:  Sort Method: quicksort  Memory: 1263kB
        ->  Parallel Seq Scan on tickets  (cost=0.00..156249.63 rows=18582 width=38) (actual time=5.693..981.083 rows=14600 loops=3)
              Filter: (sale_at >= (now() - '7 days'::interval))
              Rows Removed by Filter: 3318734
Planning Time: 0.110 ms
JIT:
  Functions: 6
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 1.405 ms, Inlining 0.000 ms, Optimization 1.251 ms, Emission 15.499 ms, Total 18.155 ms
Execution Time: 1073.190 ms
 * */

explain analyze
select *
from tickets
where tickets.sale_at >= now() - interval '7 days'
order by sale_at desc;

/**
 * Добавляем индекс для поля sale_at
 *
 * Explain на 10000000 строк
 *
 * Sort  (cost=77267.54..77379.21 rows=44667 width=38) (actual time=256.825..262.719 rows=43799 loops=1)
  Sort Key: sale_at DESC
  Sort Method: quicksort  Memory: 3855kB
  ->  Bitmap Heap Scan on tickets  (cost=838.61..73817.70 rows=44667 width=38) (actual time=15.894..246.103 rows=43799 loops=1)
        Recheck Cond: (sale_at >= (now() - '7 days'::interval))
        Heap Blocks: exact=34040
        ->  Bitmap Index Scan on public_tickets_sale_at_index  (cost=0.00..827.44 rows=44667 width=0) (actual time=9.518..9.519 rows=43799 loops=1)
              Index Cond: (sale_at >= (now() - '7 days'::interval))
Planning Time: 0.301 ms
Execution Time: 264.632 ms

   Вывод: ускорение есть с 157613 до 73817, индекс используется при выборке данных по дате.
 */

create index public_tickets_sale_at_index on public.tickets using btree (sale_at);

/* №3 ----- Формирование афиши (фильмы, которые показывают сегодня) -----*/

/*
 * - Explain analyze на 10000000 строк
 *
 * Nested Loop  (cost=509.62..940.46 rows=319 width=238) (actual time=0.070..1.619 rows=35 loops=1)
  ->  Merge Join  (cost=509.47..930.62 rows=319 width=28) (actual time=0.063..1.585 rows=35 loops=1)
        Merge Cond: (m.id = s.movie_id)
        ->  Index Scan using movies_pkey on movies m  (cost=0.42..40764.41 rows=1000000 width=20) (actual time=0.008..1.020 rows=8358 loops=1)
        ->  Sort  (cost=509.04..509.84 rows=319 width=24) (actual time=0.031..0.035 rows=35 loops=1)
              Sort Key: s.movie_id
              Sort Method: quicksort  Memory: 26kB
              ->  Bitmap Heap Scan on sessions s  (cost=6.77..495.77 rows=319 width=24) (actual time=0.012..0.017 rows=35 loops=1)
                    Recheck Cond: ((started_at)::date = (now())::date)
                    Heap Blocks: exact=1
                    ->  Bitmap Index Scan on public_sessions_started_at_index  (cost=0.00..6.69 rows=319 width=0) (actual time=0.008..0.008 rows=35 loops=1)
                          Index Cond: ((started_at)::date = (now())::date)
  ->  Memoize  (cost=0.16..0.33 rows=1 width=226) (actual time=0.001..0.001 rows=1 loops=35)
        Cache Key: s.hall_id
        Cache Mode: logical
        Hits: 30  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
        ->  Index Scan using halls_pkey on halls h  (cost=0.15..0.32 rows=1 width=226) (actual time=0.001..0.001 rows=1 loops=5)
              Index Cond: (id = s.hall_id)
Planning Time: 0.241 ms
Execution Time: 1.673 ms
 * */

explain analyze
select m.name, h.name, s.ended_at
from sessions s
         join movies m on m.id = s.movie_id
         join halls h on s.hall_id = h.id
where s.started_at::date = now()::date;

/**
 * Добавляем индекс для полей movie_id и hall_id
 *
 * Explain на 10000000 строк
 *
 * Nested Loop  (cost=509.62..940.46 rows=319 width=238) (actual time=0.123..3.567 rows=35 loops=1)
  ->  Merge Join  (cost=509.47..930.62 rows=319 width=28) (actual time=0.111..3.503 rows=35 loops=1)
        Merge Cond: (m.id = s.movie_id)
        ->  Index Scan using movies_pkey on movies m  (cost=0.42..40764.41 rows=1000000 width=20) (actual time=0.014..2.439 rows=8358 loops=1)
        ->  Sort  (cost=509.04..509.84 rows=319 width=24) (actual time=0.044..0.051 rows=35 loops=1)
              Sort Key: s.movie_id
              Sort Method: quicksort  Memory: 26kB
              ->  Bitmap Heap Scan on sessions s  (cost=6.77..495.77 rows=319 width=24) (actual time=0.020..0.027 rows=35 loops=1)
                    Recheck Cond: ((started_at)::date = (now())::date)
                    Heap Blocks: exact=1
                    ->  Bitmap Index Scan on public_sessions_started_at_index  (cost=0.00..6.69 rows=319 width=0) (actual time=0.011..0.011 rows=35 loops=1)
                          Index Cond: ((started_at)::date = (now())::date)
  ->  Memoize  (cost=0.16..0.33 rows=1 width=226) (actual time=0.001..0.001 rows=1 loops=35)
        Cache Key: s.hall_id
        Cache Mode: logical
        Hits: 30  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
        ->  Index Scan using halls_pkey on halls h  (cost=0.15..0.32 rows=1 width=226) (actual time=0.003..0.003 rows=1 loops=5)
              Index Cond: (id = s.hall_id)
Planning Time: 0.473 ms
Execution Time: 3.631 ms

   Вывод: ускорение незначительное, но есть (возможно потому, что при создании структуры таблицы, были добавлены внешние ключи movie_id и hall_id),
индекс используется при выборке данных по внешним ключам movie_id и hall_id,
а так же за счет ранее добавленного функционального индекса для поля started_at.
 */

create index public_sessions_movie_id_index on public.sessions using btree (movie_id);
create index public_sessions_halls_id_index on public.sessions using btree (hall_id);

/* №4 ----- Поиск 3 самых прибыльных фильмов за неделю -----*/

/*
 * - Explain analyze на 10000000 строк
 *
 * Limit  (cost=192432.41..192432.41 rows=3 width=52) (actual time=270.360..273.736 rows=3 loops=1)
  ->  Sort  (cost=192432.41..192544.03 rows=44650 width=52) (actual time=255.998..259.373 rows=3 loops=1)
        Sort Key: (sum(t.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  GroupAggregate  (cost=184903.49..191855.31 rows=44650 width=52) (actual time=234.804..259.243 rows=276 loops=1)
              Group Key: m.id
              ->  Merge Join  (cost=184903.49..191073.94 rows=44650 width=26) (actual time=234.694..254.668 rows=43799 loops=1)
                    Merge Cond: (s.movie_id = m.id)
                    ->  Gather Merge  (cost=184898.79..190099.01 rows=44650 width=14) (actual time=234.605..246.770 rows=43799 loops=1)
                          Workers Planned: 2
                          Workers Launched: 2
                          ->  Sort  (cost=183898.76..183945.27 rows=18604 width=14) (actual time=195.871..198.071 rows=14600 loops=3)
                                Sort Key: s.movie_id
                                Sort Method: quicksort  Memory: 1497kB
                                Worker 0:  Sort Method: quicksort  Memory: 879kB
                                Worker 1:  Sort Method: quicksort  Memory: 873kB
                                ->  Hash Join  (cost=2809.10..182579.43 rows=18604 width=14) (actual time=46.935..190.652 rows=14600 loops=3)
                                      Hash Cond: (p.session_id = s.id)
                                      ->  Nested Loop  (cost=838.91..180560.41 rows=18604 width=14) (actual time=24.435..162.047 rows=14600 loops=3)
                                            ->  Parallel Bitmap Heap Scan on tickets t  (cost=838.48..73349.65 rows=18604 width=14) (actual time=16.454..88.476 rows=14600 loops=3)
                                                  Recheck Cond: (sale_at >= (now() - '7 days'::interval))
                                                  Heap Blocks: exact=14475
                                                  ->  Bitmap Index Scan on public_tickets_sale_at_index  (cost=0.00..827.31 rows=44650 width=0) (actual time=39.074..39.075 rows=43799 loops=1)
                                                        Index Cond: (sale_at >= (now() - '7 days'::interval))
                                            ->  Index Scan using prices_pkey on prices p  (cost=0.43..5.76 rows=1 width=16) (actual time=0.004..0.004 rows=1 loops=43799)
                                                  Index Cond: (id = t.price_id)
                                      ->  Hash  (cost=1171.75..1171.75 rows=63875 width=16) (actual time=22.015..22.017 rows=63875 loops=3)
                                            Buckets: 65536  Batches: 1  Memory Usage: 3507kB
                                            ->  Seq Scan on sessions s  (cost=0.00..1171.75 rows=63875 width=16) (actual time=0.057..7.783 rows=63875 loops=3)
                    ->  Index Scan using movies_pkey on movies m  (cost=0.42..40764.41 rows=1000000 width=20) (actual time=0.037..1.792 rows=9976 loops=1)
Planning Time: 0.772 ms
JIT:
  Functions: 60
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 2.843 ms, Inlining 0.000 ms, Optimization 1.425 ms, Emission 36.878 ms, Total 41.146 ms
Execution Time: 274.913 ms
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
 * - Explain analyze на 10000000 строк
 *
 * Gather Merge  (cost=265631.68..265647.31 rows=134 width=9) (actual time=1538.104..1542.336 rows=160 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=264631.65..264631.82 rows=67 width=9) (actual time=1517.728..1517.740 rows=53 loops=3)
        Sort Key: seats."row", seats.number
        Sort Method: quicksort  Memory: 27kB
        Worker 0:  Sort Method: quicksort  Memory: 27kB
        Worker 1:  Sort Method: quicksort  Memory: 26kB
        ->  Nested Loop  (cost=128402.29..264629.62 rows=67 width=9) (actual time=270.086..1517.544 rows=53 loops=3)
              ->  Hash Join  (cost=128402.00..264340.35 rows=67 width=24) (actual time=269.978..1516.437 rows=53 loops=3)
                    Hash Cond: (prices.seat_id = seats.id)
                    ->  Parallel Hash Right Join  (cost=128378.00..264316.17 rows=67 width=24) (actual time=254.592..1500.890 rows=53 loops=3)
                          Hash Cond: (tickets.price_id = prices.id)
                          ->  Parallel Seq Scan on tickets  (cost=0.00..125000.67 rows=4166667 width=16) (actual time=16.823..945.061 rows=3333333 loops=3)
                          ->  Parallel Hash  (cost=128377.17..128377.17 rows=67 width=24) (actual time=214.343..214.344 rows=53 loops=3)
                                Buckets: 1024  Batches: 1  Memory Usage: 104kB
                                ->  Parallel Seq Scan on prices  (cost=0.00..128377.17 rows=67 width=24) (actual time=172.532..214.154 rows=53 loops=3)
                                      Filter: (session_id = 63715)
                                      Rows Removed by Filter: 3406613
                    ->  Hash  (cost=14.00..14.00 rows=800 width=16) (actual time=15.304..15.305 rows=800 loops=3)
                          Buckets: 1024  Batches: 1  Memory Usage: 46kB
                          ->  Seq Scan on seats  (cost=0.00..14.00 rows=800 width=16) (actual time=14.820..15.133 rows=800 loops=3)
              ->  Index Only Scan using sessions_pkey on sessions  (cost=0.29..4.31 rows=1 width=8) (actual time=0.015..0.016 rows=1 loops=160)
                    Index Cond: (id = 63715)
                    Heap Fetches: 0
Planning Time: 5.958 ms
JIT:
  Functions: 69
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 3.540 ms, Inlining 0.000 ms, Optimization 1.767 ms, Emission 42.905 ms, Total 48.212 ms
Execution Time: 1543.580 ms
 * */

explain analyze
select number, row, (case when tickets.id isnull then true else false end) as avaliable
from seats
         left join prices on prices.seat_id = seats.id
         left join sessions on prices.session_id = sessions.id
         left join tickets on tickets.price_id = prices.id
where sessions.id = 63715
order by row, number;

/*
 * Добавляем индекс для полей prices.seat_id, prices.session_id и tickets.price_id
 *
 * - Explain analyze на 10000000 строк
 *
 * Sort  (cost=2028.04..2028.45 rows=161 width=9) (actual time=2.081..2.100 rows=160 loops=1)
  Sort Key: seats."row", seats.number
  Sort Method: quicksort  Memory: 31kB
  ->  Nested Loop Left Join  (cost=30.41..2022.14 rows=161 width=9) (actual time=0.496..2.005 rows=160 loops=1)
        ->  Nested Loop  (cost=29.97..659.68 rows=161 width=16) (actual time=0.481..0.934 rows=160 loops=1)
              ->  Index Only Scan using sessions_pkey on sessions  (cost=0.29..4.31 rows=1 width=8) (actual time=0.014..0.015 rows=1 loops=1)
                    Index Cond: (id = 63715)
                    Heap Fetches: 0
              ->  Hash Join  (cost=29.68..653.76 rows=161 width=24) (actual time=0.462..0.883 rows=160 loops=1)
                    Hash Cond: (prices.seat_id = seats.id)
                    ->  Bitmap Heap Scan on prices  (cost=5.68..629.34 rows=161 width=24) (actual time=0.064..0.379 rows=160 loops=1)
                          Recheck Cond: (session_id = 63715)
                          Heap Blocks: exact=160
                          ->  Bitmap Index Scan on public_prices_session_id_index  (cost=0.00..5.64 rows=161 width=0) (actual time=0.025..0.025 rows=160 loops=1)
                                Index Cond: (session_id = 63715)
                    ->  Hash  (cost=14.00..14.00 rows=800 width=16) (actual time=0.389..0.390 rows=800 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 46kB
                          ->  Seq Scan on seats  (cost=0.00..14.00 rows=800 width=16) (actual time=0.010..0.172 rows=800 loops=1)
        ->  Index Scan using public_tickets_price_id_index on tickets  (cost=0.43..8.45 rows=1 width=16) (actual time=0.006..0.006 rows=1 loops=160)
              Index Cond: (price_id = prices.id)
Planning Time: 0.735 ms
Execution Time: 2.176 ms
Вывод: ускорение есть, индексы используются, улучшение с 264631 до 2028.
 * */

create index public_prices_session_id_index on public.prices using btree (session_id);
create index public_prices_seat_id_index on public.prices using btree (seat_id);
create index public_tickets_price_id_index on public.tickets using btree (price_id);

/* №6 ----- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс -----*/

/**
 * Explain analyze на 10000000 строк
 *
 * Aggregate  (cost=630.14..630.15 rows=1 width=64) (actual time=0.326..0.327 rows=1 loops=1)
  ->  Bitmap Heap Scan on prices p  (cost=5.68..629.34 rows=161 width=6) (actual time=0.063..0.272 rows=160 loops=1)
        Recheck Cond: (session_id = 63715)
        Heap Blocks: exact=160
        ->  Bitmap Index Scan on public_prices_session_id_index  (cost=0.00..5.64 rows=161 width=0) (actual time=0.031..0.031 rows=160 loops=1)
              Index Cond: (session_id = 63715)
Planning Time: 0.157 ms
Execution Time: 0.360 ms
 */

explain analyze
select min(price), max(price)
from prices p
where session_id = 63715;


/**
 * Самые большие по размеру объекты БД (таблицы, включая индексы, сами индексы)
    name                                   |totalsize|relsize|
    ---------------------------------------+---------+-------+
    public.tickets                         |1294 MB  |651 MB |
    public.prices                          |941 MB   |587 MB |
    public.prices_pkey                     |219 MB   |219 MB |
    public.public_tickets_sale_at_index    |214 MB   |214 MB |
    public.public_tickets_price_id_index   |214 MB   |214 MB |
    public.tickets_pkey                    |214 MB   |214 MB |
    public.movies                          |137 MB   |115 MB |
    public.public_prices_seat_id_index     |68 MB    |68 MB  |
    public.public_prices_session_id_index  |67 MB    |67 MB  |
    public.movies_pkey                     |21 MB    |21 MB  |
    public.sessions                        |7336 kB  |4264 kB|
    public.sessions_pkey                   |1416 kB  |1416 kB|
    public.public_sessions_movie_id_index  |688 kB   |688 kB |
    pg_toast.pg_toast_2618                 |560 kB   |512 kB |
    public.public_sessions_started_at_index|488 kB   |488 kB |
 */

select nspname || '.' || relname                     as name,
       pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
       pg_size_pretty(pg_relation_size(C.oid))       as relsize
from pg_class C
         left join pg_namespace N ON (N.oid = C.relnamespace)
where nspname not in ('pg_catalog', 'information_schema')
order by pg_total_relation_size(C.oid) desc
limit 15;

/* ----- Самые часто и редко используемые индексы -----*/

/**
    index_name  |index_scans|
    ------------+-----------+
    prices_pkey |   10919849|
    clients_pkey|   10000000|
    genres_pkey |    1000000|
    halls_pkey  |      64695|
    movies_pkey |      63953|
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
    public_sessions_started_at_index|          5|
    public_prices_seat_id_index     |         24|
    public_prices_session_id_index  |         28|
    seats_pkey                      |         28|
    public_sessions_movie_id_index  |         46|
 */

select idx_stat.indexrelname as index_name,
       idx_stat.idx_scan     as index_scans
from pg_stat_user_indexes as idx_stat
         join pg_stat_user_tables as tbl_stat
              on idx_stat.relid = tbl_stat.relid
where idx_stat.idx_scan > 0
order by idx_stat.idx_scan asc
limit 5;

