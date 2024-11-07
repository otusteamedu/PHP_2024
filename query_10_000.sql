/* 1 -----Выбор всех фильмов на сегодня -------*/
/*
 * - Explain на 10000 строк
 * Nested Loop Left Join  (cost=0.28..516.64 rows=44 width=400)
  ->  Seq Scan on shows s  (cost=0.00..235.55 rows=44 width=8)
        Filter: ((begin_time)::date = CURRENT_DATE)
  ->  Index Scan using movies_pkey on movies m  (cost=0.28..6.39 rows=1 width=408)
        Index Cond: (id = s.movie_id)
 *
 *
 *
 * */

explain analyze select m.title  from shows s
                                         left join movies m on m.id = s.movie_id
                where s.begin_time::date = current_date ;

/** Добавим индекс внешнему ключу
 *
 * - Explain на 10000 строк
 *
 * Nested Loop Left Join  (cost=0.30..497.91 rows=44 width=9)
  ->  Seq Scan on shows s  (cost=0.00..234.25 rows=44 width=8)
        Filter: ((begin_time)::date = CURRENT_DATE)
  ->  Memoize  (cost=0.30..6.40 rows=1 width=17)
        Cache Key: s.movie_id
        Cache Mode: logical
        ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.39 rows=1 width=17)
              Index Cond: (id = s.movie_id)

   Вывод - несущественный прогресс с 516 до - 497 продолжаем подбирать
 * **/

CREATE INDEX show_movie_id_idx ON public.shows using btree (movie_id);

DROP INDEX IF EXISTS  show_movie_id_idx;

/**
 * Добавим индекс на дату продажи билетов
 *
 *  - Explain на 10000 строк
 *
 * Nested Loop Left Join  (cost=0.30..497.91 rows=44 width=9)
  ->  Seq Scan on shows s  (cost=0.00..234.25 rows=44 width=8)
        Filter: ((begin_time)::date = CURRENT_DATE)
  ->  Memoize  (cost=0.30..6.40 rows=1 width=17)
        Cache Key: s.movie_id
        Cache Mode: logical
        ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.39 rows=1 width=17)
              Index Cond: (id = s.movie_id)

   Вывод - индекс не использован - продолжаем подбирать
 */
CREATE INDEX begin_time_idx ON public.shows using btree (begin_time);

DROP INDEX IF EXISTS  begin_time_idx;

/**
 * Добавим функциональный индекс
 * - Explain на 10000 строк
 *
 * Nested Loop Left Join  (cost=4.92..340.46 rows=44 width=9) (actual time=12.755..13.620 rows=300 loops=1)
  ->  Bitmap Heap Scan on shows s  (cost=4.63..76.80 rows=44 width=8) (actual time=12.718..12.835 rows=300 loops=1)
        Recheck Cond: ((begin_time)::date = CURRENT_DATE)
        Heap Blocks: exact=82
        ->  Bitmap Index Scan on begin_time_idx  (cost=0.00..4.62 rows=44 width=0) (actual time=12.703..12.703 rows=300 loops=1)
              Index Cond: ((begin_time)::date = CURRENT_DATE)
  ->  Memoize  (cost=0.30..6.40 rows=1 width=17) (actual time=0.002..0.002 rows=1 loops=300)
        Cache Key: s.movie_id
        Cache Mode: logical
        Hits: 5  Misses: 295  Evictions: 0  Overflows: 0  Memory Usage: 37kB
        ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.39 rows=1 width=17) (actual time=0.002..0.002 rows=1 loops=295)
              Index Cond: (id = s.movie_id)
Planning Time: 0.183 ms
Execution Time: 13.674 ms


Вывод: индекс используется и дает прирост с 516 до 340 - для ускорения запроса целесообразно использовать индекс для даты продажи в виде даты
 */
CREATE INDEX begin_time_idx ON public.shows using btree ((begin_time::date));



