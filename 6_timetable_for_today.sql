EXPLAIN(SELECT movies.name, timetable.showtime
FROM movies
         JOIN timetable ON movies.id = timetable.movie_id
WHERE DATE(timetable.showtime) = '2024-07-27');

-- for 10000 rows
--Hash Join  (cost=1.09..206.35 rows=50 width=31)
--  Hash Cond: (timetable.movie_id = movies.id)
--  ->  Seq Scan on timetable  (cost=0.00..205.00 rows=50 width=12)
--        Filter: (date(showtime) = '2024-07-27'::date)
--  ->  Hash  (cost=1.04..1.04 rows=4 width=27)
--        ->  Seq Scan on movies  (cost=0.00..1.04 rows=4 width=27)

-- for 100000 rows
--Nested Loop  (cost=0.30..2285.71 rows=550 width=25)
--  ->  Seq Scan on timetable  (cost=0.00..2245.00 rows=550 width=12)
--        Filter: (date(showtime) = '2024-07-27'::date)
--  ->  Memoize  (cost=0.30..5.41 rows=1 width=21)
--        Cache Key: timetable.movie_id
--        Cache Mode: logical
--        ->  Index Scan using movies_pkey on movies  (cost=0.29..5.40 rows=1 width=21)
--              Index Cond: (id = timetable.movie_id)

-- создание простых индексов запрос не ускорило.
CREATE INDEX idx_timetable_movie_id ON timetable(movie_id);
CREATE INDEX idx_timetable_showtime2 ON timetable(showtime);

-- помог частичный индекс. Возможно, в каких то случаях это может рабоать, например, делать частичные индексы на последующий 5 днея расписания и потом их удалять
CREATE INDEX idx_timetable_showtime_partial ON timetable(showtime)
    WHERE DATE(showtime) = '2024-07-27';
--Merge Join  (cost=646.95..653.96 rows=550 width=25)
--    Merge Cond: (movies.id = timetable.movie_id)
--    ->  Index Scan using movies_pkey on movies  (cost=0.29..3674.35 rows=110004 width=21)
--    ->  Sort  (cost=645.28..646.65 rows=550 width=12)
--    Sort Key: timetable.movie_id
--    ->  Bitmap Heap Scan on timetable  (cost=4.27..620.24 rows=550 width=12)
--    Recheck Cond: (date(showtime) = '2024-07-27'::date)
--    ->  Bitmap Index Scan on idx_timetable_showtime_partial  (cost=0.00..4.13 rows=550 width=0)
