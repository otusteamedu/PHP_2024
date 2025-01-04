-------------------------------------1. Выбор всех фильмов на сегодня----------------------------------------------
EXPLAIN ANALYZE SELECT * FROM sessions
    WHERE date = CURRENT_DATE;

-- без индексов
---------------------------------------------QUERY PLAN----------------------------------------------------------
Gather  (cost=1000.00..139890.42 rows=27250 width=28) (actual time=15.143..488.457 rows=13814 loops=1)
   Workers Planned: 2
   Workers Launched: 2
   ->  Parallel Seq Scan on sessions  (cost=0.00..136165.42 rows=11354 width=28) (actual time=6.746..434.821 rows=4605 loops=3)
         Filter: (date = CURRENT_DATE)
         Rows Removed by Filter: 3332062
 Planning Time: 0.578 ms
 JIT:
   Functions: 6
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 3.197 ms (Deform 0.834 ms), Inlining 0.000 ms, Optimization 1.576 ms, Emission 18.112 ms, Total 22.886 ms
 Execution Time: 491.558 ms

-- с индексом
CREATE INDEX idx_date ON sessions (date);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Bitmap Heap Scan on sessions  (cost=307.62..54136.08 rows=27250 width=28) (actual time=4.815..21.550 rows=13814 loops=1)
   Recheck Cond: (date = CURRENT_DATE)
   Heap Blocks: exact=12615
   ->  Bitmap Index Scan on idx_date  (cost=0.00..300.81 rows=27250 width=0) (actual time=2.279..2.280 rows=13814 loops=1)
         Index Cond: (date = CURRENT_DATE)
 Planning Time: 0.158 ms
 Execution Time: 22.490 ms

-- Вывод: использование индекса повысило скорость запроса более чем в 21 раз (с учетом времени на запуск запроса) (0.578 + 491.558) / (0.158 + 22.490) = 21,72977746

DROP INDEX idx_date;


--------------------------------------- 2. Подсчёт проданных билетов за неделю----------------------------------------------
EXPLAIN ANALYZE SELECT count(*)
    FROM tickets t 
        JOIN sessions s ON t.session_id = s.id 
    WHERE s.date >= CURRENT_DATE - INTERVAL '7 days' AND s.date < CURRENT_DATE;

-- без индексов
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Finalize Aggregate  (cost=286091.41..286091.42 rows=1 width=8) (actual time=1537.203..1542.242 rows=1 loops=1)
   ->  Gather  (cost=286091.19..286091.40 rows=2 width=8) (actual time=1536.457..1542.213 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=285091.19..285091.20 rows=1 width=8) (actual time=1493.722..1493.725 rows=1 loops=3)
               ->  Parallel Hash Join  (cost=168471.45..284886.25 rows=81976 width=0) (actual time=690.740..1490.013 rows=63988 loops=3)
                     Hash Cond: (t.session_id = s.id)
                     ->  Parallel Seq Scan on tickets t  (cost=0.00..105466.36 rows=4170836 width=4) (actual time=0.097..337.789 rows=3336667 loops=3)
                     ->  Parallel Hash  (cost=167446.75..167446.75 rows=81976 width=4) (actual time=688.967..688.968 rows=63912 loops=3)
                           Buckets: 262144  Batches: 1  Memory Usage: 9600kB
                           ->  Parallel Seq Scan on sessions s  (cost=0.00..167446.75 rows=81976 width=4) (actual time=10.077..667.587 rows=63912 loops=3)
                                 Filter: ((date < CURRENT_DATE) AND (date >= (CURRENT_DATE - '7 days'::interval)))
                                 Rows Removed by Filter: 3272755
 Planning Time: 1.476 ms
 JIT:
   Functions: 41
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 5.180 ms (Deform 1.393 ms), Inlining 0.000 ms, Optimization 2.732 ms, Emission 27.544 ms, Total 35.456 ms
 Execution Time: 1545.818 ms