/* 2 ----Подсчёт проданных билетов за неделю-------
 *  Explain на 10000 строк
 * Seq Scan on tickets  (cost=0.00..259.00 rows=1726 width=40)
  	Filter: (sale_time >= date_trunc('week'::text, now()))
 * */
explain analyze select * from tickets where sale_time >= date_trunc('week', now());

/**
 * Добавляем индекс для даты продажи -
 * Explain на 10000 строк
 * Bitmap Heap Scan on tickets  (cost=37.67..151.87 rows=1726 width=40) (actual time=0.318..0.667 rows=1731 loops=1)
  Recheck Cond: (sale_time >= date_trunc('week'::text, now()))
  Heap Blocks: exact=84
  ->  Bitmap Index Scan on sale_time_tickets_idx  (cost=0.00..37.23 rows=1726 width=0) (actual time=0.247..0.248 rows=1731 loops=1)
        Index Cond: (sale_time >= date_trunc('week'::text, now()))
Planning Time: 0.225 ms
Execution Time: 0.786 ms
Вывод - улучшение с 259 до 151 - теперь используется индекс. Индекс для даты продажи подходит для ускорения
 */
CREATE INDEX sale_time_tickets_idx ON public.tickets using btree (sale_time);


/* Формирование афиши (фильмы, которые показывают сегодня)
 *  Explain на 10000 строк
 * Sort  (cost=502.48..502.59 rows=44 width=39)
  Sort Key: m.id, s.begin_time, h.id
  ->  Hash Left Join  (cost=3.54..501.28 rows=44 width=39)
        Hash Cond: (s.hall_id = h.id)
        ->  Nested Loop Left Join  (cost=0.30..497.91 rows=44 width=33)
              ->  Seq Scan on shows s  (cost=0.00..234.25 rows=44 width=24)
                    Filter: ((begin_time)::date = CURRENT_DATE)
              ->  Memoize  (cost=0.30..6.40 rows=1 width=17)
                    Cache Key: s.movie_id
                    Cache Mode: logical
                    ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.39 rows=1 width=17)
                          Index Cond: (id = s.movie_id)
        ->  Hash  (cost=2.00..2.00 rows=100 width=14)
              ->  Seq Scan on halls h  (cost=0.00..2.00 rows=100 width=14)


 * */
explain analyze select m.title, h.title, s.begin_time  from shows s
                                                                left join movies m on m.id = s.movie_id
                                                                left join halls h on s.hall_id = h.id
                where s.begin_time::date = current_date
                order by  m.id, s.begin_time, h.id;


/**
 * Добавим индексы на внеш ключи
 *  Explain на 10000 строк
 * Sort  (cost=345.03..345.14 rows=44 width=39) (actual time=7.399..7.424 rows=300 loops=1)
  Sort Key: m.id, s.begin_time, h.id
  Sort Method: quicksort  Memory: 48kB
  ->  Hash Left Join  (cost=8.17..343.83 rows=44 width=39) (actual time=3.509..7.250 rows=300 loops=1)
        Hash Cond: (s.hall_id = h.id)
        ->  Nested Loop Left Join  (cost=4.92..340.46 rows=44 width=33) (actual time=2.224..5.864 rows=300 loops=1)
              ->  Bitmap Heap Scan on shows s  (cost=4.63..76.80 rows=44 width=24) (actual time=0.970..1.139 rows=300 loops=1)
                    Recheck Cond: ((begin_time)::date = CURRENT_DATE)
                    Heap Blocks: exact=82
                    ->  Bitmap Index Scan on begin_time_idx  (cost=0.00..4.62 rows=44 width=0) (actual time=0.958..0.958 rows=300 loops=1)
                          Index Cond: ((begin_time)::date = CURRENT_DATE)
              ->  Memoize  (cost=0.30..6.40 rows=1 width=17) (actual time=0.015..0.015 rows=1 loops=300)
                    Cache Key: s.movie_id
                    Cache Mode: logical
                    Hits: 5  Misses: 295  Evictions: 0  Overflows: 0  Memory Usage: 37kB
                    ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.39 rows=1 width=17) (actual time=0.011..0.011 rows=1 loops=295)
                          Index Cond: (id = s.movie_id)
        ->  Hash  (cost=2.00..2.00 rows=100 width=14) (actual time=0.049..0.049 rows=100 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 13kB
              ->  Seq Scan on halls h  (cost=0.00..2.00 rows=100 width=14) (actual time=0.016..0.028 rows=100 loops=1)
Planning Time: 13.394 ms
Execution Time: 12.076 ms

 Вывод - индексы внешних ключей ускорили join + ускорение за счет добавленного выше индекса begin_time_idx
 */
