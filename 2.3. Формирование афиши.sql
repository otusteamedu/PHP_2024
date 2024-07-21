/**
    Первоначальный запрос
 */
SELECT m.id         AS movie_id,
       m.title      AS movie_title,
       g.name       AS genre_name,
       s.start_time AS session_start_time,
       c.name       AS cinema_name
FROM movies m
         JOIN sessions s ON m.id = s.movie_id
         JOIN halls h ON s.hall_id = h.id
         JOIN cinemas c ON h.cinema_id = c.id
         JOIN genres g ON m.genre_id = g.id
WHERE DATE (s.start_time) = CURRENT_DATE;

/**
    Таблица с результатами

    +--------+-----------+----------+--------------------------+-----------+
    |movie_id|movie_title|genre_name|session_start_time        |cinema_name|
    +--------+-----------+----------+--------------------------+-----------+
    |751     |Movie 751  |Action    |2024-07-21 08:00:00.000000|Cinema 808 |
    |591     |Movie 591  |Horror    |2024-07-21 03:00:00.000000|Cinema 264 |
    |402     |Movie 402  |Comedy    |2024-07-21 20:00:00.000000|Cinema 323 |
    |672     |Movie 672  |Horror    |2024-07-21 10:00:00.000000|Cinema 952 |
    |136     |Movie 136  |Sci-Fi    |2024-07-21 23:00:00.000000|Cinema 157 |
    |791     |Movie 791  |Sci-Fi    |2024-07-21 14:00:00.000000|Cinema 359 |
    |719     |Movie 719  |Comedy    |2024-07-21 23:00:00.000000|Cinema 631 |
    |477     |Movie 477  |Comedy    |2024-07-21 06:00:00.000000|Cinema 215 |
    |46      |Movie 46   |Horror    |2024-07-21 11:00:00.000000|Cinema 968 |
    +--------+-----------+----------+--------------------------+-----------+
 */

/**
    План выполнения ~ 10.000 данных

    +--------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                            |
    +--------------------------------------------------------------------------------------------------------------------------------------+
    |Nested Loop  (cost=93.92..360.77 rows=50 width=249) (actual time=2.211..4.796 rows=225 loops=1)                                       |
    |  ->  Nested Loop  (cost=93.78..358.69 rows=50 width=35) (actual time=2.192..4.661 rows=225 loops=1)                                  |
    |        ->  Hash Join  (cost=93.50..342.76 rows=50 width=29) (actual time=2.169..4.131 rows=225 loops=1)                              |
    |              Hash Cond: (s.hall_id = h.id)                                                                                           |
    |              ->  Hash Join  (cost=35.50..284.63 rows=50 width=29) (actual time=0.844..2.694 rows=225 loops=1)                        |
    |                    Hash Cond: (s.movie_id = m.id)                                                                                    |
    |                    ->  Seq Scan on sessions s  (cost=0.00..249.00 rows=50 width=16) (actual time=0.029..1.775 rows=225 loops=1)      |
    |                          Filter: (DATE(start_time) = CURRENT_DATE)                                                                   |
    |                          Rows Removed by Filter: 9775                                                                                |
    |                    ->  Hash  (cost=23.00..23.00 rows=1000 width=17) (actual time=0.785..0.786 rows=1000 loops=1)                     |
    |                          Buckets: 1024  Batches: 1  Memory Usage: 59kB                                                               |
    |                          ->  Seq Scan on movies m  (cost=0.00..23.00 rows=1000 width=17) (actual time=0.008..0.406 rows=1000 loops=1)|
    |              ->  Hash  (cost=33.00..33.00 rows=2000 width=8) (actual time=1.302..1.302 rows=2000 loops=1)                            |
    |                    Buckets: 2048  Batches: 1  Memory Usage: 95kB                                                                     |
    |                    ->  Seq Scan on halls h  (cost=0.00..33.00 rows=2000 width=8) (actual time=0.015..0.591 rows=2000 loops=1)        |
    |        ->  Index Scan using cinemas_pkey on cinemas c  (cost=0.28..0.32 rows=1 width=14) (actual time=0.002..0.002 rows=1 loops=225) |
    |              Index Cond: (id = h.cinema_id)                                                                                          |
    |  ->  Memoize  (cost=0.14..0.17 rows=1 width=222) (actual time=0.000..0.000 rows=1 loops=225)                                         |
    |        Cache Key: m.genre_id                                                                                                         |
    |        Cache Mode: logical                                                                                                           |
    |        Hits: 220  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB                                                           |
    |        ->  Index Scan using genres_pkey on genres g  (cost=0.13..0.16 rows=1 width=222) (actual time=0.003..0.003 rows=1 loops=5)    |
    |              Index Cond: (id = m.genre_id)                                                                                           |
    |Planning Time: 1.231 ms                                                                                                               |
    |Execution Time: 5.051 ms                                                                                                              |
    +--------------------------------------------------------------------------------------------------------------------------------------+
 */

