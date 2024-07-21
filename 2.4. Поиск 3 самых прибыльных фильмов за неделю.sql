/**
    Первоначальный запрос
 */
WITH weekly_revenue AS (SELECT m.id,
                               m.title                  AS movie_title,
                               SUM(s.price + se.markup) AS session_revenue
                        FROM tickets t
                                 JOIN sessions s ON t.session_id = s.id
                                 JOIN movies m ON s.movie_id = m.id
                                 JOIN seats se ON t.seat_id = se.id
                        WHERE DATE(t.purchased_at) >= CURRENT_DATE - INTERVAL '1 week'
                        GROUP BY m.id)
SELECT wr.id,
       wr.movie_title,
       wr.session_revenue
FROM weekly_revenue wr
ORDER BY wr.session_revenue DESC
LIMIT 3;

/**
    Таблица с результатами

    +---+-----------+---------------+
    |id |movie_title|session_revenue|
    +---+-----------+---------------+
    |85 |Movie 85   |485.09         |
    |445|Movie 445  |466.26         |
    |376|Movie 376  |415.16         |
    +---+-----------+---------------+
 */

/**
    План выполнения ~ 10.000 данных

    +-------------------------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                                             |
    +-------------------------------------------------------------------------------------------------------------------------------------------------------+
    |Limit  (cost=973.54..973.54 rows=3 width=45) (actual time=16.258..16.265 rows=3 loops=1)                                                               |
    |  ->  Sort  (cost=973.54..976.04 rows=1000 width=45) (actual time=16.257..16.262 rows=3 loops=1)                                                       |
    |        Sort Key: (sum((s.price + (se.markup)::numeric))) DESC                                                                                         |
    |        Sort Method: top-N heapsort  Memory: 25kB                                                                                                      |
    |        ->  HashAggregate  (cost=948.11..960.61 rows=1000 width=45) (actual time=15.633..16.093 rows=904 loops=1)                                      |
    |              Group Key: m.id                                                                                                                          |
    |              Batches: 1  Memory Usage: 577kB                                                                                                          |
    |              ->  Hash Join  (cost=624.50..914.78 rows=3333 width=23) (actual time=7.249..13.668 rows=2703 loops=1)                                    |
    |                    Hash Cond: (t.seat_id = se.id)                                                                                                     |
    |                    ->  Hash Join  (cost=334.50..616.03 rows=3333 width=23) (actual time=3.830..8.994 rows=2703 loops=1)                               |
    |                          Hash Cond: (s.movie_id = m.id)                                                                                               |
    |                          ->  Hash Join  (cost=299.00..571.75 rows=3333 width=14) (actual time=3.525..7.914 rows=2703 loops=1)                         |
    |                                Hash Cond: (t.session_id = s.id)                                                                                       |
    |                                ->  Seq Scan on tickets t  (cost=0.00..264.00 rows=3333 width=8) (actual time=0.013..3.062 rows=2703 loops=1)          |
    |                                      Filter: (DATE(purchased_at) >= (CURRENT_DATE - '7 days'::interval))                                              |
    |                                      Rows Removed by Filter: 7297                                                                                     |
    |                                ->  Hash  (cost=174.00..174.00 rows=10000 width=14) (actual time=3.496..3.497 rows=10000 loops=1)                      |
    |                                      Buckets: 16384  Batches: 1  Memory Usage: 597kB                                                                  |
    |                                      ->  Seq Scan on sessions s  (cost=0.00..174.00 rows=10000 width=14) (actual time=0.005..1.650 rows=10000 loops=1)|
    |                          ->  Hash  (cost=23.00..23.00 rows=1000 width=13) (actual time=0.281..0.281 rows=1000 loops=1)                                |
    |                                Buckets: 1024  Batches: 1  Memory Usage: 53kB                                                                          |
    |                                ->  Seq Scan on movies m  (cost=0.00..23.00 rows=1000 width=13) (actual time=0.008..0.145 rows=1000 loops=1)           |
    |                    ->  Hash  (cost=165.00..165.00 rows=10000 width=8) (actual time=3.409..3.409 rows=10000 loops=1)                                   |
    |                          Buckets: 16384  Batches: 1  Memory Usage: 519kB                                                                              |
    |                          ->  Seq Scan on seats se  (cost=0.00..165.00 rows=10000 width=8) (actual time=0.010..1.623 rows=10000 loops=1)               |
    |Planning Time: 0.844 ms                                                                                                                                |
    |Execution Time: 16.367 ms                                                                                                                              |
    +-------------------------------------------------------------------------------------------------------------------------------------------------------+
 */