-- с индексом
CREATE INDEX idx_date ON sessions (date);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Finalize Aggregate  (cost=247818.45..247818.46 rows=1 width=8) (actual time=884.289..886.718 rows=1 loops=1)
   ->  Gather  (cost=247818.24..247818.45 rows=2 width=8) (actual time=883.841..886.706 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=246818.24..246818.25 rows=1 width=8) (actual time=862.054..862.056 rows=1 loops=3)
               ->  Parallel Hash Join  (cost=130198.49..246613.30 rows=81976 width=0) (actual time=355.447..858.824 rows=63988 loops=3)
                     Hash Cond: (t.session_id = s.id)
                     ->  Parallel Seq Scan on tickets t  (cost=0.00..105466.36 rows=4170836 width=4) (actual time=0.025..155.696 rows=3336667 loops=3)
                     ->  Parallel Hash  (cost=129173.79..129173.79 rows=81976 width=4) (actual time=354.668..354.669 rows=63912 loops=3)
                           Buckets: 262144  Batches: 1  Memory Usage: 9600kB
                           ->  Parallel Bitmap Heap Scan on sessions s  (cost=2685.06..129173.79 rows=81976 width=4) (actual time=31.752..338.441 rows=63912 loops=3)
                                 Recheck Cond: ((date >= (CURRENT_DATE - '7 days'::interval)) AND (date < CURRENT_DATE))
                                 Rows Removed by Index Recheck: 1467190
                                 Heap Blocks: exact=12159 lossy=11394
                                 ->  Bitmap Index Scan on idx_date  (cost=0.00..2635.87 rows=196743 width=0) (actual time=40.811..40.811 rows=191736 loops=1)
                                       Index Cond: ((date >= (CURRENT_DATE - '7 days'::interval)) AND (date < CURRENT_DATE))
 Planning Time: 0.643 ms
 JIT:
   Functions: 47
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 3.002 ms (Deform 0.861 ms), Inlining 0.000 ms, Optimization 1.143 ms, Emission 26.756 ms, Total 30.901 ms
 Execution Time: 887.941 ms

-- Вывод: использование индекса idx_date повысило скорость запроса почти в 2 раза (1.476 + 1545.818) / (0.643 + 887.941) = 1,74130302

-- с индексами
CREATE INDEX idx_date ON sessions (date);
CREATE INDEX idx_tsid on tickets (session_id);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Finalize Aggregate  (cost=210667.07..210667.08 rows=1 width=8) (actual time=479.231..481.812 rows=1 loops=1)
   ->  Gather  (cost=210666.85..210667.06 rows=2 width=8) (actual time=478.996..481.802 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=209666.85..209666.86 rows=1 width=8) (actual time=462.185..462.187 rows=1 loops=3)
               ->  Nested Loop  (cost=2685.49..209461.91 rows=81976 width=0) (actual time=18.765..458.683 rows=63988 loops=3)
                     ->  Parallel Bitmap Heap Scan on sessions s  (cost=2685.06..129173.79 rows=81976 width=4) (actual time=16.379..294.628 rows=63912 loops=3)
                           Recheck Cond: ((date >= (CURRENT_DATE - '7 days'::interval)) AND (date < CURRENT_DATE))
                           Rows Removed by Index Recheck: 1467190
                           Heap Blocks: exact=11622 lossy=11204
                           ->  Bitmap Index Scan on idx_date  (cost=0.00..2635.87 rows=196743 width=0) (actual time=27.401..27.401 rows=191736 loops=1)
                                 Index Cond: ((date >= (CURRENT_DATE - '7 days'::interval)) AND (date < CURRENT_DATE))
                     ->  Index Only Scan using idx_tsid on tickets t  (cost=0.43..0.96 rows=2 width=4) (actual time=0.002..0.002 rows=1 loops=191736)
                           Index Cond: (session_id = s.id)
                           Heap Fetches: 0
 Planning Time: 0.422 ms
 JIT:
   Functions: 29
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 1.776 ms (Deform 0.203 ms), Inlining 0.000 ms, Optimization 0.794 ms, Emission 12.275 ms, Total 14.845 ms
 Execution Time: 482.481 ms

 -- Вывод: использование индексов idx_date и idx_tsid повысило скорость запроса более чем в 3 раза (1.476 + 1545.818) / (0.422 + 482.481) = 3,20415073

