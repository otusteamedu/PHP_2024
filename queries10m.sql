/* 1 -----Выбор всех фильмов на сегодня -------*/
/*
 * - Explain на 10000000 строк
 *		Nested Loop Left Join  (cost=0.45..5768.45 rows=435 width=20) (actual time=0.034..81.895 rows=3000 loops=1)
  ->  Seq Scan on shows s  (cost=0.00..2336.50 rows=435 width=8) (actual time=0.019..23.577 rows=3000 loops=1)
        Filter: ((begin_time)::date = CURRENT_DATE)
        Rows Removed by Filter: 84000
  ->  Memoize  (cost=0.45..8.43 rows=1 width=20) (actual time=0.019..0.019 rows=1 loops=3000)
        Cache Key: s.movie_id
        Cache Mode: logical
        Hits: 0  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
        ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.42 rows=1 width=20) (actual time=0.018..0.018 rows=1 loops=3000)
              Index Cond: (id = s.movie_id)
Planning Time: 0.165 ms
Execution Time: 82.167 ms
 * 
 * 
 * 
 * */

 explain analyze select m.id, m.title  from shows s 
left join movies m on m.id = s.movie_id
where s.begin_time::date = current_date ;

/** Добавим индекс внешнему ключу 
 * 
 * - Explain на 10000 строк
 * 
 *Nested Loop Left Join  (cost=0.45..5768.45 rows=435 width=20) (actual time=0.020..25.252 rows=3000 loops=1)
  ->  Seq Scan on shows s  (cost=0.00..2336.50 rows=435 width=8) (actual time=0.009..11.467 rows=3000 loops=1)
        Filter: ((begin_time)::date = CURRENT_DATE)
        Rows Removed by Filter: 84000
  ->  Memoize  (cost=0.45..8.43 rows=1 width=20) (actual time=0.004..0.004 rows=1 loops=3000)
        Cache Key: s.movie_id
        Cache Mode: logical
        Hits: 0  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
        ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.42 rows=1 width=20) (actual time=0.003..0.003 rows=1 loops=3000)
              Index Cond: (id = s.movie_id)
Planning Time: 0.456 ms
Execution Time: 25.524 ms
              
   Вывод - нет прогресса продолжаем подбирать
 * **/

CREATE INDEX show_movie_id_idx ON public.shows using btree (movie_id);

DROP INDEX IF EXISTS  show_movie_id_idx;


/**
 * Добавим функциональный индекс 
 * Nested Loop Left Join  (cost=8.11..4152.34 rows=435 width=20) (actual time=0.346..14.849 rows=3000 loops=1)
  ->  Bitmap Heap Scan on shows s  (cost=7.67..720.40 rows=435 width=8) (actual time=0.326..1.711 rows=3000 loops=1)
        Recheck Cond: ((begin_time)::date = CURRENT_DATE)
        Heap Blocks: exact=813
        ->  Bitmap Index Scan on begin_time_idx  (cost=0.00..7.56 rows=435 width=0) (actual time=0.236..0.236 rows=3000 loops=1)
              Index Cond: ((begin_time)::date = CURRENT_DATE)
  ->  Memoize  (cost=0.45..8.43 rows=1 width=20) (actual time=0.004..0.004 rows=1 loops=3000)
        Cache Key: s.movie_id
        Cache Mode: logical
        Hits: 0  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
        ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.42 rows=1 width=20) (actual time=0.003..0.003 rows=1 loops=3000)
              Index Cond: (id = s.movie_id)
Planning Time: 0.498 ms
Execution Time: 15.165 ms
 * 
 *

Вывод: индекс используется и дает прирост с 5768.45 до 4152.34 в join
и вместо sec scan 2336.50 теперь выполняется Bitmap Heap Scan за 720
- для ускорения запроса целесообразно использовать индекс для даты продажи в виде даты
 */
CREATE INDEX begin_time_idx ON public.shows using btree ((begin_time::date));



/* 2 ----Подсчёт проданных билетов за неделю-------
 *  Finalize Aggregate  (cost=160063.38..160063.39 rows=1 width=8) (actual time=1382.978..1384.510 rows=1 loops=1)
  ->  Gather  (cost=160063.17..160063.38 rows=2 width=8) (actual time=1382.857..1384.503 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=159063.17..159063.18 rows=1 width=8) (actual time=1374.603..1374.604 rows=1 loops=3)
              ->  Parallel Seq Scan on tickets  (cost=0.00..156250.67 rows=1125000 width=0) (actual time=0.060..1306.292 rows=912762 loops=3)
                    Filter: (sale_time >= date_trunc('week'::text, now()))
                    Rows Removed by Filter: 2420572
Planning Time: 0.067 ms
Execution Time: 1384.534 ms
 * */
