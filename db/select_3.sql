---3. Формирование афиши (фильмы, которые показывают сегодня)

SELECT films.name, cinema_shows.start, halls.name from films 
    JOIN cinema_shows on cinema_shows.film_id = films.id
    JOIN halls on halls.id = cinema_shows.hall_id
    WHERE cinema_shows.date = CURRENT_DATE
    order by cinema_shows.start;

---10_000 записей
/*
 Sort  (cost=36.84..36.93 rows=33 width=1040) (actual time=0.031..0.032 rows=0 loops=1)
   Sort Key: cinema_shows.start
   Sort Method: quicksort  Memory: 25kB
   ->  Nested Loop  (cost=0.31..36.01 rows=33 width=1040) (actual time=0.007..0.008 rows=0 loops=1)
         ->  Nested Loop  (cost=0.15..32.01 rows=33 width=532) (actual time=0.007..0.008 rows=0 loops=1)
               ->  Seq Scan on cinema_shows  (cost=0.00..28.00 rows=33 width=24) (actual time=0.007..0.007 rows=0 loops=1)
                     Filter: (date = CURRENT_DATE)
                     Rows Removed by Filter: 2
               ->  Memoize  (cost=0.15..1.63 rows=1 width=520) (never executed)
                     Cache Key: cinema_shows.film_id
                     Cache Mode: logical
                     ->  Index Scan using films_pkey on films  (cost=0.14..1.62 rows=1 width=520) (never executed)
                           Index Cond: (id = cinema_shows.film_id)
         ->  Memoize  (cost=0.15..1.63 rows=1 width=520) (never executed)
               Cache Key: cinema_shows.hall_id
               Cache Mode: logical
               ->  Index Scan using halls_pkey on halls  (cost=0.14..1.62 rows=1 width=520) (never executed)
                     Index Cond: (id = cinema_shows.hall_id)
 Planning Time: 0.395 ms
 Execution Time: 0.072 ms
(20 rows)
*/

--10_000_000 записей
/*
 Sort  (cost=21.28..21.36 rows=30 width=1040) (actual time=0.498..0.501 rows=30 loops=1)
   Sort Key: cinema_shows.start
   Sort Method: quicksort  Memory: 27kB
   ->  Nested Loop  (cost=0.31..20.54 rows=30 width=1040) (actual time=0.396..0.463 rows=30 loops=1)
         ->  Nested Loop  (cost=0.15..12.93 rows=30 width=532) (actual time=0.042..0.072 rows=30 loops=1)
               ->  Seq Scan on cinema_shows  (cost=0.00..1.90 rows=30 width=24) (actual time=0.031..0.039 rows=30 loops=1)
                     Filter: (date = CURRENT_DATE)
                     Rows Removed by Filter: 30
               ->  Memoize  (cost=0.15..1.77 rows=1 width=520) (actual time=0.001..0.001 rows=1 loops=30)
                     Cache Key: cinema_shows.film_id
                     Cache Mode: logical
                     Hits: 25  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                     ->  Index Scan using films_pkey on films  (cost=0.14..1.76 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=5)
                           Index Cond: (id = cinema_shows.film_id)
         ->  Memoize  (cost=0.15..1.77 rows=1 width=520) (actual time=0.012..0.012 rows=1 loops=30)
               Cache Key: cinema_shows.hall_id
               Cache Mode: logical
               Hits: 27  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
               ->  Index Scan using halls_pkey on halls  (cost=0.14..1.76 rows=1 width=520) (actual time=0.118..0.118 rows=1 loops=3)
                     Index Cond: (id = cinema_shows.hall_id)
 Planning Time: 1.202 ms
 Execution Time: 0.535 ms
(22 rows)
*/

/* Для этого запроса оптимизация была произведена в select_1 (добавлен индекс на cinema_shows.date) */

/* результат для 10_000_000 записей после добавления индекса
 Sort  (cost=21.28..21.36 rows=30 width=1040) (actual time=0.153..0.156 rows=30 loops=1)
   Sort Key: cinema_shows.start
   Sort Method: quicksort  Memory: 27kB
   ->  Nested Loop  (cost=0.31..20.54 rows=30 width=1040) (actual time=0.067..0.117 rows=30 loops=1)
         ->  Nested Loop  (cost=0.15..12.93 rows=30 width=532) (actual time=0.024..0.056 rows=30 loops=1)
               ->  Seq Scan on cinema_shows  (cost=0.00..1.90 rows=30 width=24) (actual time=0.011..0.019 rows=30 loops=1)
                     Filter: (date = CURRENT_DATE)
                     Rows Removed by Filter: 30
               ->  Memoize  (cost=0.15..1.77 rows=1 width=520) (actual time=0.001..0.001 rows=1 loops=30)
                     Cache Key: cinema_shows.film_id
                     Cache Mode: logical
                     Hits: 25  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                     ->  Index Scan using films_pkey on films  (cost=0.14..1.76 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=5)
                           Index Cond: (id = cinema_shows.film_id)
         ->  Memoize  (cost=0.15..1.77 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=30)
               Cache Key: cinema_shows.hall_id
               Cache Mode: logical
               Hits: 27  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
               ->  Index Scan using halls_pkey on halls  (cost=0.14..1.76 rows=1 width=520) (actual time=0.014..0.014 rows=1 loops=3)
                     Index Cond: (id = cinema_shows.hall_id)
 Planning Time: 0.812 ms
 Execution Time: 0.212 ms
(22 rows)
*/

/* вывод - добавление индекса сократило Execution Time c 0.535 ms до 0.212 ms */