CREATE INDEX show_movie_id_idx ON public.shows using btree (movie_id);
CREATE INDEX show_hall_id_idx ON public.shows using btree (hall_id);



/* Поиск 3 самых прибыльных фильмов за неделю
 *  Explain на 10000 строк
 * Limit  (cost=1144.87..1144.88 rows=3 width=25)
  ->  Sort  (cost=1144.87..1169.87 rows=10000 width=25)
        Sort Key: (sum(t.total_price)) DESC
        ->  HashAggregate  (cost=915.62..1015.62 rows=10000 width=25)
              Group Key: m.id
              ->  Nested Loop  (cost=278.05..865.62 rows=10000 width=25)
                    ->  Hash Join  (cost=277.75..488.01 rows=10000 width=16)
                          Hash Cond: (t.show_id = s.id)
                          ->  Seq Scan on tickets t  (cost=0.00..184.00 rows=10000 width=16)
                                Filter: (total_price IS NOT NULL)
                          ->  Hash  (cost=169.00..169.00 rows=8700 width=16)
                                ->  Seq Scan on shows s  (cost=0.00..169.00 rows=8700 width=16)
                    ->  Memoize  (cost=0.30..0.44 rows=1 width=17)
                          Cache Key: s.movie_id
                          Cache Mode: logical
                          ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.43 rows=1 width=17)
                                Index Cond: (id = s.movie_id)*/
explain analyze select m.id, m.title, sum(total_price) as total from movies m
                                                                         left join shows s on m.id = s.movie_id
                                                                         left join tickets t on s.id = t.show_id
                where t.total_price notnull
                group by m.id
                order by total desc
                    limit 3;

/**
 * Добавим индекс на внеш ключь и попробуем еще раз
 *  Explain на 10000 строк
 *
 * Limit  (cost=1144.87..1144.88 rows=3 width=25) (actual time=20.568..20.572 rows=3 loops=1)
  ->  Sort  (cost=1144.87..1169.87 rows=10000 width=25) (actual time=20.567..20.570 rows=3 loops=1)
        Sort Key: (sum(t.total_price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  HashAggregate  (cost=915.62..1015.62 rows=10000 width=25) (actual time=20.411..20.495 rows=295 loops=1)
              Group Key: m.id
              Batches: 1  Memory Usage: 465kB
              ->  Nested Loop  (cost=278.05..865.62 rows=10000 width=25) (actual time=3.019..18.551 rows=10000 loops=1)
                    ->  Hash Join  (cost=277.75..488.01 rows=10000 width=16) (actual time=3.002..7.814 rows=10000 loops=1)
                          Hash Cond: (t.show_id = s.id)
                          ->  Seq Scan on tickets t  (cost=0.00..184.00 rows=10000 width=16) (actual time=0.012..1.941 rows=10000 loops=1)
                                Filter: (total_price IS NOT NULL)
                          ->  Hash  (cost=169.00..169.00 rows=8700 width=16) (actual time=2.969..2.970 rows=8700 loops=1)
                                Buckets: 16384  Batches: 1  Memory Usage: 536kB
                                ->  Seq Scan on shows s  (cost=0.00..169.00 rows=8700 width=16) (actual time=0.005..1.384 rows=8700 loops=1)
                    ->  Memoize  (cost=0.30..0.44 rows=1 width=17) (actual time=0.001..0.001 rows=1 loops=10000)
                          Cache Key: s.movie_id
                          Cache Mode: logical
                          Hits: 9705  Misses: 295  Evictions: 0  Overflows: 0  Memory Usage: 36kB
                          ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.43 rows=1 width=17) (actual time=0.002..0.002 rows=1 loops=295)
                                Index Cond: (id = s.movie_id)
Planning Time: 7.729 ms
Execution Time: 20.958 ms
Вывод - без изменений - уберем индекс
 */
