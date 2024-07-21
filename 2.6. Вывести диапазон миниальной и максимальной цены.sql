/**
    Первоначальный запрос
 */
SELECT s.id                     as session_id,
       MIN(s2.markup + s.price) as min_final_price,
       MAX(s2.markup + s.price) as max_final_price
FROM sessions s
         JOIN halls h on h.id = s.hall_id
         JOIN seats s2 on h.id = s2.hall_id
GROUP BY s.id;

/**
    Таблица с результатами

    +----------+---------------+---------------+
    |session_id|min_final_price|max_final_price|
    +----------+---------------+---------------+
    |6114      |34.18          |64.18          |
    |4790      |34.4           |64.4           |
    |273       |32.07          |72.07          |
    |3936      |19.59          |39.59          |
    |5761      |29.24          |69.24          |
    |5468      |31             |71             |
    |7662      |29.48          |59.48          |
    |4326      |31.24          |51.24          |
    |2520      |19.39          |59.39          |
    |9038      |29.71          |69.71          |
    +----------+---------------+---------------+
 */

/**
    План выполнения ~ 10.000 данных

    +------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                          |
    +------------------------------------------------------------------------------------------------------------------------------------+
    |HashAggregate  (cost=2010.81..2110.81 rows=10000 width=68) (actual time=41.257..42.874 rows=9931 loops=1)                           |
    |  Group Key: s.id                                                                                                                   |
    |  Batches: 1  Memory Usage: 1681kB                                                                                                  |
    |  ->  Hash Join  (cost=374.31..1135.81 rows=50000 width=14) (actual time=7.026..17.509 rows=50318 loops=1)                          |
    |        Hash Cond: (s.hall_id = h.id)                                                                                               |
    |        ->  Seq Scan on sessions s  (cost=0.00..174.00 rows=10000 width=14) (actual time=0.017..1.042 rows=10000 loops=1)           |
    |        ->  Hash  (cost=249.31..249.31 rows=10000 width=12) (actual time=6.927..6.929 rows=10000 loops=1)                           |
    |              Buckets: 16384  Batches: 1  Memory Usage: 558kB                                                                       |
    |              ->  Hash Join  (cost=58.00..249.31 rows=10000 width=12) (actual time=0.608..4.461 rows=10000 loops=1)                 |
    |                    Hash Cond: (s2.hall_id = h.id)                                                                                  |
    |                    ->  Seq Scan on seats s2  (cost=0.00..165.00 rows=10000 width=8) (actual time=0.008..1.108 rows=10000 loops=1)  |
    |                    ->  Hash  (cost=33.00..33.00 rows=2000 width=4) (actual time=0.585..0.586 rows=2000 loops=1)                    |
    |                          Buckets: 2048  Batches: 1  Memory Usage: 87kB                                                             |
    |                          ->  Seq Scan on halls h  (cost=0.00..33.00 rows=2000 width=4) (actual time=0.008..0.298 rows=2000 loops=1)|
    |Planning Time: 0.572 ms                                                                                                             |
    |Execution Time: 43.360 ms                                                                                                           |
    +------------------------------------------------------------------------------------------------------------------------------------+
 */

/**
    План выполнения ~ 100.000 данных (до оптимизации)

    +-----------------------------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                                                 |
    +-----------------------------------------------------------------------------------------------------------------------------------------------------------+
    |GroupAggregate  (cost=1.02..42968.87 rows=100000 width=68) (actual time=0.068..322.396 rows=98940 loops=1)                                                 |
    |  Group Key: s.id                                                                                                                                          |
    |  ->  Nested Loop  (cost=1.02..33218.87 rows=500000 width=14) (actual time=0.027..189.652 rows=545532 loops=1)                                             |
    |        Join Filter: (h.id = s2.hall_id)                                                                                                                   |
    |        ->  Nested Loop  (cost=0.59..12378.31 rows=100000 width=18) (actual time=0.020..50.924 rows=100000 loops=1)                                        |
    |              ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..4323.29 rows=100000 width=14) (actual time=0.010..8.765 rows=100000 loops=1)   |
    |              ->  Memoize  (cost=0.30..0.32 rows=1 width=4) (actual time=0.000..0.000 rows=1 loops=100000)                                                 |
    |                    Cache Key: s.hall_id                                                                                                                   |
    |                    Cache Mode: logical                                                                                                                    |
    |                    Hits: 80218  Misses: 19782  Evictions: 0  Overflows: 0  Memory Usage: 2010kB                                                           |
    |                    ->  Index Only Scan using halls_pkey on halls h  (cost=0.29..0.31 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=19782)        |
    |                          Index Cond: (id = s.hall_id)                                                                                                     |
    |                          Heap Fetches: 0                                                                                                                  |
    |        ->  Memoize  (cost=0.43..0.60 rows=6 width=8) (actual time=0.000..0.001 rows=5 loops=100000)                                                       |
    |              Cache Key: s.hall_id                                                                                                                         |
    |              Cache Mode: logical                                                                                                                          |
    |              Hits: 80218  Misses: 19782  Evictions: 0  Overflows: 0  Memory Usage: 5181kB                                                                 |
    |              ->  Index Scan using seats_hall_id_row_number_key on seats s2  (cost=0.42..0.59 rows=6 width=8) (actual time=0.001..0.002 rows=5 loops=19782)|
    |                    Index Cond: (hall_id = s.hall_id)                                                                                                      |
    |Planning Time: 0.229 ms                                                                                                                                    |
    |Execution Time: 324.638 ms                                                                                                                                 |
    +-----------------------------------------------------------------------------------------------------------------------------------------------------------+
 */

/**
    Не смог найти оптмимальную оптмизацию.
 */