explain analyze select count(*) from tickets where sale_time >= date_trunc('week', now());


/**
 * Добавляем индекс для даты продажи - 
 * Finalize Aggregate  (cost=64929.17..64929.18 rows=1 width=8) (actual time=344.366..355.938 rows=1 loops=1)
  ->  Gather  (cost=64928.95..64929.16 rows=2 width=8) (actual time=344.268..355.932 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=63928.95..63928.96 rows=1 width=8) (actual time=335.046..335.047 rows=1 loops=3)
              ->  Parallel Index Only Scan using sale_time_tickets_idx on tickets  (cost=0.44..61116.45 rows=1125000 width=0) (actual time=0.151..269.069 rows=912762 loops=3)
                    Index Cond: (sale_time >= date_trunc('week'::text, now()))
                    Heap Fetches: 0
Planning Time: 0.262 ms
Execution Time: 355.965 ms

Вывод - для сканирования используется индекс - улучшение с 160063.39 до 64929.18
Для оптимизации целесобразно использовать индекс для даты продажи
 */
CREATE INDEX sale_time_tickets_idx ON public.tickets using btree (sale_time);



/* Формирование афиши (фильмы, которые показывают сегодня)
 * Sort  (cost=16952.00..16959.51 rows=3004 width=43) (actual time=16.631..16.903 rows=3000 loops=1)
  Sort Key: m.id, s.begin_time, h.id
  Sort Method: quicksort  Memory: 331kB
  ->  Hash Left Join  (cost=64.52..16778.48 rows=3004 width=43) (actual time=0.519..15.440 rows=3000 loops=1)
        Hash Cond: (s.hall_id = h.id)
        ->  Nested Loop Left Join  (cost=36.02..16742.06 rows=3004 width=36) (actual time=0.222..14.238 rows=3000 loops=1)
              ->  Bitmap Heap Scan on shows s  (cost=35.58..902.15 rows=3004 width=24) (actual time=0.210..1.672 rows=3000 loops=1)
                    Recheck Cond: ((begin_time)::date = CURRENT_DATE)
                    Heap Blocks: exact=813
                    ->  Bitmap Index Scan on begin_time_idx  (cost=0.00..34.82 rows=3004 width=0) (actual time=0.122..0.122 rows=3000 loops=1)
                          Index Cond: ((begin_time)::date = CURRENT_DATE)
              ->  Memoize  (cost=0.45..8.23 rows=1 width=20) (actual time=0.004..0.004 rows=1 loops=3000)
                    Cache Key: s.movie_id
                    Cache Mode: logical
                    Hits: 0  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 375kB
                    ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.22 rows=1 width=20) (actual time=0.003..0.003 rows=1 loops=3000)
                          Index Cond: (id = s.movie_id)
        ->  Hash  (cost=16.00..16.00 rows=1000 width=15) (actual time=0.286..0.286 rows=1000 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 55kB
              ->  Seq Scan on halls h  (cost=0.00..16.00 rows=1000 width=15) (actual time=0.007..0.133 rows=1000 loops=1)
Planning Time: 0.235 ms
Execution Time: 17.643 ms
 
 * */
 explain analyze select m.title, h.title, s.begin_time  from shows s 
left join movies m on m.id = s.movie_id
left join halls h on s.hall_id = h.id
where s.begin_time::date = current_date 
order by  m.id, s.begin_time, h.id;