DROP INDEX idx_date;
DROP INDEX idx_tsid;

---------------------------------------3. Формирование афиши (фильмы, которые показывают сегодня)----------------------------------------------
EXPLAIN ANALYZE SELECT m.name, s.begin_time, s.duration
    FROM sessions s 
        JOIN movies m ON s.movie_id = m.id 
    WHERE date = CURRENT_DATE;

-- с индексом PK (movies_pkey)
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Gather  (cost=1000.43..212882.19 rows=27250 width=28) (actual time=19.268..614.559 rows=13814 loops=1)
   Workers Planned: 2
   Workers Launched: 2
   ->  Nested Loop  (cost=0.43..209157.19 rows=11354 width=28) (actual time=10.128..571.612 rows=4605 loops=3)
         ->  Parallel Seq Scan on sessions s  (cost=0.00..136165.50 rows=11354 width=16) (actual time=9.975..409.650 rows=4605 loops=3)
               Filter: (date = CURRENT_DATE)
               Rows Removed by Filter: 3332062
         ->  Index Scan using movies_pkey on movies m  (cost=0.43..6.43 rows=1 width=20) (actual time=0.034..0.034 rows=1 loops=13814)
               Index Cond: (id = s.movie_id)
 Planning Time: 1.121 ms
 JIT:
   Functions: 24
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 3.522 ms (Deform 1.203 ms), Inlining 0.000 ms, Optimization 1.890 ms, Emission 27.745 ms, Total 33.158 ms
 Execution Time: 617.864 ms

-- с индексами PK (movies_pkey) и ...
CREATE INDEX idx_date ON sessions (date);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Gather  (cost=1308.06..130614.33 rows=27250 width=28) (actual time=19.195..103.713 rows=13814 loops=1)
   Workers Planned: 2
   Workers Launched: 2
   ->  Nested Loop  (cost=308.06..126889.33 rows=11354 width=28) (actual time=10.356..77.219 rows=4605 loops=3)
         ->  Parallel Bitmap Heap Scan on sessions s  (cost=307.62..53897.64 rows=11354 width=16) (actual time=6.259..27.834 rows=4605 loops=3)
               Recheck Cond: (date = CURRENT_DATE)
               Heap Blocks: exact=5542
               ->  Bitmap Index Scan on idx_date  (cost=0.00..300.81 rows=27250 width=0) (actual time=15.177..15.177 rows=13814 loops=1)
                     Index Cond: (date = CURRENT_DATE)
         ->  Index Scan using movies_pkey on movies m  (cost=0.43..6.43 rows=1 width=20) (actual time=0.009..0.009 rows=1 loops=13814)
               Index Cond: (id = s.movie_id)
 Planning Time: 0.525 ms
 JIT:
   Functions: 27
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 2.206 ms (Deform 1.000 ms), Inlining 0.000 ms, Optimization 1.086 ms, Emission 22.382 ms, Total 25.675 ms
 Execution Time: 105.517 ms

-- Вывод: увеличение производительности почти в 6 раз (1.121 + 617.864) / (0.525 + 105.517) = 5,83716829

DROP INDEX idx_date;

---------------------------------------4. Поиск 3 самых прибыльных фильма за неделю----------------------------------------------
EXPLAIN ANALYZE SELECT m.name, sum(t.price) AS total_price
    FROM movies m 
        JOIN sessions s ON m.id = s.movie_id 
        JOIN tickets t ON t.session_id = s.id 
    WHERE s.date >= CURRENT_DATE - INTERVAL '7 days' AND t.is_sold 
    GROUP BY m.id 
    ORDER BY total_price DESC 
        LIMIT 3;

