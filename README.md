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
Вроже как улучшения есть, но неявные.