/**
 * Добавим индексы на внеш ключи и попробунм еще раз 
 *  *  Sort  (cost=4201.05..4202.14 rows=435 width=43) (actual time=16.666..16.938 rows=3000 loops=1)
  Sort Key: m.id, s.begin_time, h.id
  Sort Method: quicksort  Memory: 331kB
  ->  Hash Left Join  (cost=36.61..4181.98 rows=435 width=43) (actual time=0.693..15.404 rows=3000 loops=1)
        Hash Cond: (s.hall_id = h.id)
        ->  Nested Loop Left Join  (cost=8.11..4152.34 rows=435 width=36) (actual time=0.328..14.132 rows=3000 loops=1)
              ->  Bitmap Heap Scan on shows s  (cost=7.67..720.40 rows=435 width=24) (actual time=0.309..1.628 rows=3000 loops=1)
                    Recheck Cond: ((begin_time)::date = CURRENT_DATE)
                    Heap Blocks: exact=813
                    ->  Bitmap Index Scan on begin_time_idx  (cost=0.00..7.56 rows=435 width=0) (actual time=0.220..0.220 rows=3000 loops=1)
                          Index Cond: ((begin_time)::date = CURRENT_DATE)
              ->  Memoize  (cost=0.45..8.43 rows=1 width=20) (actual time=0.004..0.004 rows=1 loops=3000)
                    Cache Key: s.movie_id
                    Cache Mode: logical
                    Hits: 0  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 375kB
                    ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.42 rows=1 width=20) (actual time=0.003..0.003 rows=1 loops=3000)
                          Index Cond: (id = s.movie_id)
        ->  Hash  (cost=16.00..16.00 rows=1000 width=15) (actual time=0.342..0.343 rows=1000 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 55kB
              ->  Seq Scan on halls h  (cost=0.00..16.00 rows=1000 width=15) (actual time=0.008..0.170 rows=1000 loops=1)
Planning Time: 52.595 ms
Execution Time: 22.324 ms

 Вывод - индексы внешних ключей ускорили join + ускорение за счет добавленного выше индекса begin_time_idx
 */
CREATE INDEX show_movie_id_idx ON public.shows using btree (movie_id);
CREATE INDEX show_hall_id_idx ON public.shows using btree (hall_id);


/* Поиск 3 самых прибыльных фильмов за неделю
 * Limit  (cost=2208763.07..2208763.08 rows=3 width=28) (actual time=5530.812..6433.122 rows=3 loops=1)
  ->  Sort  (cost=2208763.07..2233759.39 rows=9998527 width=28) (actual time=5530.811..6433.120 rows=3 loops=1)
        Sort Key: (sum(t.total_price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=903083.34..2079533.99 rows=9998527 width=28) (actual time=4614.869..6432.257 rows=3000 loops=1)
              Group Key: m.id
              ->  Gather Merge  (cost=903083.34..1937881.72 rows=8333400 width=28) (actual time=4614.505..6429.661 rows=9000 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=902083.31..975000.56 rows=4166700 width=28) (actual time=4591.007..5481.099 rows=3000 loops=3)
                          Group Key: m.id
                          ->  Sort  (cost=902083.31..912500.06 rows=4166700 width=28) (actual time=4590.672..5071.408 rows=3333333 loops=3)
                                Sort Key: m.id
                                Sort Method: external merge  Disk: 139264kB
                                Worker 0:  Sort Method: external merge  Disk: 134952kB
                                Worker 1:  Sort Method: external merge  Disk: 136920kB
                                ->  Hash Join  (cost=20976.65..244556.78 rows=4166700 width=28) (actual time=110.754..2778.546 rows=3333333 loops=3)
                                      Hash Cond: (t.show_id = s.id)
                                      ->  Parallel Seq Scan on tickets t  (cost=0.00..125001.00 rows=4166700 width=16) (actual time=0.046..603.417 rows=3333333 loops=3)
                                            Filter: (total_price IS NOT NULL)
                                      ->  Hash  (cost=19294.15..19294.15 rows=87000 width=28) (actual time=110.403..110.405 rows=87000 loops=3)
                                            Buckets: 65536  Batches: 2  Memory Usage: 3232kB
                                            ->  Nested Loop  (cost=0.45..19294.15 rows=87000 width=28) (actual time=0.061..82.324 rows=87000 loops=3)
                                                  ->  Seq Scan on shows s  (cost=0.00..1684.00 rows=87000 width=16) (actual time=0.023..9.237 rows=87000 loops=3)
                                                  ->  Memoize  (cost=0.45..5.15 rows=1 width=20) (actual time=0.000..0.000 rows=1 loops=261000)
                                                        Cache Key: s.movie_id
                                                        Cache Mode: logical
                                                        Hits: 84000  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
                                                        Worker 0:  Hits: 84000  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
                                                        Worker 1:  Hits: 84000  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
                                                        ->  Index Scan using movies_pkey on movies m  (cost=0.43..5.14 rows=1 width=20) (actual time=0.008..0.008 rows=1 loops=9000)
                                                              Index Cond: (id = s.movie_id)
Planning Time: 20.332 ms
Execution Time: 6920.535 ms
*/
explain analyze select m.id, m.title, sum(total_price) as total from movies m
left join shows s on m.id = s.movie_id
left join tickets t on s.id = t.show_id
where t.total_price notnull
group by m.id
order by total desc
limit 3;

