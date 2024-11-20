# PHP_2024 HW10: Postgresql

> docker compose up -d --build
> docker exec -it postgresql psql -U otus -d otuscinema

##1. Выбор всех фильмов на сегодня
```sql
create view query_1 as
    select distinct film.title
        from film
            join showtime on film.id = showtime.film_id
        where date(showtime.start) = CURRENT_DATE
    order by film.title
;
```
DROP INDEX IF EXISTS IX_SHOWTIME_1;
DROP INDEX IF EXISTS IX_SHOWTIME_2;

EXPLAIN ANALYZE SELECT * from query_1;
```QUERY PLAN
Unique  (cost=268.15..268.40 rows=50 width=516) (actual time=3.664..4.132 rows=5 loops=1)
  ->  Sort  (cost=268.15..268.28 rows=50 width=516) (actual time=3.658..3.892 rows=120 loops=1)
        Sort Key: film.title
        Sort Method: quicksort  Memory: 27kB
        ->  Nested Loop  (cost=0.15..266.74 rows=50 width=516) (actual time=1.319..3.410 rows=120 loops=1)
              ->  Seq Scan on showtime  (cost=0.00..259.00 rows=50 width=4) (actual time=1.268..2.368 rows=120 loops=1)
                    Filter: (date(start) = CURRENT_DATE)
                    Rows Removed by Filter: 9880
              ->  Memoize  (cost=0.15..1.13 rows=1 width=520) (actual time=0.003..0.003 rows=1 loops=120)
                    Cache Key: showtime.film_id
                    Cache Mode: logical
                    Hits: 115  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                    ->  Index Scan using film_pkey on film  (cost=0.14..1.12 rows=1 width=520) (actual time=0.009..0.010 rows=1 loops=5)
                          Index Cond: (id = showtime.film_id)
Planning Time: 0.505 ms
Execution Time: 4.221 ms
```
CREATE INDEX IX_SHOWTIME_1 ON showtime (film_id);
CREATE INDEX IX_SHOWTIME_2 ON showtime (start);
В таблице есть внешний ключ по film_id, здесь скорее всего инжекс уже есть, так что второй скорее всего мешает, но попробуем.

EXPLAIN ANALYZE SELECT * from query_1;
```QUERY PLAN
Unique  (cost=268.15..268.40 rows=50 width=516) (actual time=3.601..4.217 rows=5 loops=1)
  ->  Sort  (cost=268.15..268.28 rows=50 width=516) (actual time=3.596..3.900 rows=120 loops=1)
        Sort Key: film.title
        Sort Method: quicksort  Memory: 27kB
        ->  Nested Loop  (cost=0.15..266.74 rows=50 width=516) (actual time=1.072..3.370 rows=120 loops=1)
              ->  Seq Scan on showtime  (cost=0.00..259.00 rows=50 width=4) (actual time=1.038..2.436 rows=120 loops=1)
                    Filter: (date(start) = CURRENT_DATE)
                    Rows Removed by Filter: 9880
              ->  Memoize  (cost=0.15..1.13 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=120)
                    Cache Key: showtime.film_id
                    Cache Mode: logical
                    Hits: 115  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                    ->  Index Scan using film_pkey on film  (cost=0.14..1.12 rows=1 width=520) (actual time=0.006..0.007 rows=1 loops=5)
                          Index Cond: (id = showtime.film_id)
Planning Time: 0.174 ms
Execution Time: 4.275 ms
```
Удалим один индекс
DROP INDEX IF EXISTS IX_SHOWTIME_1;