CREATE INDEX tickets_show_idx ON public.tickets using btree (show_id);

DROP INDEX IF exists tickets_show_idx;

/**
 * Добавим функц индекс на total price и повторяем запрос
 * Explain на 10000 строк
 * Limit  (cost=1144.87..1144.88 rows=3 width=25) (actual time=15.003..15.006 rows=3 loops=1)
  ->  Sort  (cost=1144.87..1169.87 rows=10000 width=25) (actual time=15.002..15.004 rows=3 loops=1)
        Sort Key: (sum(t.total_price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  HashAggregate  (cost=915.62..1015.62 rows=10000 width=25) (actual time=14.866..14.948 rows=295 loops=1)
              Group Key: m.id
              Batches: 1  Memory Usage: 465kB
              ->  Nested Loop  (cost=278.05..865.62 rows=10000 width=25) (actual time=2.961..13.070 rows=10000 loops=1)
                    ->  Hash Join  (cost=277.75..488.01 rows=10000 width=16) (actual time=2.941..7.823 rows=10000 loops=1)
                          Hash Cond: (t.show_id = s.id)
                          ->  Seq Scan on tickets t  (cost=0.00..184.00 rows=10000 width=16) (actual time=0.007..1.912 rows=10000 loops=1)
                                Filter: (total_price IS NOT NULL)
                          ->  Hash  (cost=169.00..169.00 rows=8700 width=16) (actual time=2.922..2.922 rows=8700 loops=1)
                                Buckets: 16384  Batches: 1  Memory Usage: 536kB
                                ->  Seq Scan on shows s  (cost=0.00..169.00 rows=8700 width=16) (actual time=0.005..1.523 rows=8700 loops=1)
                    ->  Memoize  (cost=0.30..0.44 rows=1 width=17) (actual time=0.000..0.000 rows=1 loops=10000)
                          Cache Key: s.movie_id
                          Cache Mode: logical
                          Hits: 9705  Misses: 295  Evictions: 0  Overflows: 0  Memory Usage: 36kB
                          ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.43 rows=1 width=17) (actual time=0.002..0.002 rows=1 loops=295)
                                Index Cond: (id = s.movie_id)
Planning Time: 0.635 ms
Execution Time: 15.240 ms

Вывод - без изменений Убираем индекс

 *
 */
CREATE INDEX tickets_total_idx ON public.tickets using btree (total_price);
DROP INDEX IF exists tickets_total_idx;

/**
 * При необходимости ускорения запроса (только если такой запрос используется действительно часто ) можно создать дополнительную таблицу с
 * суммой на которую продано билетов - и обновлять ее с помощью тригеров при покупке билетов
 *
 *
 */
CREATE TABLE public.sells
(
    movie_id  bigserial  NOT NULL,
    total float8    NOT NULL,

    CONSTRAINT sells_pkey PRIMARY KEY (movie_id)
);

/** обновим таблицу для уже существующих данных **/
insert into sells(movie_id, total)
select m.id, sum(total_price) as total from movies m
                                                left join shows s on m.id = s.movie_id
                                                left join tickets t on s.id = t.show_id
where t.total_price notnull
group by m.id;


/**
 * Для будущих данных добавим тригер на вставку в таблицу tickets
 */

CREATE OR REPLACE FUNCTION "update_sales_for_movie"()
 RETURNS trigger
 LANGUAGE plpgsql
 AS $function$
	declare
movie int := (select movie_id from shows where id =  new.show_id);
	total_for_movie float8 := (select total from sells  where movie_id = movie );
BEGIN
        IF (total_for_movie > 0) THEN