/**
 * Добавим индекс на внеш ключь и попробуем еще раз 
 *  Limit  (cost=1246507.21..1246507.22 rows=3 width=28) (actual time=37511.608..37511.611 rows=3 loops=1)
  ->  Sort  (cost=1246507.21..1271503.53 rows=9998527 width=28) (actual time=37511.607..37511.609 rows=3 loops=1)
        Sort Key: (sum(t.total_price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  GroupAggregate  (cost=1.17..1117278.12 rows=9998527 width=28) (actual time=12.223..37505.200 rows=3000 loops=1)
              Group Key: m.id
              ->  Nested Loop  (cost=1.17..967292.85 rows=10000000 width=28) (actual time=0.034..36167.798 rows=10000000 loops=1)
                    ->  Nested Loop  (cost=0.74..22495.35 rows=87000 width=28) (actual time=0.016..338.515 rows=87000 loops=1)
                          ->  Index Scan using show_movie_id_idx on shows s  (cost=0.29..4885.20 rows=87000 width=16) (actual time=0.006..84.651 rows=87000 loops=1)
                          ->  Memoize  (cost=0.45..5.15 rows=1 width=20) (actual time=0.002..0.002 rows=1 loops=87000)
                                Cache Key: s.movie_id
                                Cache Mode: logical
                                Hits: 84000  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
                                ->  Index Scan using movies_pkey on movies m  (cost=0.43..5.14 rows=1 width=20) (actual time=0.046..0.046 rows=1 loops=3000)
                                      Index Cond: (id = s.movie_id)
                    ->  Index Scan using tickets_show_idx on tickets t  (cost=0.43..8.61 rows=225 width=16) (actual time=0.021..0.393 rows=115 loops=87000)
                          Index Cond: (show_id = s.id)
                          Filter: (total_price IS NOT NULL)
Planning Time: 0.586 ms
Execution Time: 37513.494 ms
Вывод - с индексом запрос выполняется даже хуже - уберем индекс
 */
CREATE INDEX tickets_show_idx ON public.tickets using btree (show_id);

DROP INDEX IF exists tickets_show_idx;

/**
 * Добавим функц индекс на total price и повторяем запрос 
 * Limit  (cost=2208749.90..2208749.90 rows=3 width=28) (actual time=5540.971..6473.639 rows=3 loops=1)
  ->  Sort  (cost=2208749.90..2233746.21 rows=9998527 width=28) (actual time=5540.970..6473.637 rows=3 loops=1)
        Sort Key: (sum(t.total_price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=903078.68..2079520.81 rows=9998527 width=28) (actual time=4653.469..6472.843 rows=3000 loops=1)
              Group Key: m.id
              ->  Gather Merge  (cost=903078.68..1937868.87 rows=8333334 width=28) (actual time=4653.131..6470.616 rows=9000 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=902078.66..974995.33 rows=4166667 width=28) (actual time=4632.370..5509.891 rows=3000 loops=3)
                          Group Key: m.id
                          ->  Sort  (cost=902078.66..912495.33 rows=4166667 width=28) (actual time=4632.098..5102.495 rows=3333333 loops=3)
                                Sort Key: m.id
                                Sort Method: external merge  Disk: 137944kB
                                Worker 0:  Sort Method: external merge  Disk: 136520kB
                                Worker 1:  Sort Method: external merge  Disk: 136672kB
                                ->  Hash Join  (cost=20976.65..244555.99 rows=4166667 width=28) (actual time=139.806..2808.859 rows=3333333 loops=3)
                                      Hash Cond: (t.show_id = s.id)
                                      ->  Parallel Seq Scan on tickets t  (cost=0.00..125000.67 rows=4166667 width=16) (actual time=0.041..608.696 rows=3333333 loops=3)
                                            Filter: (total_price IS NOT NULL)
                                      ->  Hash  (cost=19294.15..19294.15 rows=87000 width=28) (actual time=138.958..138.960 rows=87000 loops=3)
                                            Buckets: 65536  Batches: 2  Memory Usage: 3232kB
                                            ->  Nested Loop  (cost=0.45..19294.15 rows=87000 width=28) (actual time=12.320..111.696 rows=87000 loops=3)
                                                  ->  Seq Scan on shows s  (cost=0.00..1684.00 rows=87000 width=16) (actual time=0.022..11.845 rows=87000 loops=3)
                                                  ->  Memoize  (cost=0.45..5.15 rows=1 width=20) (actual time=0.001..0.001 rows=1 loops=261000)
                                                        Cache Key: s.movie_id
                                                        Cache Mode: logical
                                                        Hits: 84000  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
                                                        Worker 0:  Hits: 84000  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
                                                        Worker 1:  Hits: 84000  Misses: 3000  Evictions: 0  Overflows: 0  Memory Usage: 366kB
                                                        ->  Index Scan using movies_pkey on movies m  (cost=0.43..5.14 rows=1 width=20) (actual time=0.017..0.017 rows=1 loops=9000)
                                                              Index Cond: (id = s.movie_id)
Planning Time: 0.515 ms
Execution Time: 6941.038 ms

Вывод - без изменений

 * 
 */