EXPLAIN ANALYZE SELECT * from query_1;
```QUERY PLAN
Unique  (cost=268.15..268.40 rows=50 width=516) (actual time=1.979..2.318 rows=5 loops=1)
  ->  Sort  (cost=268.15..268.28 rows=50 width=516) (actual time=1.975..2.141 rows=120 loops=1)
        Sort Key: film.title
        Sort Method: quicksort  Memory: 27kB
        ->  Nested Loop  (cost=0.15..266.74 rows=50 width=516) (actual time=0.489..1.796 rows=120 loops=1)
              ->  Seq Scan on showtime  (cost=0.00..259.00 rows=50 width=4) (actual time=0.469..1.013 rows=120 loops=1)
                    Filter: (date(start) = CURRENT_DATE)
                    Rows Removed by Filter: 9880
              ->  Memoize  (cost=0.15..1.13 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=120)
                    Cache Key: showtime.film_id
                    Cache Mode: logical
                    Hits: 115  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                    ->  Index Scan using film_pkey on film  (cost=0.14..1.12 rows=1 width=520) (actual time=0.003..0.003 rows=1 loops=5)
                          Index Cond: (id = showtime.film_id)
Planning Time: 0.217 ms
Execution Time: 2.355 ms
```
Вроде как улучшения есть, но неявные.

## 2. Подсчёт проданных билетов за неделю
```sql
create view query_2 as
    select count(*)
        from ticket
            join purchase on ticket.purchase_id = purchase.id
        where purchase.purchase_date >= current_date - interval '7 days' and purchase.purchase_date <= current_date;
;
```
EXPLAIN ANALYZE SELECT * from query_2;
```QUERY PLAN
Aggregate  (cost=1298.68..1298.69 rows=1 width=8) (actual time=147.203..147.219 rows=1 loops=1)
  ->  Hash Join  (cost=490.82..1290.00 rows=3472 width=0) (actual time=77.930..142.185 rows=3613 loops=1)
        Hash Cond: (ticket.purchase_id = purchase.id)
        ->  Seq Scan on ticket  (cost=0.00..688.69 rows=42069 width=4) (actual time=0.009..64.815 rows=42069 loops=1)
        ->  Hash  (cost=483.59..483.59 rows=578 width=4) (actual time=4.915..4.920 rows=582 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 29kB
              ->  Seq Scan on purchase  (cost=0.00..483.59 rows=578 width=4) (actual time=1.566..3.625 rows=582 loops=1)
                    Filter: ((purchase_date <= CURRENT_DATE) AND (purchase_date >= (CURRENT_DATE - '7 days'::interval)))
                    Rows Removed by Filter: 6422
Planning Time: 0.647 ms
Execution Time: 147.271 ms
```
Можно добавить индекс на purchase.purchase_date.
CREATE INDEX IX_PURCHASE_1 ON purchase (purchase_date);
```QUERY PLAN
Aggregate  (cost=861.22..861.23 rows=1 width=8) (actual time=150.188..150.203 rows=1 loops=1)
  ->  Hash Join  (cost=53.35..852.54 rows=3472 width=0) (actual time=82.331..145.421 rows=3613 loops=1)
        Hash Cond: (ticket.purchase_id = purchase.id)
        ->  Seq Scan on ticket  (cost=0.00..688.69 rows=42069 width=4) (actual time=0.009..67.947 rows=42069 loops=1)
        ->  Hash  (cost=46.13..46.13 rows=578 width=4) (actual time=2.320..2.326 rows=582 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 29kB
              ->  Index Scan using ix_purchase_1 on purchase  (cost=0.29..46.13 rows=578 width=4) (actual time=0.016..1.214 rows=582 loops=1)
                    Index Cond: ((purchase_date >= (CURRENT_DATE - '7 days'::interval)) AND (purchase_date <= CURRENT_DATE))
Planning Time: 0.288 ms
Execution Time: 150.246 ms
```
Вроде как улучшения есть, но неявные.

