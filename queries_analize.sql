EXPLAIN ANALYZE SELECT *
FROM films
WHERE start_date <= CURRENT_DATE AND end_date >= CURRENT_DATE;

10 000
Seq Scan on films  (cost=0.00..564.06 rows=10102 width=254) (actual time=0.006..1.647 rows=10103 loops=1)
  Filter: ((start_date <= CURRENT_DATE) AND (end_date >= CURRENT_DATE))
Planning Time: 0.529 ms
Execution Time: 1.801 ms

10 000 000
Seq Scan on films  (cost=0.00..324672.24 rows=1432697 width=69) (actual time=0.211..8179.124 rows=1409529 loops=1)
  Filter: ((start_date <= CURRENT_DATE) AND (end_date >= CURRENT_DATE))
  Rows Removed by Filter: 1674
Planning Time: 0.649 ms
Execution Time: 8199.381 ms

Oптимизация
    1. создан индекс на start_date
    2. создан индекс на end_date
Результат
    уменьшение времени выполнения запроса

create index idx_films_date on films (start_date);
create index idx_films_date1 on films (end_date);

Seq Scan on films  (cost=0.00..324207.06 rows=1409604 width=69) (actual time=0.019..913.285 rows=1409529 loops=1)
  Filter: ((start_date <= CURRENT_DATE) AND (end_date >= CURRENT_DATE))
  Rows Removed by Filter: 1674
Planning Time: 1.934 ms
Execution Time: 932.581 ms

-------------------------

EXPLAIN ANALYZE SELECT COUNT(*)
FROM tickets
WHERE DATE(purchase_time) >= CURRENT_DATE - INTERVAL '7 day';

10 000

Aggregate  (cost=305.42..305.43 rows=1 width=8) (actual time=1.667..1.668 rows=1 loops=1)
  ->  Seq Scan on tickets  (cost=0.00..297.00 rows=3367 width=0) (actual time=0.297..1.613 rows=1946 loops=1)
        Filter: (date(purchase_time) >= (CURRENT_DATE - '7 days'::interval))
        Rows Removed by Filter: 8154
Planning Time: 1.517 ms
Execution Time: 1.697 ms

10 000 000

Finalize Aggregate  (cost=32009.64..32009.65 rows=1 width=8) (actual time=120.096..123.523 rows=1 loops=1)
  ->  Gather  (cost=32009.42..32009.63 rows=2 width=8) (actual time=119.784..123.519 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=31009.42..31009.43 rows=1 width=8) (actual time=98.272..98.272 rows=1 loops=3)
              ->  Parallel Seq Scan on tickets  (cost=0.00..30412.17 rows=238903 width=0) (actual time=0.081..95.190 rows=111222 loops=3)
                    Filter: (date(purchase_time) >= (CURRENT_DATE - '7 days'::interval))
                    Rows Removed by Filter: 462144
Planning Time: 0.083 ms
Execution Time: 123.546 ms

Oптимизация
    1. создан индекс на purchase_time
Результат
    незначительное уменьшение времени выполнения запроса

create index idx_tickets_date on tickets (purchase_time);

Finalize Aggregate  (cost=32009.64..32009.65 rows=1 width=8) (actual time=116.689..120.156 rows=1 loops=1)
  ->  Gather  (cost=32009.42..32009.63 rows=2 width=8) (actual time=116.407..120.151 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=31009.42..31009.43 rows=1 width=8) (actual time=96.290..96.291 rows=1 loops=3)
              ->  Parallel Seq Scan on tickets  (cost=0.00..30412.17 rows=238903 width=16) (actual time=0.080..92.509 rows=111222 loops=3)
                    Filter: (date(purchase_time) >= (CURRENT_DATE - '7 days'::interval))
                    Rows Removed by Filter: 462144
Planning Time: 0.071 ms
Execution Time: 120.178 ms

-------------------------
SELECT MIN(price) AS min_price, MAX(price) AS max_price
FROM tickets
WHERE session_id = 1; -- ID сеанса

10 000

Aggregate  (cost=221.31..221.32 rows=1 width=16) (actual time=0.374..0.374 rows=1 loops=1)
  ->  Seq Scan on tickets  (cost=0.00..221.25 rows=12 width=8) (actual time=0.010..0.371 rows=12 loops=1)
        Filter: (session_id = 14)
        Rows Removed by Filter: 10088