CREATE INDEX tickets_total_idx ON public.tickets using btree (total_price);

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
    * Limit  (cost=131.54..131.54 rows=3 width=16) (actual time=0.699..0.701 rows=3 loops=1)
  ->  Sort  (cost=131.54..139.77 rows=3295 width=16) (actual time=0.699..0.699 rows=3 loops=1)
        Sort Key: total DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Seq Scan on sells  (cost=0.00..88.95 rows=3295 width=16) (actual time=0.006..0.346 rows=3295 loops=1)
Planning Time: 0.167 ms
Execution Time: 0.710 ms

Вывод 
Использование промежуточной таблицы и тригеров позволят получаь данные быстрее и с меньшей нагрузкой на базу, но следует помнить что вставка будет занимать большее количество времени изза тригера
Если для нас это незначительно - то таким образом можно оптимизировать запрос на 3 популярных фильма к базе
    */
 explain analyze select * from sells order by total desc  limit 3;





/*
 * Nested Loop  (cost=225963.07..242934.31 rows=134109 width=9) (actual time=10125.783..10412.921 rows=67113 loops=1)
  ->  Gather Merge  (cost=225962.77..241247.26 rows=134109 width=24) (actual time=10125.749..10384.290 rows=67113 loops=1)
        Workers Planned: 1
        Workers Launched: 1
        ->  Sort  (cost=224962.76..225159.98 rows=78888 width=24) (actual time=10112.104..10114.878 rows=33556 loops=2)
              Sort Key: s.row_num, s.seat_num
              Sort Method: quicksort  Memory: 3195kB
              Worker 0:  Sort Method: quicksort  Memory: 3755kB
              ->  Parallel Hash Left Join  (cost=197430.00..218546.20 rows=78888 width=24) (actual time=9695.757..10101.226 rows=33556 loops=2)
                    Hash Cond: (s.id = t.show_id)
                    ->  Parallel Seq Scan on seats2 s  (cost=0.00..9.38 rows=350 width=24) (actual time=0.026..0.222 rows=298 loops=2)
                          Filter: (hall_id = 2)
                    ->  Parallel Hash  (cost=125000.67..125000.67 rows=4166667 width=16) (actual time=9627.468..9627.469 rows=5000000 loops=2)
                          Buckets: 131072  Batches: 256  Memory Usage: 3296kB
                          ->  Parallel Seq Scan on tickets t  (cost=0.00..125000.67 rows=4166667 width=16) (actual time=0.063..848.430 rows=5000000 loops=2)
  ->  Materialize  (cost=0.29..10.69 rows=1 width=8) (actual time=0.000..0.000 rows=1 loops=67113)
        ->  Index Scan using show_hall_id_idx on shows sh  (cost=0.29..10.69 rows=1 width=8) (actual time=0.028..0.040 rows=1 loops=1)
              Index Cond: (hall_id = 2)
              Filter: ((category_id = 1) AND ((begin_time)::date = CURRENT_DATE))
              Rows Removed by Filter: 86
Planning Time: 0.219 ms
Execution Time: 10417.271 ms
 ms*/

 explain analyze select seat_num, row_num, 
(case when t.id isnull then true else false end) as avaliable
from seats s
left join shows sh on sh.hall_id = s.hall_id  
left join tickets t on t.show_id = s.id
where s.hall_id = 2
and sh.begin_time::date = current_date 
and sh.category_id = 1
order by row_num, seat_num;

