-- Выбор фильмов на сегодня
SELECT s.film_id
FROM tbl_show s
WHERE s."date" = CURRENT_DATE;


/*
< 10000 записей
Seq Scan on tbl_show s  (cost=0.00..185.02 rows=22 width=4) (actual time=1.315..1.323 rows=20 loops=1)
  Filter: (date = CURRENT_DATE)
  Rows Removed by Filter: 8248
Planning Time: 0.103 ms
Execution Time: 1.332 ms

Добавил индекс tbl_show_date_idx Запрос стал оптимальным
Index Scan using tbl_show_date_idx on tbl_show s  (cost=0.29..8.67 rows=22 width=4) (actual time=0.011..0.028 rows=20 loops=1)
  Index Cond: (date = CURRENT_DATE)
Planning Time: 0.177 ms
Execution Time: 0.052 ms
*/