Planning Time: 0.080 ms
Execution Time: 0.386 ms


10 000 000

Finalize Aggregate  (cost=26037.19..26037.20 rows=1 width=16) (actual time=64.045..68.117 rows=1 loops=1)
  ->  Gather  (cost=26036.97..26037.18 rows=2 width=16) (actual time=63.728..68.112 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=25036.97..25036.98 rows=1 width=16) (actual time=42.279..42.280 rows=1 loops=3)
              ->  Parallel Seq Scan on tickets  (cost=0.00..25036.85 rows=24 width=8) (actual time=21.196..42.277 rows=4 loops=3)
                    Filter: (session_id = 14)
                    Rows Removed by Filter: 573363
Planning Time: 0.089 ms
Execution Time: 68.137 ms

Oптимизация
    1. создан индекс на session_id
    2. создан индекс на price
Результат
    уменьшение "cost" запроса
    уменьшение времени выполнения запроса

create index idx_tickets_session on tickets (session_id);
create index idx_tickets_price on tickets (price);

Aggregate  (cost=9.72..9.73 rows=1 width=16) (actual time=0.021..0.021 rows=1 loops=1)
  ->  Index Scan using idx_tickets_session on tickets  (cost=0.43..9.43 rows=57 width=8) (actual time=0.015..0.017 rows=12 loops=1)
        Index Cond: (session_id = 14)
Planning Time: 0.122 ms
Execution Time: 0.043 ms

----------------------------

explain analyze SELECT DISTINCT *
FROM films f
JOIN sessions s ON f.film_id = s.film_id
WHERE DATE(s.start_time) <= CURRENT_DATE AND DATE(s.end_time) >= CURRENT_DATE;

10 000
Unique  (cost=13427.25..13466.17 rows=1112 width=290) (actual time=36.758..39.271 rows=9895 loops=1)
  ->  Sort  (cost=13427.25..13430.03 rows=1112 width=290) (actual time=36.757..37.180 rows=9895 loops=1)
"        Sort Key: f.film_id, f.title, f.description, f.duration, f.start_date, f.end_date, f.age_rating, f.directors, s.session_id, s.hall_id, s.start_time, s.end_time, s.recommended_price"
        Sort Method: quicksort  Memory: 3540kB
        ->  Nested Loop  (cost=8.05..13370.99 rows=1112 width=290) (actual time=0.019..30.687 rows=9895 loops=1)
              ->  Seq Scan on sessions s  (cost=0.00..334.25 rows=1112 width=36) (actual time=0.008..1.994 rows=9895 loops=1)
                    Filter: ((date(start_time) <= CURRENT_DATE) AND (date(end_time) >= CURRENT_DATE))
                    Rows Removed by Filter: 115
              ->  Memoize  (cost=8.05..12.07 rows=1 width=254) (actual time=0.003..0.003 rows=1 loops=9895)
                    Cache Key: s.film_id
                    Cache Mode: logical
                    Hits: 3351  Misses: 6544  Evictions: 0  Overflows: 0  Memory Usage: 2289kB
                    ->  Bitmap Heap Scan on films f  (cost=8.04..12.06 rows=1 width=254) (actual time=0.002..0.002 rows=1 loops=6544)
                          Recheck Cond: (film_id = s.film_id)
                          Heap Blocks: exact=6544
                          ->  Bitmap Index Scan on films_pkey  (cost=0.00..8.04 rows=1 width=0) (actual time=0.001..0.001 rows=1 loops=6544)
                                Index Cond: (film_id = s.film_id)
Planning Time: 0.387 ms
Execution Time: 40.560 ms

create index idx_sessions_film_id on sessions (film_id);
create index idx_sessions_time on sessions (start_time, end_time);

Unique  (cost=13427.25..13466.17 rows=1112 width=290) (actual time=29.815..31.729 rows=9895 loops=1)
  ->  Sort  (cost=13427.25..13430.03 rows=1112 width=290) (actual time=29.814..30.115 rows=9895 loops=1)
