-- 1 Выбор всех фильмов на сегодня

SELECT * FROM movie WHERE CURRENT_DATE BETWEEN session_from AND session_to;

-- 10.000 строк в таблице movie

"Seq Scan on movie  (cost=0.00..324.20 rows=28 width=63) (actual time=0.022..2.036 rows=20 loops=1)"
"  Filter: ((CURRENT_DATE >= session_from) AND (CURRENT_DATE <= session_to))"
"  Rows Removed by Filter: 9990"
"Planning Time: 0.143 ms"
"Execution Time: 2.060 ms"

-- 1.000.000 строк в таблице movie

"Gather  (cost=1000.00..21690.23 rows=99 width=64) (actual time=127.819..129.744 rows=0 loops=1)"
"  Workers Planned: 2"
"  Workers Launched: 2"
"  ->  Parallel Seq Scan on movie  (cost=0.00..20680.33 rows=41 width=64) (actual time=118.538..118.538 rows=0 loops=3)"
"        Filter: ((CURRENT_DATE >= session_from) AND (CURRENT_DATE <= session_to))"
"        Rows Removed by Filter: 333333"
"Planning Time: 0.924 ms"
"Execution Time: 129.798 ms"

-- оптимизация

CREATE INDEX movie_from_to_idx ON movie (session_from, session_to);

-- результат: использования индекса

"Index Scan using movie_from_to_idx on movie  (cost=0.43..13981.42 rows=99 width=64) (actual time=24.551..24.553 rows=0 loops=1)"
"  Index Cond: ((session_from <= CURRENT_DATE) AND (session_to >= CURRENT_DATE))"
"Planning Time: 0.718 ms"
"Execution Time: 24.601 ms"