-- с индексом PK (movies_pkey)
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Limit  (cost=351678.23..351678.24 rows=3 width=52) (actual time=1143.927..1145.578 rows=3 loops=1)
   ->  Sort  (cost=351678.23..351901.77 rows=89418 width=52) (actual time=1124.592..1126.242 rows=3 loops=1)
         Sort Key: (sum(t.price)) DESC
         Sort Method: top-N heapsort  Memory: 25kB
         ->  Finalize GroupAggregate  (cost=339499.77..350522.52 rows=89418 width=52) (actual time=1069.446..1118.029 rows=67706 loops=1)
               Group Key: m.id
               ->  Gather Merge  (cost=339499.77..348845.92 rows=74516 width=52) (actual time=1069.434..1091.674 rows=76951 loops=1)
                     Workers Planned: 2
                     Workers Launched: 2
                     ->  Partial GroupAggregate  (cost=338499.74..339244.90 rows=37258 width=52) (actual time=1052.167..1063.869 rows=25650 loops=3)
                           Group Key: m.id
                           ->  Sort  (cost=338499.74..338592.89 rows=37258 width=26) (actual time=1052.129..1053.989 rows=27385 loops=3)
                                 Sort Key: m.id
                                 Sort Method: quicksort  Memory: 2042kB
                                 Worker 0:  Sort Method: quicksort  Memory: 2037kB
                                 Worker 1:  Sort Method: quicksort  Memory: 2035kB
                                 ->  Nested Loop  (cost=147759.64..335670.88 rows=37258 width=26) (actual time=388.417..1045.934 rows=27385 loops=3)
                                       ->  Parallel Hash Join  (cost=147759.21..257596.16 rows=37258 width=10) (actual time=388.383..845.248 rows=27385 loops=3)
                                             Hash Cond: (t.session_id = s.id)
                                             ->  Parallel Seq Scan on tickets t  (cost=0.00..105466.33 rows=1664997 width=10) (actual time=0.038..197.203 rows=1335821 loops=3)
                                                   Filter: is_sold
                                                   Rows Removed by Filter: 2000845
                                             ->  Parallel Hash  (cost=146592.58..146592.58 rows=93330 width=8) (actual time=387.045..387.045 rows=68517 loops=3)
                                                   Buckets: 262144  Batches: 1  Memory Usage: 10144kB
                                                   ->  Parallel Seq Scan on sessions s  (cost=0.00..146592.58 rows=93330 width=8) (actual time=6.728..371.004 rows=68517 loops=3)
                                                         Filter: (date >= (CURRENT_DATE - '7 days'::interval))
                                                         Rows Removed by Filter: 3268150
                                       ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.10 rows=1 width=20) (actual time=0.007..0.007 rows=1 loops=82155)
                                             Index Cond: (id = s.movie_id)
 Planning Time: 1.399 ms
 JIT:
   Functions: 79
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 4.576 ms (Deform 1.848 ms), Inlining 0.000 ms, Optimization 1.615 ms, Emission 37.909 ms, Total 44.101 ms
 Execution Time: 1148.074 ms