update sells set total = total_for_movie + new.total_price where movie_id = movie;
RETURN new;
ELse
            insert into sells (movie_id, total) values (movie, new.total_price);
RETURN NEW;
END IF;
RETURN NULL;
END;
$function$;

CREATE OR replace TRIGGER "update_sales_for_movie"
AFTER INSERT ON "tickets"
    FOR EACH ROW EXECUTE PROCEDURE "update_sales_for_movie"();


   /**
    * Пробуем с помощью нового запроса
    * Explain на 10000 строк
    * Limit  (cost=62.76..62.77 rows=3 width=16) (actual time=0.118..0.119 rows=3 loops=1)
  ->  Sort  (cost=62.76..63.50 rows=295 width=16) (actual time=0.117..0.118 rows=3 loops=1)
        Sort Key: total DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Seq Scan on sells  (cost=0.00..58.95 rows=295 width=16) (actual time=0.044..0.077 rows=295 loops=1)
Planning Time: 0.205 ms
Execution Time: 0.130 ms

Вывод
Использование промежуточной таблицы и тригеров позволят получать данные быстрее и с меньшей нагрузкой на базу,
     но следует помнить что вставка будет занимать большее количество времени из-за тригера
Если для нас это незначительно - то таким образом можно оптимизировать запрос на 3 популярных фильма к базе
    */
 explain analyze select * from sells order by total desc  limit 3;





/*
 * Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
 * Explain на 10000 строк
 *
 * Sort  (cost=1919.53..1921.08 rows=621 width=9)
  Sort Key: s.row_num, s.seat_num
  ->  Nested Loop  (cost=1396.51..1890.72 rows=621 width=9)
        ->  Seq Scan on shows sh  (cost=0.00..277.75 rows=1 width=8)
              Filter: ((hall_id = 1) AND (category_id = 1) AND ((begin_time)::date = CURRENT_DATE))
        ->  Hash Right Join  (cost=1396.51..1606.76 rows=621 width=24)
              Hash Cond: (t.show_id = s.id)
              ->  Seq Scan on tickets t  (cost=0.00..184.00 rows=10000 width=16)
              ->  Hash  (cost=1388.75..1388.75 rows=621 width=24)
                    ->  Seq Scan on seats s  (cost=0.00..1388.75 rows=621 width=24)
                          Filter: (hall_id = 1)
                          */

explain analyze select seat_num, row_num,
                       (case when t.id isnull then true else false end) as avaliable
                from seats s
                         left join shows sh on sh.hall_id = s.hall_id
                         left join tickets t on t.show_id = s.id
                where s.hall_id = 1
                  and sh.begin_time::date = current_date
and sh.category_id = 1
                order by row_num, seat_num;

/* Добавим индексы на ключи сортировки
 *
 * Sort  (cost=1153.07..1154.62 rows=621 width=9) (actual time=6.382..6.497 rows=1680 loops=1)
  Sort Key: s.row_num, s.seat_num
  Sort Method: quicksort  Memory: 127kB
  ->  Nested Loop  (cost=688.16..1124.26 rows=621 width=9) (actual time=0.297..5.834 rows=1680 loops=1)
        ->  Index Scan using show_hall_id_idx on shows sh  (cost=0.29..10.68 rows=1 width=8) (actual time=0.015..0.031 rows=1 loops=1)
              Index Cond: (hall_id = 1)
              Filter: ((category_id = 1) AND ((begin_time)::date = CURRENT_DATE))
              Rows Removed by Filter: 86
        ->  Hash Right Join  (cost=687.88..1107.38 rows=621 width=24) (actual time=0.279..5.564 rows=1680 loops=1)
              Hash Cond: (t.show_id = s.id)
              ->  Seq Scan on tickets t  (cost=0.00..367.00 rows=20000 width=16) (actual time=0.005..2.335 rows=20000 loops=1)
              ->  Hash  (cost=680.11..680.11 rows=621 width=24) (actual time=0.256..0.257 rows=595 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 41kB
                    ->  Bitmap Heap Scan on seats s  (cost=9.10..680.11 rows=621 width=24) (actual time=0.062..0.155 rows=595 loops=1)
                          Recheck Cond: (hall_id = 1)
                          Heap Blocks: exact=9
                          ->  Bitmap Index Scan on seat_hall_id_idx  (cost=0.00..8.95 rows=621 width=0) (actual time=0.052..0.052 rows=595 loops=1)
                                Index Cond: (hall_id = 1)
Planning Time: 8.964 ms
Execution Time: 6.648 ms


 * Вывод - получаем улучшение с 1919 до 1153.07 и с 1396 до 680 Оптимизации удалось добится за счет индексов
 * */

