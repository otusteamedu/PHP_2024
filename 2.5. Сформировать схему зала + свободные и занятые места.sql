/**
    Первоначальный запрос
 */
SELECT h.name         as hall_name,
       s.id           as session,
       se.number      as seat_number,
       se.row         as seat_row,
       se.markup      as seat_markup,
       (t.id IS NULL) AS is_available
FROM halls h
         JOIN sessions s ON h.id = s.hall_id
         JOIN seats se ON h.id = se.hall_id
         LEFT JOIN tickets t ON s.id = t.session_id AND se.id = t.seat_id;

/**
    Таблица с результатами

    +---------+-------+-----------+--------+-----------+------------+
    |hall_name|session|seat_number|seat_row|seat_markup|is_available|
    +---------+-------+-----------+--------+-----------+------------+
    |Hall 1578|1      |4          |2       |50         |false       |
    |Hall 1578|1      |11         |4       |50         |true        |
    |Hall 1578|1      |11         |2       |20         |true        |
    |Hall 1578|1      |18         |1       |10         |true        |
    |Hall 1578|1      |6          |10      |20         |true        |
    |Hall 608 |2      |7          |6       |30         |true        |
    |Hall 608 |2      |14         |2       |20         |true        |
    |Hall 608 |2      |14         |1       |10         |false       |
    |Hall 608 |2      |17         |1       |30         |true        |
    |Hall 608 |2      |20         |9       |30         |true        |
    |Hall 994 |3      |19         |8       |30         |true        |
    +---------+-------+-----------+--------+-----------+------------+
 */

/**
    План выполнения ~ 10.000 данных

    +-------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                           |
    +-------------------------------------------------------------------------------------------------------------------------------------+
    |Hash Left Join  (cost=688.31..1712.31 rows=50000 width=26) (actual time=17.504..34.748 rows=50318 loops=1)                           |
    |  Hash Cond: ((s.id = t.session_id) AND (se.id = t.seat_id))                                                                         |
    |  ->  Hash Join  (cost=374.31..1135.81 rows=50000 width=29) (actual time=12.816..22.305 rows=50318 loops=1)                          |
    |        Hash Cond: (s.hall_id = h.id)                                                                                                |
    |        ->  Seq Scan on sessions s  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.027..1.149 rows=10000 loops=1)             |
    |        ->  Hash  (cost=249.31..249.31 rows=10000 width=33) (actual time=12.504..12.506 rows=10000 loops=1)                          |
    |              Buckets: 16384  Batches: 1  Memory Usage: 791kB                                                                        |
    |              ->  Hash Join  (cost=58.00..249.31 rows=10000 width=33) (actual time=1.765..8.293 rows=10000 loops=1)                  |
    |                    Hash Cond: (se.hall_id = h.id)                                                                                   |
    |                    ->  Seq Scan on seats se  (cost=0.00..165.00 rows=10000 width=20) (actual time=0.008..2.104 rows=10000 loops=1)  |
    |                    ->  Hash  (cost=33.00..33.00 rows=2000 width=13) (actual time=1.665..1.666 rows=2000 loops=1)                    |
    |                          Buckets: 2048  Batches: 1  Memory Usage: 110kB                                                             |
    |                          ->  Seq Scan on halls h  (cost=0.00..33.00 rows=2000 width=13) (actual time=0.021..0.785 rows=2000 loops=1)|
    |  ->  Hash  (cost=164.00..164.00 rows=10000 width=12) (actual time=4.405..4.406 rows=10000 loops=1)                                  |
    |        Buckets: 16384  Batches: 1  Memory Usage: 558kB                                                                              |
    |        ->  Seq Scan on tickets t  (cost=0.00..164.00 rows=10000 width=12) (actual time=0.017..1.837 rows=10000 loops=1)             |
    |Planning Time: 2.977 ms                                                                                                              |
    |Execution Time: 36.671 ms                                                                                                            |
    +-------------------------------------------------------------------------------------------------------------------------------------+
 */

/**
    План выполнения ~ 100.000 данных (до оптимизации)

    +----------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                              |
    +----------------------------------------------------------------------------------------------------------------------------------------+
    |Hash Left Join  (cost=7077.56..17405.56 rows=500000 width=27) (actual time=72.179..188.389 rows=545532 loops=1)                         |
    |  Hash Cond: ((s.id = t.session_id) AND (se.id = t.seat_id))                                                                            |
    |  ->  Hash Join  (cost=3940.56..11643.56 rows=500000 width=30) (actual time=50.458..106.121 rows=545532 loops=1)                        |
    |        Hash Cond: (se.hall_id = h.id)                                                                                                  |
    |        ->  Seq Scan on seats se  (cost=0.00..1828.00 rows=100000 width=20) (actual time=0.013..5.033 rows=100000 loops=1)              |
    |        ->  Hash  (cost=2690.56..2690.56 rows=100000 width=22) (actual time=50.425..50.427 rows=100000 loops=1)                         |
    |              Buckets: 131072  Batches: 1  Memory Usage: 6488kB                                                                         |
    |              ->  Hash Join  (cost=692.00..2690.56 rows=100000 width=22) (actual time=6.067..34.997 rows=100000 loops=1)                |
    |                    Hash Cond: (s.hall_id = h.id)                                                                                       |
    |                    ->  Seq Scan on sessions s  (cost=0.00..1736.00 rows=100000 width=8) (actual time=0.004..7.413 rows=100000 loops=1) |
    |                    ->  Hash  (cost=442.00..442.00 rows=20000 width=14) (actual time=6.048..6.049 rows=20000 loops=1)                   |
    |                          Buckets: 32768  Batches: 1  Memory Usage: 1193kB                                                              |
    |                          ->  Seq Scan on halls h  (cost=0.00..442.00 rows=20000 width=14) (actual time=0.006..2.928 rows=20000 loops=1)|
    |  ->  Hash  (cost=1637.00..1637.00 rows=100000 width=12) (actual time=21.642..21.643 rows=100000 loops=1)                               |
    |        Buckets: 131072  Batches: 1  Memory Usage: 5321kB                                                                               |
    |        ->  Seq Scan on tickets t  (cost=0.00..1637.00 rows=100000 width=12) (actual time=0.010..9.026 rows=100000 loops=1)             |
    |Planning Time: 0.955 ms                                                                                                                 |
    |Execution Time: 199.713 ms                                                                                                              |
    +----------------------------------------------------------------------------------------------------------------------------------------+
 */

/**
    Не смог найти оптмимальную оптмизацию.
 */