## 3. Формирование афиши (фильмы, которые показывают сегодня)
```sql  
create view query_3 as
    select film.id, film.title, showtime.start, showtime.end
        from film
            join showtime on film.id = showtime.film_id
        where date(showtime.start) = CURRENT_DATE
;
```
Разницы с первым запросом быть особо не должно: индексы уже созданы, запросы похожи, только здесь без группировки.
```QUERY PLAN
Nested Loop  (cost=0.15..266.74 rows=50 width=536) (actual time=1.612..4.336 rows=120 loops=1)
  ->  Seq Scan on showtime  (cost=0.00..259.00 rows=50 width=20) (actual time=1.572..3.109 rows=120 loops=1)
        Filter: (date(start) = CURRENT_DATE)
        Rows Removed by Filter: 9880
  ->  Memoize  (cost=0.15..1.13 rows=1 width=520) (actual time=0.003..0.003 rows=1 loops=120)
        Cache Key: showtime.film_id
        Cache Mode: logical
        Hits: 115  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
        ->  Index Scan using film_pkey on film  (cost=0.14..1.12 rows=1 width=520) (actual time=0.007..0.007 rows=1 loops=5)
              Index Cond: (id = showtime.film_id)
Planning Time: 0.283 ms
Execution Time: 4.672 ms
```
Различий с первым запросом почти не наблюдается. 
## 4. Поиск 3 самых прибыльных фильмов за неделю
```sql
create view query_4 as
    select film.title, t1.total_income
    from (
         select showtime.film_id, sum(ticket.price) as total_income
         from showtime
                  join ticket on showtime.id = ticket.showtime_id
         where date(showtime.start) between current_date - interval '7 days' AND CURRENT_DATE
         group by showtime.film_id
         order by total_income desc limit 3
    ) t1
    join film on t1.film_id = film.id
    order by t1.total_income desc
;
```
EXPLAIN ANALYZE SELECT * from query_4;
```QUERY PLAN
Nested Loop  (cost=915.80..929.86 rows=3 width=548) (actual time=64.167..64.256 rows=3 loops=1)
  Join Filter: (film.id = showtime.film_id)
  Rows Removed by Join Filter: 6
  ->  Limit  (cost=915.80..915.80 rows=3 width=36) (actual time=64.104..64.147 rows=3 loops=1)
        ->  Sort  (cost=915.80..915.81 rows=5 width=36) (actual time=64.099..64.127 rows=3 loops=1)
              Sort Key: (sum(ticket.price)) DESC
              Sort Method: quicksort  Memory: 25kB
              ->  GroupAggregate  (cost=914.10..915.74 rows=5 width=36) (actual time=50.309..64.083 rows=5 loops=1)
                    Group Key: showtime.film_id
                    ->  Sort  (cost=914.10..914.62 rows=210 width=9) (actual time=47.081..55.142 rows=4057 loops=1)
                          Sort Key: showtime.film_id
                          Sort Method: quicksort  Memory: 255kB
                          ->  Nested Loop  (cost=0.29..906.00 rows=210 width=9) (actual time=2.084..38.527 rows=4057 loops=1)
                                ->  Seq Scan on showtime  (cost=0.00..359.00 rows=50 width=8) (actual time=2.042..5.558 rows=960 loops=1)
                                      Filter: ((date(start) <= CURRENT_DATE) AND (date(start) >= (CURRENT_DATE - '7 days'::interval)))
                                      Rows Removed by Filter: 9040
                                ->  Index Scan using ticket_showtime_id_seat_id_key on ticket  (cost=0.29..10.90 rows=4 width=9) (actual time=0.004..0.013 rows=4 loops=960)
                                      Index Cond: (showtime_id = showtime.id)
  ->  Materialize  (cost=0.00..11.05 rows=70 width=520) (actual time=0.010..0.020 rows=3 loops=3)
        ->  Seq Scan on film  (cost=0.00..10.70 rows=70 width=520) (actual time=0.016..0.025 rows=4 loops=1)
Planning Time: 0.547 ms
Execution Time: 64.327 ms
```
А что если добавить функциональный индекс на showtime.start?!

