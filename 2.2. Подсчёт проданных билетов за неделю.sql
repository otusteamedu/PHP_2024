/**
    Первоначальный запрос
 */
SELECT count(*) AS tickets_sold
FROM tickets t
WHERE DATE(t.purchased_at) >= CURRENT_DATE - INTERVAL '1 week';

/**
    Таблица с результатами

    +------------+
    |tickets_sold|
    +------------+
    |2703        |
    +------------+
 */

/**
    План выполнения ~ 10.000 данных

    +---------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                     |
    +---------------------------------------------------------------------------------------------------------------+
    |Aggregate  (cost=272.33..272.34 rows=1 width=8) (actual time=2.669..2.670 rows=1 loops=1)                      |
    |  ->  Seq Scan on tickets t  (cost=0.00..264.00 rows=3333 width=0) (actual time=0.012..2.517 rows=2703 loops=1)|
    |        Filter: (date(purchased_at) >= (CURRENT_DATE - '7 days'::interval))                                    |
    |        Rows Removed by Filter: 7297                                                                           |
    |Planning Time: 0.072 ms                                                                                        |
    |Execution Time: 2.689 ms                                                                                       |
    +---------------------------------------------------------------------------------------------------------------+
 */

/**
    План выполнения ~ 100.000 данных (до оптимизации)

    +-------------------------------------------------------------------------------------------------------------------+
    |QUERY PLAN                                                                                                         |
    +-------------------------------------------------------------------------------------------------------------------+
    |Aggregate  (cost=2720.33..2720.34 rows=1 width=8) (actual time=30.548..30.549 rows=1 loops=1)                      |
    |  ->  Seq Scan on tickets t  (cost=0.00..2637.00 rows=33333 width=0) (actual time=0.080..28.957 rows=26646 loops=1)|
    |        Filter: (date(purchased_at) >= (CURRENT_DATE - '7 days'::interval))                                        |
    |        Rows Removed by Filter: 73354                                                                              |
    |Planning Time: 0.375 ms                                                                                            |
    |Execution Time: 30.637 ms                                                                                          |
    +-------------------------------------------------------------------------------------------------------------------+
 */
