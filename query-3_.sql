-- 3 Формирование афиши (фильмы, которые показывают сегодня)

SELECT 
	movie.title AS фильм, 
	TO_CHAR(schedule.time_begin, 'HH24:MI') AS "начало сеанса",
	hall.title AS зал
FROM movie movie 
JOIN schedule schedule ON schedule.movie_id = movie.id
JOIN hall hall ON hall.id = schedule.hall_id
WHERE schedule.time_begin::DATE = CURRENT_DATE
ORDER BY schedule.time_begin, movie.title;

-- 10.000 строк в таблицах movie и schedule

"Sort  (cost=276.80..276.92 rows=50 width=184) (actual time=0.894..0.896 rows=0 loops=1)"
"  Sort Key: schedule.time_begin, movie.title"
"  Sort Method: quicksort  Memory: 25kB"
"  ->  Nested Loop  (cost=260.85..275.39 rows=50 width=184) (actual time=0.883..0.884 rows=0 loops=1)"
"        ->  Merge Join  (cost=260.70..261.87 rows=50 width=38) (actual time=0.883..0.883 rows=0 loops=1)"
"              Merge Cond: (movie.id = schedule.movie_id)"
"              ->  Index Scan using movie_pkey on movie  (cost=0.29..397.29 rows=10000 width=30) (actual time=0.006..0.006 rows=1 loops=1)"
"              ->  Sort  (cost=260.41..260.54 rows=50 width=16) (actual time=0.875..0.875 rows=0 loops=1)"
"                    Sort Key: schedule.movie_id"
"                    Sort Method: quicksort  Memory: 25kB"
"                    ->  Seq Scan on schedule  (cost=0.00..259.00 rows=50 width=16) (actual time=0.872..0.872 rows=0 loops=1)"
"                          Filter: ((time_begin)::date = CURRENT_DATE)"
"                          Rows Removed by Filter: 10000"
"        ->  Memoize  (cost=0.16..1.14 rows=1 width=122) (never executed)"
"              Cache Key: schedule.hall_id"
"              Cache Mode: logical"
"              ->  Index Scan using hall_pkey on hall  (cost=0.15..1.12 rows=1 width=122) (never executed)"
"                    Index Cond: (id = schedule.hall_id)"
"Planning Time: 0.255 ms"
"Execution Time: 0.926 ms"

-- 1.000.000 строк в таблицах movie и schedule

"Gather Merge  (cost=16889.24..17375.31 rows=4166 width=185) (actual time=28.670..30.367 rows=0 loops=1)"
"  Workers Planned: 2"
"  Workers Launched: 2"
"  ->  Sort  (cost=15889.22..15894.43 rows=2083 width=185) (actual time=26.472..26.474 rows=0 loops=3)"
"        Sort Key: schedule.time_begin, movie.title"
"        Sort Method: quicksort  Memory: 25kB"
"        Worker 0:  Sort Method: quicksort  Memory: 25kB"
"        Worker 1:  Sort Method: quicksort  Memory: 25kB"
"        ->  Hash Join  (cost=21.91..15774.40 rows=2083 width=185) (actual time=26.444..26.446 rows=0 loops=3)"
"              Hash Cond: (schedule.hall_id = hall.id)"
"              ->  Nested Loop  (cost=0.43..15742.20 rows=2083 width=39) (actual time=26.443..26.444 rows=0 loops=3)"
"                    ->  Parallel Seq Scan on schedule  (cost=0.00..15625.67 rows=2083 width=16) (actual time=26.442..26.442 rows=0 loops=3)"
"                          Filter: ((time_begin)::date = CURRENT_DATE)"
"                          Rows Removed by Filter: 333333"
"                    ->  Memoize  (cost=0.43..5.87 rows=1 width=31) (never executed)"
"                          Cache Key: schedule.movie_id"
"                          Cache Mode: logical"
"                          ->  Index Scan using movie_pkey on movie  (cost=0.42..5.86 rows=1 width=31) (never executed)"
"                                Index Cond: (id = schedule.movie_id)"
"              ->  Hash  (cost=15.10..15.10 rows=510 width=122) (never executed)"
"                    ->  Seq Scan on hall  (cost=0.00..15.10 rows=510 width=122) (never executed)"
"Planning Time: 0.491 ms"
"Execution Time: 30.408 ms"

/*
	Оптимизация: 

	индексы на поле schedul.teime_begin ситуацию никак не улучшили, однако, зная структуру таблицы schedule,
	в которой расписание сеансев уходит в "глубь веков", а афиша - это настоящее время, прихожу к выводу, что партиционирование может помочь.
	Создаю партиции (query-3_partition.sql) на истекшие года и одну партицию schedule_current исключительно на текущий год, переношу расписание в новую таблицу,
	обращаюсь в запросе к schedule_part (таблица-фасад):
*/

