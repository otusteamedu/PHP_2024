--1. Выбор всех фильмов на сегодня

SELECT films.name from films
    Join cinema_shows on cinema_shows.film_id = films.id
    where cinema_shows.date = CURRENT_DATE
    order by films.name ASC;


---10_000 записей
/*
Sort  (cost=32.84..32.92 rows=33 width=516) (actual time=0.029..0.030 rows=0 loops=1)
   Sort Key: films.name
   Sort Method: quicksort  Memory: 25kB
   ->  Nested Loop  (cost=0.15..32.01 rows=33 width=516) (actual time=0.023..0.024 rows=0 loops=1)
         ->  Seq Scan on cinema_shows  (cost=0.00..28.00 rows=33 width=8) (actual time=0.023..0.023 rows=0 loops=1)
               Filter: (date = CURRENT_DATE)
               Rows Removed by Filter: 2
         ->  Memoize  (cost=0.15..1.63 rows=1 width=520) (never executed)
               Cache Key: cinema_shows.film_id
               Cache Mode: logical
               ->  Index Scan using films_pkey on films  (cost=0.14..1.62 rows=1 width=520) (never executed)
                     Index Cond: (id = cinema_shows.film_id)
 Planning Time: 0.162 ms
 Execution Time: 0.055 ms
(14 rows)
*/

--10_000_000 записей
/*
 Sort  (cost=13.66..13.74 rows=30 width=516) (actual time=3.400..3.404 rows=30 loops=1)
   Sort Key: films.name
   Sort Method: quicksort  Memory: 27kB
   ->  Nested Loop  (cost=0.15..12.93 rows=30 width=516) (actual time=0.083..0.118 rows=30 loops=1)
         ->  Seq Scan on cinema_shows  (cost=0.00..1.90 rows=30 width=8) (actual time=0.036..0.046 rows=30 loops=1)
               Filter: (date = CURRENT_DATE)
               Rows Removed by Filter: 30
         ->  Memoize  (cost=0.15..1.77 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=30)
               Cache Key: cinema_shows.film_id
               Cache Mode: logical
               Hits: 25  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
               ->  Index Scan using films_pkey on films  (cost=0.14..1.76 rows=1 width=520) (actual time=0.007..0.007 rows=1 loops=5)
                     Index Cond: (id = cinema_shows.film_id)
 Planning Time: 0.206 ms
 Execution Time: 3.453 ms
(15 rows)
*/

/* Предлагаемая оптимизация - добавить индекс на поле cinema_shows.date */

CREATE INDEX idx_cinema_shows_date ON cinema_shows(date);

/* результат для 10_000_000 записей после добавления индекса
 Sort  (cost=13.66..13.74 rows=30 width=516) (actual time=0.109..0.112 rows=30 loops=1)
   Sort Key: films.name
   Sort Method: quicksort  Memory: 27kB
   ->  Nested Loop  (cost=0.15..12.93 rows=30 width=516) (actual time=0.046..0.076 rows=30 loops=1)
         ->  Seq Scan on cinema_shows  (cost=0.00..1.90 rows=30 width=8) (actual time=0.013..0.021 rows=30 loops=1)
               Filter: (date = CURRENT_DATE)
               Rows Removed by Filter: 30
         ->  Memoize  (cost=0.15..1.77 rows=1 width=520) (actual time=0.001..0.001 rows=1 loops=30)
               Cache Key: cinema_shows.film_id
               Cache Mode: logical
               Hits: 25  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
               ->  Index Scan using films_pkey on films  (cost=0.14..1.76 rows=1 width=520) (actual time=0.006..0.006 rows=1 loops=5)
                     Index Cond: (id = cinema_shows.film_id)
 Planning Time: 0.462 ms
 Execution Time: 0.209 ms
(15 rows)
*/

/* вывод - добавление индекса сократило Execution Time с 3.453 ms до 0.209 ms*/