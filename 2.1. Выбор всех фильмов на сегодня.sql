/**
    Первоначальный запрос
 */
SELECT m.id    AS movie_id,
       m.title AS movie_title
FROM movies m
         JOIN sessions s ON m.id = s.movie_id
WHERE DATE(s.start_time) = CURRENT_DATE;

/**
    Таблица с результатами

    +--------+-----------+
    |movie_id|movie_title|
    +--------+-----------+
    |549     |Movie 549  |
    |762     |Movie 762  |
    |471     |Movie 471  |
    |808     |Movie 808  |
    |93      |Movie 93   |
    |897     |Movie 897  |
    |929     |Movie 929  |
    |402     |Movie 402  |
    |418     |Movie 418  |
    |210     |Movie 210  |
    +--------+-----------+
 */

/**
    План выполнения ~ 10.000 данных

    +--------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                          |
    +--------------------------------------------------------------------------------------------------------------------+
    |Hash Join  (cost=35.50..284.63 rows=50 width=13) (actual time=0.326..2.503 rows=225 loops=1)                        |
    |  Hash Cond: (s.movie_id = m.id)                                                                                    |
    |  ->  Seq Scan on sessions s  (cost=0.00..249.00 rows=50 width=4) (actual time=0.021..2.114 rows=225 loops=1)       |
    |        Filter: (date(start_time) = CURRENT_DATE)                                                                   |
    |        Rows Removed by Filter: 9775                                                                                |
    |  ->  Hash  (cost=23.00..23.00 rows=1000 width=13) (actual time=0.292..0.293 rows=1000 loops=1)                     |
    |        Buckets: 1024  Batches: 1  Memory Usage: 53kB                                                               |
    |        ->  Seq Scan on movies m  (cost=0.00..23.00 rows=1000 width=13) (actual time=0.004..0.158 rows=1000 loops=1)|
    |Planning Time: 1.410 ms                                                                                             |
    |Execution Time: 2.577 ms                                                                                            |
    +--------------------------------------------------------------------------------------------------------------------+
 */

/**
    План выполнения ~ 100.000 данных (до оптимизации)

    +-----------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                             |
    +-----------------------------------------------------------------------------------------------------------------------+
    |Hash Join  (cost=349.00..2836.31 rows=500 width=14) (actual time=5.152..26.533 rows=2337 loops=1)                      |
    |  Hash Cond: (s.movie_id = m.id)                                                                                       |
    |  ->  Seq Scan on sessions s  (cost=0.00..2486.00 rows=500 width=4) (actual time=0.019..19.811 rows=2337 loops=1)      |
    |        Filter: (date(start_time) = CURRENT_DATE)                                                                      |
    |        Rows Removed by Filter: 97663                                                                                  |
    |  ->  Hash  (cost=224.00..224.00 rows=10000 width=14) (actual time=5.112..5.113 rows=10000 loops=1)                    |
    |        Buckets: 16384  Batches: 1  Memory Usage: 585kB                                                                |
    |        ->  Seq Scan on movies m  (cost=0.00..224.00 rows=10000 width=14) (actual time=0.007..2.102 rows=10000 loops=1)|
    |Planning Time: 0.383 ms                                                                                                |
    |Execution Time: 28.244 ms                                                                                              |
    +-----------------------------------------------------------------------------------------------------------------------+
 */