CREATE INDEX show_category_id_idx ON public.shows using btree (category_id);
CREATE INDEX seat_hall_id_idx ON public.seats using btree (hall_id);





/**
 * Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
 * Explain на 10000 строк
 *
 * Aggregate  (cost=213.33..213.34 rows=1 width=16)
  ->  Nested Loop Left Join  (cost=0.29..213.33 rows=1 width=8)
        Join Filter: (s.id = t.show_id)
        ->  Index Only Scan using shows_pkey on shows s  (cost=0.29..4.30 rows=1 width=8)
              Index Cond: (id = 111)
        ->  Seq Scan on tickets t  (cost=0.00..209.00 rows=2 width=16)
              Filter: (show_id = 111)
 */
explain select min(total_price), max(total_price) from shows s
                                                           left join tickets t on s.id = t.show_id where s.id = 111;


/**
 * Добавляем индекс внеш ключу
 * Explain на 10000
 * Aggregate  (cost=22.87..22.88 rows=1 width=16)
  ->  Nested Loop Left Join  (cost=4.60..22.86 rows=1 width=8)
        Join Filter: (s.id = t.show_id)
        ->  Index Only Scan using shows_pkey on shows s  (cost=0.29..4.30 rows=1 width=8)
              Index Cond: (id = 111)
        ->  Bitmap Heap Scan on tickets t  (cost=4.32..18.51 rows=4 width=16)
              Recheck Cond: (show_id = 111)
              ->  Bitmap Index Scan on ticket_show_id_idx  (cost=0.00..4.32 rows=4 width=0)
                    Index Cond: (show_id = 111)
 Вывод - получаем улучшение с 213 до 22 - оптимизации удалось добися с помощью индексов
 */

/**
  отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
 */
CREATE INDEX ticket_show_id_idx ON public.tickets using btree (show_id);



/**
  отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
 *  public.seats	                8224 kB	5160 kB
    public.tickets	                3528 kB	1336 kB
    public.seats_pkey	            2616 kB	2616 kB
    public.movies	                2272 kB	2000 kB
    public.shows	                1216 kB	656 kB
    public.sale_time_tickets_idx	976 kB	952 kB
    public.tickets_pkey	            920 kB	896 kB
    pg_toast.pg_toast_2618	        576 kB	528 kB
    public.sells	                568 kB	448 kB
    public.seat_hall_id_idx	        416 kB	416 kB
    public.ticket_show_id_idx	    264 kB	264 kB
    public.movies_pkey	            240 kB	240 kB
    public.shows_pkey	            208 kB	208 kB
    pg_toast.pg_toast_2619	        200 kB	152 kB
    public.sells_pkey	            88 kB	88 kB
 */
SELECT nspname || '.' || relname  as name,
       pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
       pg_size_pretty(pg_relation_size(C.oid)) as relsize
FROM pg_class C
         LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC
    LIMIT 15;

/**
  отсортированные списки (по 5 значений) самых часто и редко используемых индексов
    seat_category_pkey	90300
    halls_pkey	        68270
    shows_pkey	        30058
    seats_pkey	        20014
    movies_pkey	        15218
 */
SELECT indexrelname index_name, idx_scan scan_count
FROM pg_catalog.pg_stat_user_indexes
where schemaname = 'public'
ORDER by idx_scan desc limit 5;