/* Добавим индекс на таблицу билетов
 * 
 * Nested Loop  (cost=131374.64..132671.60 rows=9976 width=9) (actual time=231.290..457.440 rows=67113 loops=1)
  ->  Gather Merge  (cost=131374.34..132536.21 rows=9976 width=24) (actual time=231.239..421.464 rows=67113 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Sort  (cost=130374.32..130384.71 rows=4157 width=24) (actual time=183.274..184.924 rows=22371 loops=3)
              Sort Key: s.row_num, s.seat_num
              Sort Method: quicksort  Memory: 3251kB
              Worker 0:  Sort Method: quicksort  Memory: 2994kB
              Worker 1:  Sort Method: quicksort  Memory: 719kB
              ->  Nested Loop Left Join  (cost=6.05..130124.46 rows=4157 width=24) (actual time=0.144..174.539 rows=22371 loops=3)
                    ->  Parallel Seq Scan on seats s  (cost=0.00..7466.86 rows=247 width=24) (actual time=0.009..17.780 rows=198 loops=3)
                          Filter: (hall_id = 2)
                          Rows Removed by Filter: 197937
                    ->  Bitmap Heap Scan on tickets t  (cost=6.05..494.34 rows=225 width=16) (actual time=0.028..0.763 rows=112 loops=595)
                          Recheck Cond: (show_id = s.id)
                          Heap Blocks: exact=31651
                          ->  Bitmap Index Scan on ticket_show_id_idx  (cost=0.00..5.99 rows=225 width=0) (actual time=0.011..0.011 rows=112 loops=595)
                                Index Cond: (show_id = s.id)
  ->  Materialize  (cost=0.29..10.69 rows=1 width=8) (actual time=0.000..0.000 rows=1 loops=67113)
        ->  Index Scan using show_hall_id_idx on shows sh  (cost=0.29..10.69 rows=1 width=8) (actual time=0.044..8.053 rows=1 loops=1)
              Index Cond: (hall_id = 2)
              Filter: ((category_id = 1) AND ((begin_time)::date = CURRENT_DATE))
              Rows Removed by Filter: 86
Planning Time: 33.572 ms
Execution Time: 461.469 ms


 * Вывод - получаем улучшение с 225963.07 до 131232.70 за счет использования вместо  Parallel Seq Scan on tickets t Bitmap Index Scan on ticket_show_id_idx
 * также видим что используется добавленный ранее индекс show_hall_id_idx
 * */


CREATE INDEX ticket_show_id_idx ON public.tickets using btree (show_id);




/**  
 * Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
 * Aggregate  (cost=881.04..881.05 rows=1 width=16)
  ->  Nested Loop Left Join  (cost=6.47..881.04 rows=1 width=8)
        Join Filter: (s.id = t.show_id)
        ->  Index Only Scan using shows_pkey on shows s  (cost=0.29..4.31 rows=1 width=8)
              Index Cond: (id = 111)
        ->  Bitmap Heap Scan on tickets t  (cost=6.18..873.92 rows=225 width=16)
              Recheck Cond: (show_id = 111)
              ->  Bitmap Index Scan on ticket_show_id_idx  (cost=0.00..6.12 rows=225 width=0)
                    Index Cond: (show_id = 111)
  Вывод - добавленые ранее индексы уже используются планировщиком                  
 */
explain analyze select min(total_price), max(total_price) from shows s 
left join tickets t on s.id = t.show_id where s.id = 88;






/**
  отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
 *  public.movies	                2260 MB	2046 MB
    public.tickets	                1149 MB	651 MB
    public.sale_time_tickets_idx	214 MB	214 MB
    public.movies_pkey	            214 MB	214 MB
    public.tickets_pkey	            214 MB	214 MB
    public.ticket_show_id_idx	    69 MB	69 MB
    public.seats	                54 MB	34 MB
    public.seats_pkey	            16 MB	16 MB
    public.shows	                10 MB	6512 kB
    public.seat_hall_idx	        4040 kB	4040 kB
    public.shows_pkey	            1920 kB	1920 kB
    public.show_movie_id_idx	    648 kB	648 kB
    public.sells	                632 kB	448 kB
    public.show_hall_id_idx	        632 kB	632 kB
    public.begin_time_idx	        608 kB	608 kB
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
    shows_pkey	            10000015
    halls_pkey	            3654724
    seat_category_pkey	    903000
    movies_pkey	            285247
    show_categories_pkey	87000
 */
SELECT indexrelname index_name, idx_scan scan_count
FROM pg_catalog.pg_stat_user_indexes
where schemaname = 'public'
ORDER by idx_scan desc limit 5;