"        Sort Key: f.film_id, f.title, f.description, f.duration, f.start_date, f.end_date, f.age_rating, f.directors, s.session_id, s.hall_id, s.start_time, s.end_time, s.recommended_price"
        Sort Method: quicksort  Memory: 3540kB
        ->  Nested Loop  (cost=8.05..13370.99 rows=1112 width=290) (actual time=0.016..25.006 rows=9895 loops=1)
              ->  Seq Scan on sessions s  (cost=0.00..334.25 rows=1112 width=36) (actual time=0.006..1.757 rows=9895 loops=1)
                    Filter: ((date(start_time) <= CURRENT_DATE) AND (date(end_time) >= CURRENT_DATE))
                    Rows Removed by Filter: 115
              ->  Memoize  (cost=8.05..12.07 rows=1 width=254) (actual time=0.002..0.002 rows=1 loops=9895)
                    Cache Key: s.film_id
                    Cache Mode: logical
                    Hits: 3351  Misses: 6544  Evictions: 0  Overflows: 0  Memory Usage: 2289kB
                    ->  Bitmap Heap Scan on films f  (cost=8.04..12.06 rows=1 width=254) (actual time=0.001..0.001 rows=1 loops=6544)
                          Recheck Cond: (film_id = s.film_id)
                          Heap Blocks: exact=6544
                          ->  Bitmap Index Scan on films_pkey  (cost=0.00..8.04 rows=1 width=0) (actual time=0.001..0.001 rows=1 loops=6544)
                                Index Cond: (film_id = s.film_id)
Planning Time: 0.842 ms
Execution Time: 32.373 ms

10 000 000