/**
    План выполнения ~ 100.000 данных (до оптимизации)

    +-----------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                               |
    +-----------------------------------------------------------------------------------------------------------------------------------------+
    |Hash Join  (cost=1042.51..3703.37 rows=500 width=39) (actual time=14.225..36.816 rows=2337 loops=1)                                      |
    |  Hash Cond: (m.genre_id = g.id)                                                                                                         |
    |  ->  Nested Loop  (cost=1041.29..3700.28 rows=500 width=37) (actual time=14.140..36.366 rows=2337 loops=1)                              |
    |        ->  Hash Join  (cost=1041.00..3529.62 rows=500 width=30) (actual time=14.043..31.280 rows=2337 loops=1)                          |
    |              Hash Cond: (s.hall_id = h.id)                                                                                              |
    |              ->  Hash Join  (cost=349.00..2836.31 rows=500 width=30) (actual time=6.080..22.328 rows=2337 loops=1)                      |
    |                    Hash Cond: (s.movie_id = m.id)                                                                                       |
    |                    ->  Seq Scan on sessions s  (cost=0.00..2486.00 rows=500 width=16) (actual time=0.029..15.269 rows=2337 loops=1)     |
    |                          Filter: (DATE(start_time) = CURRENT_DATE)                                                                      |
    |                          Rows Removed by Filter: 97663                                                                                  |
    |                    ->  Hash  (cost=224.00..224.00 rows=10000 width=18) (actual time=5.968..5.968 rows=10000 loops=1)                    |
    |                          Buckets: 16384  Batches: 1  Memory Usage: 636kB                                                                |
    |                          ->  Seq Scan on movies m  (cost=0.00..224.00 rows=10000 width=18) (actual time=0.019..3.649 rows=10000 loops=1)|
    |              ->  Hash  (cost=442.00..442.00 rows=20000 width=8) (actual time=7.804..7.805 rows=20000 loops=1)                           |
    |                    Buckets: 32768  Batches: 1  Memory Usage: 1038kB                                                                     |
    |                    ->  Seq Scan on halls h  (cost=0.00..442.00 rows=20000 width=8) (actual time=0.033..4.685 rows=20000 loops=1)        |
    |        ->  Index Scan using cinemas_pkey on cinemas c  (cost=0.29..0.34 rows=1 width=15) (actual time=0.002..0.002 rows=1 loops=2337)   |
    |              Index Cond: (id = h.cinema_id)                                                                                             |
    |  ->  Hash  (cost=1.10..1.10 rows=10 width=10) (actual time=0.047..0.047 rows=10 loops=1)                                                |
    |        Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                     |
    |        ->  Seq Scan on genres g  (cost=0.00..1.10 rows=10 width=10) (actual time=0.029..0.030 rows=10 loops=1)                          |
    |Planning Time: 2.536 ms                                                                                                                  |
    |Execution Time: 37.055 ms                                                                                                                |
    +-----------------------------------------------------------------------------------------------------------------------------------------+
 */

/**
    Оптимизация засчет создания функцонального индекса:

    - Стоимость уменьшилась 3703п до 1930п.
    - Время с 37мс до 21мс.
 */
CREATE INDEX idx_sessions_start_date ON sessions (DATE(start_time));

/**
    План выполнения ~ 100.000 данных (после оптимизации)

    +-----------------------------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                                                 |
    +-----------------------------------------------------------------------------------------------------------------------------------------------------------+
    |Hash Join  (cost=1050.68..1930.47 rows=500 width=39) (actual time=10.334..20.516 rows=2337 loops=1)                                                        |
    |  Hash Cond: (m.genre_id = g.id)                                                                                                                           |
    |  ->  Nested Loop  (cost=1049.46..1927.38 rows=500 width=37) (actual time=10.293..19.912 rows=2337 loops=1)                                                |
    |        ->  Hash Join  (cost=1049.17..1756.73 rows=500 width=30) (actual time=10.260..14.836 rows=2337 loops=1)                                            |
    |              Hash Cond: (s.hall_id = h.id)                                                                                                                |
    |              ->  Hash Join  (cost=357.17..1063.42 rows=500 width=30) (actual time=3.966..7.362 rows=2337 loops=1)                                         |
    |                    Hash Cond: (s.movie_id = m.id)                                                                                                         |
    |                    ->  Bitmap Heap Scan on sessions s  (cost=8.17..713.10 rows=500 width=16) (actual time=0.263..2.225 rows=2337 loops=1)                 |
    |                          Recheck Cond: (DATE(start_time) = CURRENT_DATE)                                                                                  |
    |                          Heap Blocks: exact=711                                                                                                           |
    |                          ->  Bitmap Index Scan on idx_sessions_start_date  (cost=0.00..8.05 rows=500 width=0) (actual time=0.166..0.167 rows=2337 loops=1)|
    |                                Index Cond: (DATE(start_time) = CURRENT_DATE)                                                                              |
    |                    ->  Hash  (cost=224.00..224.00 rows=10000 width=18) (actual time=3.605..3.605 rows=10000 loops=1)                                      |
    |                          Buckets: 16384  Batches: 1  Memory Usage: 636kB                                                                                  |
    |                          ->  Seq Scan on movies m  (cost=0.00..224.00 rows=10000 width=18) (actual time=0.022..1.663 rows=10000 loops=1)                  |
    |              ->  Hash  (cost=442.00..442.00 rows=20000 width=8) (actual time=6.187..6.187 rows=20000 loops=1)                                             |
    |                    Buckets: 32768  Batches: 1  Memory Usage: 1038kB                                                                                       |
    |                    ->  Seq Scan on halls h  (cost=0.00..442.00 rows=20000 width=8) (actual time=0.006..2.574 rows=20000 loops=1)                          |
    |        ->  Index Scan using cinemas_pkey on cinemas c  (cost=0.29..0.34 rows=1 width=15) (actual time=0.002..0.002 rows=1 loops=2337)                     |
    |              Index Cond: (id = h.cinema_id)                                                                                                               |
    |  ->  Hash  (cost=1.10..1.10 rows=10 width=10) (actual time=0.024..0.024 rows=10 loops=1)                                                                  |
    |        Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                                       |
    |        ->  Seq Scan on genres g  (cost=0.00..1.10 rows=10 width=10) (actual time=0.010..0.013 rows=10 loops=1)                                            |
    |Planning Time: 0.852 ms                                                                                                                                    |
    |Execution Time: 20.748 ms                                                                                                                                  |
    +-----------------------------------------------------------------------------------------------------------------------------------------------------------+
 */