/**
    План выполнения ~ 100.000 данных (до оптимизации)

    +----------------------------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                                                |
    +----------------------------------------------------------------------------------------------------------------------------------------------------------+
    |Limit  (cost=9900.11..9900.12 rows=3 width=46) (actual time=110.641..110.645 rows=3 loops=1)                                                              |
    |  ->  Sort  (cost=9900.11..9925.11 rows=10000 width=46) (actual time=110.639..110.643 rows=3 loops=1)                                                     |
    |        Sort Key: (sum((s.price + (se.markup)::numeric))) DESC                                                                                            |
    |        Sort Method: top-N heapsort  Memory: 25kB                                                                                                         |
    |        ->  HashAggregate  (cost=9645.86..9770.86 rows=10000 width=46) (actual time=108.198..109.828 rows=8664 loops=1)                                   |
    |              Group Key: m.id                                                                                                                             |
    |              Batches: 1  Memory Usage: 3729kB                                                                                                            |
    |              ->  Hash Join  (cost=6413.00..9312.53 rows=33333 width=24) (actual time=52.412..97.180 rows=26646 loops=1)                                  |
    |                    Hash Cond: (t.seat_id = se.id)                                                                                                        |
    |                    ->  Hash Join  (cost=3335.00..6147.03 rows=33333 width=24) (actual time=20.394..55.345 rows=26646 loops=1)                            |
    |                          Hash Cond: (s.movie_id = m.id)                                                                                                  |
    |                          ->  Hash Join  (cost=2986.00..5710.50 rows=33333 width=14) (actual time=18.639..47.609 rows=26646 loops=1)                      |
    |                                Hash Cond: (t.session_id = s.id)                                                                                          |
    |                                ->  Seq Scan on tickets t  (cost=0.00..2637.00 rows=33333 width=8) (actual time=0.019..17.550 rows=26646 loops=1)         |
    |                                      Filter: (DATE(purchased_at) >= (CURRENT_DATE - '7 days'::interval))                                                 |
    |                                      Rows Removed by Filter: 73354                                                                                       |
    |                                ->  Hash  (cost=1736.00..1736.00 rows=100000 width=14) (actual time=18.363..18.363 rows=100000 loops=1)                   |
    |                                      Buckets: 131072  Batches: 1  Memory Usage: 5712kB                                                                   |
    |                                      ->  Seq Scan on sessions s  (cost=0.00..1736.00 rows=100000 width=14) (actual time=0.005..7.577 rows=100000 loops=1)|
    |                          ->  Hash  (cost=224.00..224.00 rows=10000 width=14) (actual time=1.709..1.710 rows=10000 loops=1)                               |
    |                                Buckets: 16384  Batches: 1  Memory Usage: 585kB                                                                           |
    |                                ->  Seq Scan on movies m  (cost=0.00..224.00 rows=10000 width=14) (actual time=0.009..0.810 rows=10000 loops=1)           |
    |                    ->  Hash  (cost=1828.00..1828.00 rows=100000 width=8) (actual time=31.999..32.000 rows=100000 loops=1)                                |
    |                          Buckets: 131072  Batches: 1  Memory Usage: 4931kB                                                                               |
    |                          ->  Seq Scan on seats se  (cost=0.00..1828.00 rows=100000 width=8) (actual time=0.063..17.347 rows=100000 loops=1)              |
    |Planning Time: 1.443 ms                                                                                                                                   |
    |Execution Time: 110.851 ms                                                                                                                                |
    +----------------------------------------------------------------------------------------------------------------------------------------------------------+
 */