-- с индексами PK (movies_pkey) и ...
CREATE INDEX idx_date ON sessions (date);
CREATE INDEX idx_price ON tickets (price);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Limit  (cost=322406.84..322406.85 rows=3 width=52) (actual time=1059.585..1061.492 rows=3 loops=1)
   ->  Sort  (cost=322406.84..322630.39 rows=89418 width=52) (actual time=1039.268..1041.175 rows=3 loops=1)
         Sort Key: (sum(t.price)) DESC
         Sort Method: top-N heapsort  Memory: 25kB
         ->  Finalize GroupAggregate  (cost=310228.38..321251.13 rows=89418 width=52) (actual time=984.522..1033.125 rows=67706 loops=1)
               Group Key: m.id
               ->  Gather Merge  (cost=310228.38..319574.54 rows=74516 width=52) (actual time=984.508..1006.902 rows=76940 loops=1)
                     Workers Planned: 2
                     Workers Launched: 2
                     ->  Partial GroupAggregate  (cost=309228.36..309973.52 rows=37258 width=52) (actual time=965.823..977.525 rows=25647 loops=3)
                           Group Key: m.id
                           ->  Sort  (cost=309228.36..309321.50 rows=37258 width=26) (actual time=965.799..967.654 rows=27385 loops=3)
                                 Sort Key: m.id
                                 Sort Method: quicksort  Memory: 2019kB
                                 Worker 0:  Sort Method: quicksort  Memory: 2044kB
                                 Worker 1:  Sort Method: quicksort  Memory: 2051kB
                                 ->  Nested Loop  (cost=118488.26..306399.49 rows=37258 width=26) (actual time=330.548..960.366 rows=27385 loops=3)
                                       ->  Parallel Hash Join  (cost=118487.82..228324.77 rows=37258 width=10) (actual time=330.520..773.097 rows=27385 loops=3)
                                             Hash Cond: (t.session_id = s.id)
                                             ->  Parallel Seq Scan on tickets t  (cost=0.00..105466.33 rows=1664997 width=10) (actual time=0.034..196.314 rows=1335821 loops=3)
                                                   Filter: is_sold
                                                   Rows Removed by Filter: 2000845
                                             ->  Parallel Hash  (cost=117321.20..117321.20 rows=93330 width=8) (actual time=329.454..329.455 rows=68517 loops=3)
                                                   Buckets: 262144  Batches: 1  Memory Usage: 10112kB
                                                   ->  Parallel Bitmap Heap Scan on sessions s  (cost=2496.39..117321.20 rows=93330 width=8) (actual time=26.244..313.045 rows=68517 loops=3)
                                                         Recheck Cond: (date >= (CURRENT_DATE - '7 days'::interval))
                                                         Rows Removed by Index Recheck: 1465236
                                                         Heap Blocks: exact=12468 lossy=11467
                                                         ->  Bitmap Index Scan on idx_date  (cost=0.00..2440.39 rows=223993 width=0) (actual time=30.342..30.342 rows=205550 loops=1)
                                                               Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))
                                       ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.10 rows=1 width=20) (actual time=0.007..0.007 rows=1 loops=82155)
                                             Index Cond: (id = s.movie_id)
 Planning Time: 0.820 ms
 JIT:
   Functions: 82
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 5.321 ms (Deform 1.932 ms), Inlining 0.000 ms, Optimization 1.468 ms, Emission 36.664 ms, Total 43.452 ms
 Execution Time: 1064.162 ms

-- Вывод: очень незначительное увеличение производительности

DROP INDEX idx_date;
DROP INDEX idx_price;

---------------------------------------5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс----------------------------------------------
EXPLAIN ANALYZE SELECT h.number AS hall_number,
       m.name AS movie_name,
       t.seat_number AS seat_number,
       t.price AS price,
       CASE
            WHEN t.is_sold THEN 'Занято'
            ELSE 'Свободно'
            END AS seat_status
    FROM halls h
        JOIN sessions s ON h.id = s.hall_id
        JOIN tickets t ON s.id = t.session_id
        JOIN movies m ON m.id = s.movie_id
    WHERE s.id = <sessionID>;

-- с индексами PK (sessions_pkey, halls_pkey, movies_pkey)
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Gather  (cost=1001.30..116918.98 rows=2 width=62) (actual time=17.074..414.499 rows=2 loops=1)
   Workers Planned: 2
   Workers Launched: 2
   ->  Nested Loop  (cost=1.30..115918.78 rows=1 width=62) (actual time=245.189..376.773 rows=1 loops=3)
         ->  Nested Loop  (cost=0.87..115910.33 rows=1 width=19) (actual time=245.163..376.745 rows=1 loops=3)
               ->  Parallel Seq Scan on tickets t  (cost=0.00..115893.42 rows=1 width=15) (actual time=245.078..376.656 rows=1 loops=3)
                     Filter: (session_id = 102)
                     Rows Removed by Filter: 3336666
               ->  Nested Loop  (cost=0.87..16.91 rows=1 width=12) (actual time=0.127..0.128 rows=1 loops=2)
                     ->  Index Scan using sessions_pkey on sessions s  (cost=0.43..8.45 rows=1 width=12) (actual time=0.096..0.097 rows=1 loops=2)
                           Index Cond: (id = 102)
                     ->  Index Scan using halls_pkey on halls h  (cost=0.43..8.45 rows=1 width=8) (actual time=0.020..0.020 rows=1 loops=2)
                           Index Cond: (id = s.hall_id)
         ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=20) (actual time=0.035..0.035 rows=1 loops=2)
               Index Cond: (id = s.movie_id)
 Planning Time: 1.252 ms
 JIT:
   Functions: 51
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 4.482 ms (Deform 1.513 ms), Inlining 0.000 ms, Optimization 2.336 ms, Emission 24.683 ms, Total 31.501 ms
 Execution Time: 417.388 ms