Unique  (cost=44292.54..70985.70 rows=179189 width=105) (actual time=3448.096..4715.270 rows=1617284 loops=1)
  ->  Gather Merge  (cost=44292.54..65162.06 rows=179189 width=105) (actual time=3448.095..4522.209 rows=1617284 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Sort  (cost=43292.52..43479.18 rows=74662 width=105) (actual time=3406.815..3719.658 rows=539095 loops=3)
"              Sort Key: f.film_id, f.title, f.description, f.duration, f.start_date, f.end_date, f.age_rating, f.directors, s.session_id, s.hall_id, s.start_time, s.end_time, s.recommended_price"
              Sort Method: external merge  Disk: 199400kB
              Worker 0:  Sort Method: external merge  Disk: 198360kB
              Worker 1:  Sort Method: external merge  Disk: 199400kB
              ->  Nested Loop  (cost=0.44..32909.35 rows=74662 width=105) (actual time=0.341..1814.409 rows=539095 loops=3)
                    ->  Parallel Seq Scan on sessions s  (cost=0.00..30300.00 rows=74662 width=36) (actual time=0.146..1680.437 rows=539095 loops=3)
                          Filter: ((date(start_time) <= CURRENT_DATE) AND (date(end_time) >= CURRENT_DATE))
                          Rows Removed by Filter: 909
                    ->  Memoize  (cost=0.44..4.11 rows=1 width=69) (actual time=0.000..0.000 rows=1 loops=1617284)
                          Cache Key: s.film_id
                          Cache Mode: logical
                          Hits: 534983  Misses: 6292  Evictions: 0  Overflows: 0  Memory Usage: 2201kB
                          Worker 0:  Hits: 536589  Misses: 1  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                          Worker 1:  Hits: 539418  Misses: 1  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                          ->  Index Scan using films_pkey on films f  (cost=0.43..4.10 rows=1 width=69) (actual time=0.002..0.002 rows=1 loops=6294)
                                Index Cond: (film_id = s.film_id)
Planning Time: 1.557 ms
Execution Time: 4751.466 ms

Oптимизация
    1. создан индекс на film_id
    2. создан индекс на start_time и end_time
Результат
    уменьшение времени выполнения запроса

create index idx_sessions_film_id on sessions (film_id);
create index idx_sessions_time on sessions (start_time, end_time);

Unique  (cost=44426.84..71240.95 rows=180001 width=105) (actual time=2268.448..3542.262 rows=1617284 loops=1)
  ->  Gather Merge  (cost=44426.84..65390.92 rows=180001 width=105) (actual time=2268.448..3346.305 rows=1617284 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Sort  (cost=43426.81..43614.31 rows=75000 width=105) (actual time=2233.157..2551.320 rows=539095 loops=3)
"              Sort Key: f.film_id, f.title, f.description, f.duration, f.start_date, f.end_date, f.age_rating, f.directors, s.session_id, s.hall_id, s.start_time, s.end_time, s.recommended_price"
              Sort Method: external merge  Disk: 205368kB
              Worker 0:  Sort Method: external merge  Disk: 194264kB
              Worker 1:  Sort Method: external merge  Disk: 197504kB
              ->  Nested Loop  (cost=0.44..32992.84 rows=75000 width=105) (actual time=0.102..216.776 rows=539095 loops=3)
                    ->  Parallel Seq Scan on sessions s  (cost=0.00..30376.10 rows=75000 width=36) (actual time=0.079..89.502 rows=539095 loops=3)
                          Filter: ((date(start_time) <= CURRENT_DATE) AND (date(end_time) >= CURRENT_DATE))
                          Rows Removed by Filter: 909
                    ->  Memoize  (cost=0.44..4.11 rows=1 width=69) (actual time=0.000..0.000 rows=1 loops=1617284)
                          Cache Key: s.film_id
                          Cache Mode: logical
                          Hits: 551160  Misses: 6292  Evictions: 0  Overflows: 0  Memory Usage: 2201kB
                          Worker 0:  Hits: 525538  Misses: 1  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                          Worker 1:  Hits: 534292  Misses: 1  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                          ->  Index Scan using films_pkey on films f  (cost=0.43..4.10 rows=1 width=69) (actual time=0.001..0.001 rows=1 loops=6294)
                                Index Cond: (film_id = s.film_id)
Planning Time: 0.901 ms
Execution Time: 3579.284 ms

--------------------------

explain analyze
    SELECT f.title, SUM(t.price) AS total
    FROM tickets t
             JOIN sessions s ON t.session_id = s.session_id
             JOIN films f ON s.film_id = f.film_id
    WHERE DATE(t.purchase_time) >= CURRENT_DATE - INTERVAL '7 days'
    GROUP BY f.film_id
    ORDER BY total DESC
    LIMIT 3;

10 000
Limit  (cost=34479.42..34479.42 rows=3 width=67) (actual time=10.590..10.592 rows=3 loops=1)
  ->  Sort  (cost=34479.42..34487.83 rows=3367 width=67) (actual time=10.589..10.591 rows=3 loops=1)
        Sort Key: (sum(t.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  GroupAggregate  (cost=34376.98..34435.90 rows=3367 width=67) (actual time=10.032..10.463 rows=1588 loops=1)
              Group Key: f.film_id
              ->  Sort  (cost=34376.98..34385.39 rows=3367 width=67) (actual time=10.021..10.103 rows=1946 loops=1)
                    Sort Key: f.film_id
                    Sort Method: quicksort  Memory: 260kB
                    ->  Nested Loop  (cost=315.18..34179.72 rows=3367 width=67) (actual time=1.168..9.553 rows=1946 loops=1)
                          ->  Hash Join  (cost=309.23..615.06 rows=3367 width=12) (actual time=1.157..3.233 rows=1946 loops=1)
                                Hash Cond: (t.session_id = s.session_id)
                                ->  Seq Scan on tickets t  (cost=0.00..297.00 rows=3367 width=12) (actual time=0.005..1.567 rows=1946 loops=1)
                                      Filter: (date(purchase_time) >= (CURRENT_DATE - '7 days'::interval))
                                      Rows Removed by Filter: 8154
                                ->  Hash  (cost=184.10..184.10 rows=10010 width=8) (actual time=1.116..1.117 rows=10010 loops=1)
                                      Buckets: 16384  Batches: 1  Memory Usage: 520kB
                                      ->  Seq Scan on sessions s  (cost=0.00..184.10 rows=10010 width=8) (actual time=0.003..0.531 rows=10010 loops=1)
                          ->  Bitmap Heap Scan on films f  (cost=5.96..9.97 rows=1 width=59) (actual time=0.001..0.001 rows=1 loops=1946)
                                Recheck Cond: (film_id = s.film_id)
                                Heap Blocks: exact=1946
                                ->  Bitmap Index Scan on films_pkey  (cost=0.00..5.96 rows=1 width=0) (actual time=0.001..0.001 rows=1 loops=1946)
                                      Index Cond: (film_id = s.film_id)
Planning Time: 1.625 ms
Execution Time: 10.693 ms

10 000 000

Limit  (cost=145609.70..145609.70 rows=3 width=25) (actual time=221.299..221.346 rows=3 loops=1)
->  Sort  (cost=145609.70..147043.11 rows=573367 width=25) (actual time=221.298..221.344 rows=3 loops=1)
    Sort Key: (sum(t.price)) DESC
    Sort Method: top-N heapsort  Memory: 25kB
    ->  Finalize GroupAggregate  (cost=70744.87..138199.04 rows=573367 width=25) (actual time=204.427..221.224 rows=1061 loops=1)
          Group Key: f.film_id
          ->  Gather Merge  (cost=70744.87..130076.34 rows=477806 width=25) (actual time=204.420..220.978 rows=1065 loops=1)
                Workers Planned: 2
                Workers Launched: 2
                ->  Partial GroupAggregate  (cost=69744.84..73925.64 rows=238903 width=25) (actual time=171.877..186.005 rows=355 loops=3)
                      Group Key: f.film_id
                      ->  Sort  (cost=69744.84..70342.10 rows=238903 width=25) (actual time=171.733..179.665 rows=111222 loops=3)
                            Sort Key: f.film_id
                            Sort Method: external merge  Disk: 12528kB
                            Worker 0:  Sort Method: external merge  Disk: 10720kB
                            Worker 1:  Sort Method: external merge  Disk: 10848kB
                            ->  Nested Loop  (cost=0.88..42684.56 rows=238903 width=25) (actual time=0.228..139.682 rows=111222 loops=3)
                                  ->  Nested Loop  (cost=0.44..36487.39 rows=238903 width=12) (actual time=0.204..118.777 rows=111222 loops=3)
                                        ->  Parallel Seq Scan on tickets t  (cost=0.00..30412.17 rows=238903 width=12) (actual time=0.073..94.326 rows=111222 loops=3)
                                              Filter: (date(purchase_time) >= (CURRENT_DATE - '7 days'::interval))
                                              Rows Removed by Filter: 462144
                                        ->  Memoize  (cost=0.44..0.58 rows=1 width=8) (actual time=0.000..0.000 rows=1 loops=333667)
                                              Cache Key: t.session_id
                                              Cache Mode: logical
                                              Hits: 123810  Misses: 1116  Evictions: 0  Overflows: 0  Memory Usage: 118kB
                                              Worker 0:  Hits: 103802  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                              Worker 1:  Hits: 104933  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                              ->  Index Scan using sessions_pkey on sessions s  (cost=0.43..0.57 rows=1 width=8) (actual time=0.006..0.006 rows=1 loops=1122)
                                                    Index Cond: (session_id = t.session_id)
                                  ->  Memoize  (cost=0.44..1.25 rows=1 width=17) (actual time=0.000..0.000 rows=1 loops=333667)
                                        Cache Key: s.film_id
                                        Cache Mode: logical
                                        Hits: 123865  Misses: 1061  Evictions: 0  Overflows: 0  Memory Usage: 167kB
                                        Worker 0:  Hits: 103803  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                        Worker 1:  Hits: 104934  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                        ->  Index Scan using films_pkey on films f  (cost=0.43..1.24 rows=1 width=17) (actual time=0.001..0.001 rows=1 loops=1065)
                                              Index Cond: (film_id = s.film_id)
Planning Time: 1.272 ms
Execution Time: 222.564 ms

Oптимизация
    1. создан индекс на film_id таблицы sessions
    2. создан индекс на price и session_id таблицы tickets
Результат
    значительных изменений нет

create index idx_sessions_film_id on sessions (film_id);
create index idx_tickets_price on tickets (price);
create index idx_tickets_session on tickets (session_id);

Limit  (cost=145609.70..145609.70 rows=3 width=25) (actual time=223.279..223.315 rows=3 loops=1)
->  Sort  (cost=145609.70..147043.11 rows=573367 width=25) (actual time=223.278..223.314 rows=3 loops=1)
    Sort Key: (sum(t.price)) DESC
    Sort Method: top-N heapsort  Memory: 25kB
    ->  Finalize GroupAggregate  (cost=70744.87..138199.04 rows=573367 width=25) (actual time=206.563..223.212 rows=1061 loops=1)
          Group Key: f.film_id
          ->  Gather Merge  (cost=70744.87..130076.34 rows=477806 width=25) (actual time=206.556..222.993 rows=1065 loops=1)
                Workers Planned: 2
                Workers Launched: 2
                ->  Partial GroupAggregate  (cost=69744.84..73925.64 rows=238903 width=25) (actual time=173.978..188.098 rows=355 loops=3)
                      Group Key: f.film_id
                      ->  Sort  (cost=69744.84..70342.10 rows=238903 width=25) (actual time=173.926..182.035 rows=111222 loops=3)
                            Sort Key: f.film_id
                            Sort Method: external merge  Disk: 12712kB
                            Worker 0:  Sort Method: external merge  Disk: 10680kB
                            Worker 1:  Sort Method: external merge  Disk: 10720kB
                            ->  Nested Loop  (cost=0.88..42684.56 rows=238903 width=25) (actual time=0.175..138.468 rows=111222 loops=3)
                                  ->  Nested Loop  (cost=0.44..36487.39 rows=238903 width=12) (actual time=0.151..117.448 rows=111222 loops=3)
                                        ->  Parallel Seq Scan on tickets t  (cost=0.00..30412.17 rows=238903 width=12) (actual time=0.120..94.553 rows=111222 loops=3)
                                              Filter: (date(purchase_time) >= (CURRENT_DATE - '7 days'::interval))
                                              Rows Removed by Filter: 462144
                                        ->  Memoize  (cost=0.44..0.58 rows=1 width=8) (actual time=0.000..0.000 rows=1 loops=333667)
                                              Cache Key: t.session_id
                                              Cache Mode: logical
                                              Hits: 126049  Misses: 1116  Evictions: 0  Overflows: 0  Memory Usage: 118kB
                                              Worker 0:  Hits: 103055  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                              Worker 1:  Hits: 103441  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                              ->  Index Scan using sessions_pkey on sessions s  (cost=0.43..0.57 rows=1 width=8) (actual time=0.001..0.001 rows=1 loops=1122)
                                                    Index Cond: (session_id = t.session_id)
                                  ->  Memoize  (cost=0.44..1.25 rows=1 width=17) (actual time=0.000..0.000 rows=1 loops=333667)
                                        Cache Key: s.film_id
                                        Cache Mode: logical
                                        Hits: 126104  Misses: 1061  Evictions: 0  Overflows: 0  Memory Usage: 167kB
                                        Worker 0:  Hits: 103056  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                        Worker 1:  Hits: 103442  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                        ->  Index Scan using films_pkey on films f  (cost=0.43..1.24 rows=1 width=17) (actual time=0.001..0.001 rows=1 loops=1065)
                                              Index Cond: (film_id = s.film_id)
Planning Time: 1.144 ms
Execution Time: 224.641 ms


------------------------------------
explain analyze
    SELECT
        s.seat_row,
        s.seat_number,
        CASE
            WHEN t.ticket_id IS NULL THEN 'свободно'
            ELSE 'занято'
            END AS seat_status
    FROM
        seats s
            INNER JOIN
        halls h ON s.hall_id = h.hall_id
            LEFT JOIN
        tickets t ON s.seat_id = t.seat_id
            LEFT JOIN
        sessions ses ON t.session_id = ses.session_id
    WHERE
            ses.session_id = 14 -- ID сеанса
    ORDER BY
        s.seat_row,
        s.seat_number;

10 000

Sort  (cost=147.74..147.77 rows=12 width=40) (actual time=0.045..0.046 rows=12 loops=1)
"  Sort Key: s.seat_row, s.seat_number"
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=5.24..147.52 rows=12 width=40) (actual time=0.020..0.038 rows=12 loops=1)
        ->  Index Only Scan using sessions_pkey on sessions ses  (cost=0.29..4.30 rows=1 width=4) (actual time=0.005..0.006 rows=1 loops=1)
              Index Cond: (session_id = 14)
              Heap Fetches: 0
        ->  Nested Loop  (cost=4.96..143.10 rows=12 width=28) (actual time=0.011..0.028 rows=12 loops=1)
              ->  Nested Loop  (cost=4.67..139.45 rows=12 width=32) (actual time=0.009..0.020 rows=12 loops=1)
                    ->  Bitmap Heap Scan on tickets t  (cost=4.38..39.73 rows=12 width=24) (actual time=0.006..0.007 rows=12 loops=1)
                          Recheck Cond: (session_id = 14)
                          Heap Blocks: exact=1
                          ->  Bitmap Index Scan on idx_tickets_session  (cost=0.00..4.38 rows=12 width=0) (actual time=0.003..0.003 rows=12 loops=1)
                                Index Cond: (session_id = 14)
                    ->  Index Scan using seats_pkey on seats s  (cost=0.29..8.31 rows=1 width=16) (actual time=0.001..0.001 rows=1 loops=12)
                          Index Cond: (seat_id = t.seat_id)
              ->  Index Only Scan using halls_pkey on halls h  (cost=0.29..0.30 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=12)
                    Index Cond: (hall_id = s.hall_id)
                    Heap Fetches: 0
Planning Time: 0.309 ms
Execution Time: 0.089 ms

10 000 000

Gather Merge  (cost=26450.49..26456.09 rows=48 width=40) (actual time=61.446..65.740 rows=12 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=25450.47..25450.53 rows=24 width=40) (actual time=40.564..40.566 rows=4 loops=3)
"        Sort Key: s.seat_row, s.seat_number"
        Sort Method: quicksort  Memory: 25kB
        Worker 0:  Sort Method: quicksort  Memory: 25kB
        Worker 1:  Sort Method: quicksort  Memory: 25kB
        ->  Nested Loop  (cost=1.15..25449.92 rows=24 width=40) (actual time=20.282..40.545 rows=4 loops=3)
              ->  Nested Loop  (cost=0.72..25247.00 rows=24 width=28) (actual time=20.280..40.535 rows=4 loops=3)
                    ->  Nested Loop  (cost=0.43..25239.53 rows=24 width=32) (actual time=20.278..40.531 rows=4 loops=3)
                          ->  Parallel Seq Scan on tickets t  (cost=0.00..25036.85 rows=24 width=24) (actual time=20.274..40.523 rows=4 loops=3)
                                Filter: (session_id = 14)
                                Rows Removed by Filter: 573363
                          ->  Index Scan using seats_pkey on seats s  (cost=0.43..8.45 rows=1 width=16) (actual time=0.001..0.001 rows=1 loops=12)
                                Index Cond: (seat_id = t.seat_id)
                    ->  Index Only Scan using halls_pkey on halls h  (cost=0.29..0.31 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=12)
                          Index Cond: (hall_id = s.hall_id)
                          Heap Fetches: 0
              ->  Index Only Scan using sessions_pkey on sessions ses  (cost=0.43..8.45 rows=1 width=4) (actual time=0.002..0.002 rows=1 loops=12)
                    Index Cond: (session_id = 14)
                    Heap Fetches: 0
Planning Time: 0.269 ms
Execution Time: 65.769 ms

Oптимизация
    1. создан индекс на seat_id
    1. создан индекс на session_id
Результат
    уменьшение "cost" запроса
    уменьшение времени выполнения запроса

create index idx_tickets_seat_id on tickets (seat_id);
create index idx_tickets_session on tickets (session_id);

Sort  (cost=454.25..454.40 rows=57 width=40) (actual time=0.067..0.068 rows=12 loops=1)
"  Sort Key: s.seat_row, s.seat_number"
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=1.58..452.59 rows=57 width=40) (actual time=0.034..0.059 rows=12 loops=1)
        ->  Index Only Scan using sessions_pkey on sessions ses  (cost=0.43..8.45 rows=1 width=4) (actual time=0.013..0.013 rows=1 loops=1)
              Index Cond: (session_id = 14)
              Heap Fetches: 0
        ->  Nested Loop  (cost=1.16..443.58 rows=57 width=28) (actual time=0.020..0.043 rows=12 loops=1)
              ->  Nested Loop  (cost=0.86..425.84 rows=57 width=32) (actual time=0.015..0.030 rows=12 loops=1)
                    ->  Index Scan using idx_tickets_session on tickets t  (cost=0.43..9.43 rows=57 width=24) (actual time=0.007..0.009 rows=12 loops=1)
                          Index Cond: (session_id = 14)
                    ->  Memoize  (cost=0.44..8.46 rows=1 width=16) (actual time=0.002..0.002 rows=1 loops=12)
                          Cache Key: t.seat_id
                          Cache Mode: logical
                          Hits: 1  Misses: 11  Evictions: 0  Overflows: 0  Memory Usage: 2kB
                          ->  Index Scan using seats_pkey on seats s  (cost=0.43..8.45 rows=1 width=16) (actual time=0.001..0.001 rows=1 loops=11)
                                Index Cond: (seat_id = t.seat_id)
              ->  Index Only Scan using halls_pkey on halls h  (cost=0.29..0.31 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=12)
                    Index Cond: (hall_id = s.hall_id)
                    Heap Fetches: 0
Planning Time: 1.027 ms
Execution Time: 0.093 ms