/**
    Оптимизация засчет создания функцонального индекса:

    - Стоимость уменьшилась с 9900п до 8945п.
    - Время не изменилось.
 */
CREATE INDEX idx_tickets_purchased_date ON tickets ((DATE(purchased_at)));

/**
    План выполнения ~ 100.000 данных (после оптимизации)

    +-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                                                                                     |
    +-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
    |Limit  (cost=8945.40..8945.40 rows=3 width=46) (actual time=112.144..112.148 rows=3 loops=1)                                                                                   |
    |  ->  Sort  (cost=8945.40..8970.40 rows=10000 width=46) (actual time=112.143..112.146 rows=3 loops=1)                                                                          |
    |        Sort Key: (sum((s.price + (se.markup)::numeric))) DESC                                                                                                                 |
    |        Sort Method: top-N heapsort  Memory: 25kB                                                                                                                              |
    |        ->  HashAggregate  (cost=8691.15..8816.15 rows=10000 width=46) (actual time=109.580..111.299 rows=8664 loops=1)                                                        |
    |              Group Key: m.id                                                                                                                                                  |
    |              Batches: 1  Memory Usage: 3729kB                                                                                                                                 |
    |              ->  Hash Join  (cost=6791.63..8357.82 rows=33333 width=24) (actual time=74.849..100.054 rows=26646 loops=1)                                                      |
    |                    Hash Cond: (t.seat_id = se.id)                                                                                                                             |
    |                    ->  Hash Join  (cost=3713.63..5192.32 rows=33333 width=24) (actual time=34.827..52.702 rows=26646 loops=1)                                                 |
    |                          Hash Cond: (s.movie_id = m.id)                                                                                                                       |
    |                          ->  Hash Join  (cost=3364.63..4755.79 rows=33333 width=14) (actual time=31.497..44.605 rows=26646 loops=1)                                           |
    |                                Hash Cond: (t.session_id = s.id)                                                                                                               |
    |                                ->  Bitmap Heap Scan on tickets t  (cost=378.63..1682.29 rows=33333 width=8) (actual time=0.741..5.738 rows=26646 loops=1)                     |
    |                                      Recheck Cond: (date(purchased_at) >= (CURRENT_DATE - '7 days'::interval))                                                                |
    |                                      Heap Blocks: exact=637                                                                                                                   |
    |                                      ->  Bitmap Index Scan on idx_tickets_purchased_date  (cost=0.00..370.30 rows=33333 width=0) (actual time=0.663..0.663 rows=26646 loops=1)|
    |                                            Index Cond: (date(purchased_at) >= (CURRENT_DATE - '7 days'::interval))                                                            |
    |                                ->  Hash  (cost=1736.00..1736.00 rows=100000 width=14) (actual time=29.973..29.973 rows=100000 loops=1)                                        |
    |                                      Buckets: 131072  Batches: 1  Memory Usage: 5712kB                                                                                        |
    |                                      ->  Seq Scan on sessions s  (cost=0.00..1736.00 rows=100000 width=14) (actual time=0.014..12.980 rows=100000 loops=1)                    |
    |                          ->  Hash  (cost=224.00..224.00 rows=10000 width=14) (actual time=3.243..3.244 rows=10000 loops=1)                                                    |
    |                                Buckets: 16384  Batches: 1  Memory Usage: 585kB                                                                                                |
    |                                ->  Seq Scan on movies m  (cost=0.00..224.00 rows=10000 width=14) (actual time=0.018..1.746 rows=10000 loops=1)                                |
    |                    ->  Hash  (cost=1828.00..1828.00 rows=100000 width=8) (actual time=39.852..39.852 rows=100000 loops=1)                                                     |
    |                          Buckets: 131072  Batches: 1  Memory Usage: 4931kB                                                                                                    |
    |                          ->  Seq Scan on seats se  (cost=0.00..1828.00 rows=100000 width=8) (actual time=0.049..18.391 rows=100000 loops=1)                                   |
    |Planning Time: 0.957 ms                                                                                                                                                        |
    |Execution Time: 112.349 ms                                                                                                                                                     |
    +-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
 */