-- с индексами PK (sessions_pkey, halls_pkey, movies_pkey) и ...
CREATE INDEX idx_session_id ON tickets (session_id);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Nested Loop  (cost=1.74..37.85 rows=2 width=62) (actual time=0.043..0.047 rows=2 loops=1)
   ->  Nested Loop  (cost=1.30..25.36 rows=1 width=24) (actual time=0.032..0.033 rows=1 loops=1)
         ->  Nested Loop  (cost=0.87..16.91 rows=1 width=12) (actual time=0.025..0.025 rows=1 loops=1)
               ->  Index Scan using sessions_pkey on sessions s  (cost=0.43..8.45 rows=1 width=12) (actual time=0.015..0.016 rows=1 loops=1)
                     Index Cond: (id = 102)
               ->  Index Scan using halls_pkey on halls h  (cost=0.43..8.45 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)
                     Index Cond: (id = s.hall_id)
         ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=20) (actual time=0.006..0.006 rows=1 loops=1)
               Index Cond: (id = s.movie_id)
   ->  Index Scan using idx_session_id on tickets t  (cost=0.43..12.47 rows=2 width=15) (actual time=0.008..0.011 rows=2 loops=1)
         Index Cond: (session_id = 102)
 Planning Time: 0.337 ms
 Execution Time: 0.114 ms

-- Вывод: увеличение производительности почти в 930 раз (1.252 + 417.388) / (0.337 + 0.114) = 928,24833703

DROP INDEX idx_session_id;

 ---------------------------------------6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс----------------------------------------------
EXPLAIN ANALYZE SELECT MIN(price) AS min_price,
       MAX(price) AS man_price
    FROM sessions s
        JOIN tickets t ON s.id = t.session_id
    WHERE s.id = <sessionID>;

-- с индексм PK (sessions_pkey)
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Aggregate  (cost=116898.09..116898.10 rows=1 width=64) (actual time=154.923..156.688 rows=1 loops=1)
   ->  Gather  (cost=1000.43..116898.08 rows=2 width=6) (actual time=39.531..156.661 rows=2 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Nested Loop  (cost=0.43..115897.88 rows=1 width=6) (actual time=97.817..136.228 rows=1 loops=3)
               ->  Parallel Seq Scan on tickets t  (cost=0.00..115893.42 rows=1 width=10) (actual time=97.791..136.201 rows=1 loops=3)
                     Filter: (session_id = 102)
                     Rows Removed by Filter: 3336666
               ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.027..0.027 rows=1 loops=2)
                     Index Cond: (id = 102)
                     Heap Fetches: 0
 Planning Time: 0.239 ms
 JIT:
   Functions: 17
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 1.807 ms (Deform 0.550 ms), Inlining 0.000 ms, Optimization 0.838 ms, Emission 16.455 ms, Total 19.101 ms
 Execution Time: 157.861 ms

 -- с индексами PK (sessions_pkey) и ...
CREATE INDEX idx_session_id ON tickets (session_id);
CREATE INDEX idx_price ON tickets (price);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Aggregate  (cost=16.95..16.96 rows=1 width=64) (actual time=0.071..0.072 rows=1 loops=1)
   ->  Nested Loop  (cost=0.87..16.94 rows=2 width=6) (actual time=0.055..0.060 rows=2 loops=1)
         ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.43..4.45 rows=1 width=4) (actual time=0.036..0.036 rows=1 loops=1)
               Index Cond: (id = 102)
               Heap Fetches: 0
         ->  Index Scan using idx_session_id on tickets t  (cost=0.43..12.47 rows=2 width=10) (actual time=0.016..0.020 rows=2 loops=1)
               Index Cond: (session_id = 102)
 Planning Time: 0.174 ms
 Execution Time: 0.112 ms

-- Вывод: увеличение производительности в 552 раза (0.239 + 157.861) / (0.174 + 0.112) = 552,7972028