```QUERY PLAN
Nested Loop  (cost=630.63..644.69 rows=3 width=548) (actual time=44.121..44.206 rows=3 loops=1)
  Join Filter: (film.id = showtime.film_id)
  Rows Removed by Join Filter: 6
  ->  Limit  (cost=630.63..630.64 rows=3 width=36) (actual time=44.059..44.094 rows=3 loops=1)
        ->  Sort  (cost=630.63..630.64 rows=5 width=36) (actual time=44.056..44.079 rows=3 loops=1)
              Sort Key: (sum(ticket.price)) DESC
              Sort Method: quicksort  Memory: 25kB
              ->  HashAggregate  (cost=630.51..630.57 rows=5 width=36) (actual time=44.017..44.045 rows=5 loops=1)
                    Group Key: showtime.film_id
                    Batches: 1  Memory Usage: 24kB
                    ->  Nested Loop  (cost=5.10..629.46 rows=210 width=9) (actual time=0.067..34.715 rows=4057 loops=1)
                          ->  Bitmap Heap Scan on showtime  (cost=4.81..82.46 rows=50 width=8) (actual time=0.053..2.016 rows=960 loops=1)
                                Recheck Cond: ((date(start) >= (CURRENT_DATE - '7 days'::interval)) AND (date(start) <= CURRENT_DATE))
                                Heap Blocks: exact=9
                                ->  Bitmap Index Scan on ix_showtime_3  (cost=0.00..4.79 rows=50 width=0) (actual time=0.040..0.042 rows=960 loops=1)
                                      Index Cond: ((date(start) >= (CURRENT_DATE - '7 days'::interval)) AND (date(start) <= CURRENT_DATE))
                          ->  Index Scan using ticket_showtime_id_seat_id_key on ticket  (cost=0.29..10.90 rows=4 width=9) (actual time=0.004..0.013 rows=4 loops=960)
                                Index Cond: (showtime_id = showtime.id)
  ->  Materialize  (cost=0.00..11.05 rows=70 width=520) (actual time=0.010..0.021 rows=3 loops=3)
        ->  Seq Scan on film  (cost=0.00..10.70 rows=70 width=520) (actual time=0.018..0.026 rows=4 loops=1)
Planning Time: 0.395 ms
Execution Time: 44.285 ms
```
Улучшения явные. 

## 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
```sql
create view query_5 as
    select seat.row_number, seat.seat_number,
           case when ticket.id is not null then '1'
                else '0'
               end as state
    from
        seat
            inner join showtime on seat.screen_id = showtime.screen_id
            left join ticket on showtime.id = ticket.showtime_id and seat.id = ticket.seat_id
    where showtime.id = 1
    order by
        seat.row_number,
        seat.seat_number
;
```
EXPLAIN ANALYZE SELECT * from query_5;
Везде используются сущетвующие индексы, так что улучшений не ожидается.
```QUERY PLAN
Sort  (cost=23.84..23.85 rows=1 width=1064) (actual time=0.123..0.146 rows=6 loops=1)
"  Sort Key: seat.row_number, seat.seat_number"
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop Left Join  (cost=0.72..23.83 rows=1 width=1064) (actual time=0.034..0.113 rows=6 loops=1)
        ->  Nested Loop  (cost=0.43..16.47 rows=1 width=1040) (actual time=0.021..0.057 rows=6 loops=1)
              ->  Index Scan using showtime_pkey on showtime  (cost=0.29..8.30 rows=1 width=8) (actual time=0.009..0.012 rows=1 loops=1)
                    Index Cond: (id = 1)
              ->  Index Scan using seat_screen_id_block_row_number_seat_number_key on seat  (cost=0.14..8.16 rows=1 width=1040) (actual time=0.005..0.016 rows=6 loops=1)
                    Index Cond: (screen_id = showtime.screen_id)
        ->  Index Scan using ticket_showtime_id_seat_id_key on ticket  (cost=0.29..7.35 rows=1 width=12) (actual time=0.003..0.004 rows=0 loops=6)
              Index Cond: ((showtime_id = 1) AND (seat_id = seat.id))
Planning Time: 0.225 ms
Execution Time: 0.192 ms
```

## 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
```sql
create view query_6 as
    select max(ticket.price), min(ticket.price)
    from ticket
    where ticket.showtime_id = 1
;
```
EXPLAIN ANALYZE SELECT * from query_6;
Везде используются сущетвующие индексы, так что улучшений не ожидается.
```QUERY PLAN
Aggregate  (cost=13.63..13.64 rows=1 width=64) (actual time=0.042..0.051 rows=1 loops=1)
  ->  Index Scan using ticket_showtime_id_seat_id_key on ticket  (cost=0.29..13.61 rows=4 width=5) (actual time=0.012..0.022 rows=3 loops=1)
        Index Cond: (showtime_id = 1)
Planning Time: 0.237 ms
Execution Time: 0.099 ms
```