"Gather Merge  (cost=31991.09..32477.16 rows=4166 width=185) (actual time=39.148..42.118 rows=0 loops=1)"
"  Workers Planned: 2"
"  Workers Launched: 2"
"  ->  Sort  (cost=30991.06..30996.27 rows=2083 width=185) (actual time=36.093..36.098 rows=0 loops=3)"
"        Sort Key: schedule.time_begin, movie.title"
"        Sort Method: quicksort  Memory: 25kB"
"        Worker 0:  Sort Method: quicksort  Memory: 25kB"
"        Worker 1:  Sort Method: quicksort  Memory: 25kB"
"        ->  Hash Join  (cost=21.90..30876.24 rows=2083 width=185) (actual time=36.069..36.073 rows=0 loops=3)"
"              Hash Cond: (schedule.hall_id = hall.id)"
"              ->  Nested Loop  (cost=0.42..30844.05 rows=2083 width=39) (actual time=36.068..36.071 rows=0 loops=3)"
"                    ->  Parallel Append  (cost=0.00..18642.52 rows=2081 width=16) (actual time=36.050..36.052 rows=0 loops=3)"
"                          ->  Parallel Seq Scan on schedule_up_1980 schedule_1  (cost=0.00..3747.66 rows=592 width=16) (actual time=22.632..22.632 rows=0 loops=1)"
"                                Filter: ((time_begin)::date = CURRENT_DATE)"
"                                Rows Removed by Filter: 201150"
"                          ->  Parallel Seq Scan on schedule_up_2000 schedule_3  (cost=0.00..3403.22 rows=537 width=16) (actual time=20.425..20.425 rows=0 loops=1)"
"                                Filter: ((time_begin)::date = CURRENT_DATE)"
"                                Rows Removed by Filter: 182650"
"                          ->  Parallel Seq Scan on schedule_up_2020 schedule_5  (cost=0.00..3403.22 rows=537 width=16) (actual time=6.208..6.209 rows=0 loops=3)"
"                                Filter: ((time_begin)::date = CURRENT_DATE)"
"                                Rows Removed by Filter: 60883"
"                          ->  Parallel Seq Scan on schedule_up_1990 schedule_2  (cost=0.00..3401.71 rows=537 width=16) (actual time=9.321..9.321 rows=0 loops=2)"
"                                Filter: ((time_begin)::date = CURRENT_DATE)"
"                                Rows Removed by Filter: 91300"
"                          ->  Parallel Seq Scan on schedule_up_2010 schedule_4  (cost=0.00..3401.71 rows=537 width=16) (actual time=18.847..18.847 rows=0 loops=1)"
"                                Filter: ((time_begin)::date = CURRENT_DATE)"
"                                Rows Removed by Filter: 182600"
"                          ->  Parallel Seq Scan on schedule_up_2030 schedule_6  (cost=0.00..1020.60 rows=161 width=16) (actual time=7.464..7.465 rows=0 loops=1)"
"                                Filter: ((time_begin)::date = CURRENT_DATE)"
"                                Rows Removed by Filter: 54750"
"                          ->  Parallel Seq Scan on schedule_current schedule_7  (cost=0.00..254.00 rows=40 width=16) (actual time=1.496..1.496 rows=0 loops=1)"
"                                Filter: ((time_begin)::date = CURRENT_DATE)"
"                                Rows Removed by Filter: 13600"
"                    ->  Index Scan using movie_pkey on movie  (cost=0.42..5.86 rows=1 width=31) (never executed)"
"                          Index Cond: (id = schedule.movie_id)"
"              ->  Hash  (cost=15.10..15.10 rows=510 width=122) (never executed)"
"                    ->  Seq Scan on hall  (cost=0.00..15.10 rows=510 width=122) (never executed)"
"Planning Time: 1.093 ms"
"Execution Time: 42.179 ms"

-- к сожалению, ничего не меняется, тогда зная, как называется партиция с расписанием на текущий год, делаю запрос сразу к schedule_current (таблица-партиция)
"Sort  (cost=369.35..369.52 rows=68 width=185) (actual time=4.330..4.337 rows=0 loops=1)"
"  Sort Key: schedule.time_begin, movie.title"
"  Sort Method: quicksort  Memory: 25kB"
"  ->  Nested Loop  (cost=354.65..367.28 rows=68 width=185) (actual time=4.318..4.324 rows=0 loops=1)"
"        ->  Merge Join  (cost=354.49..355.96 rows=68 width=39) (actual time=4.316..4.320 rows=0 loops=1)"
"              Merge Cond: (movie.id = schedule.movie_id)"
"              ->  Index Scan using movie_pkey on movie  (cost=0.42..38330.43 rows=1000000 width=31) (actual time=0.017..0.019 rows=1 loops=1)"
"              ->  Sort  (cost=354.07..354.24 rows=68 width=16) (actual time=4.296..4.297 rows=0 loops=1)"
"                    Sort Key: schedule.movie_id"
"                    Sort Method: quicksort  Memory: 25kB"
"                    ->  Seq Scan on schedule_current schedule  (cost=0.00..352.00 rows=68 width=16) (actual time=4.285..4.285 rows=0 loops=1)"
"                          Filter: ((time_begin)::date = CURRENT_DATE)"
"                          Rows Removed by Filter: 13600"
"        ->  Memoize  (cost=0.16..0.88 rows=1 width=122) (never executed)"
"              Cache Key: schedule.hall_id"
"              Cache Mode: logical"
"              ->  Index Scan using hall_pkey on hall  (cost=0.15..0.87 rows=1 width=122) (never executed)"
"                    Index Cond: (id = schedule.hall_id)"
"Planning Time: 0.573 ms"
"Execution Time: 4.437 ms"

-- время выполния запроса выросло в 10 раз
