-------------------------------------1. Выбор всех фильмов на сегодня----------------------------------------------
EXPLAIN ANALYZE SELECT * FROM sessions
    WHERE date = CURRENT_DATE;

-- без индексов
---------------------------------------------QUERY PLAN----------------------------------------------------------
Seq Scan on sessions  (cost=0.00..224.00 rows=25 width=28) (actual time=0.065..2.020 rows=23 loops=1)
Filter: (date = CURRENT_DATE)
Rows Removed by Filter: 9977
Planning Time: 0.162 ms
Execution Time: 2.063 ms

-- время сканирования: 0.00 - оценочная стоимость для запуска поиска и 224.00 - оценочная общая стоимость для обработки всех строк
-- фактическое время на запуск поиска: 0.162 ms
-- фактическое время на выполнение поиска: 2.063 ms

-- с индексом
CREATE INDEX idx_date ON sessions (date);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Bitmap Heap Scan on sessions  (cost=4.48..56.87 rows=25 width=28) (actual time=0.085..0.121 rows=23 loops=1)
Recheck Cond: (date = CURRENT_DATE)
Heap Blocks: exact=22
->  Bitmap Index Scan on idx_date  (cost=0.00..4.48 rows=25 width=0) (actual time=0.072..0.073 rows=23 loops=1)
        Index Cond: (date = CURRENT_DATE)
Planning Time: 0.612 ms
Execution Time: 0.143 ms

-- время сканирования: 4.48 - оценочная стоимость для запуска поиска и 56.87 - оценочная общая стоимость для обработки всех строк
-- фактическое время на запуск поиска: 0.612
-- фактическое время на выполнение поиска: 0.143

-- Вывод: использование индекса повысило скорость запроса почти в 3 раза (с у четом времени на заруск запроса) (2,063 + 0,162) / (0.612 + 0.143)) = 2,94701987

DROP INDEX idx_date;

--------------------------------------- 2. Подсчёт проданных билетов за неделю----------------------------------------------
EXPLAIN ANALYZE SELECT count(*)
    FROM tickets t 
        JOIN sessions s ON t.session_id = s.id 
    WHERE s.date >= CURRENT_DATE - INTERVAL '7 days' AND s.date < CURRENT_DATE;

-- без индексов
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Aggregate  (cost=492.07..492.08 rows=1 width=8) (actual time=6.651..6.654 rows=1 loops=1)
   ->  Hash Join  (cost=301.34..491.60 rows=187 width=0) (actual time=3.681..6.600 rows=188 loops=1)
         Hash Cond: (t.session_id = s.id)
         ->  Seq Scan on tickets t  (cost=0.00..164.00 rows=10000 width=4) (actual time=0.017..1.349 rows=10000 loops=1)
         ->  Hash  (cost=299.00..299.00 rows=187 width=4) (actual time=3.605..3.606 rows=177 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 15kB
               ->  Seq Scan on sessions s  (cost=0.00..299.00 rows=187 width=4) (actual time=0.020..3.554 rows=177 loops=1)
                     Filter: ((date < CURRENT_DATE) AND (date >= (CURRENT_DATE - '7 days'::interval)))
                     Rows Removed by Filter: 9823
Planning Time: 0.646 ms
Execution Time: 6.826 ms

-- сначала происходит сканирование всех sessions методом Seq Scan,
-- затем результат сканирования передается узлу Hash,
-- затем происходит сканирование всех tickets методом Seq Scan,
-- затем Hash Join соединит строки (количество строк - 188),
-- затем Aggregate выполнит агрегатную функцию (count(*)) 
-- фактическое время на запуск поиска: 0.646 ms
-- фактическое время на выполнение поиска: 6.826 ms

-- с индексом
CREATE INDEX idx_date ON sessions (date);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
  Aggregate  (cost=277.48..277.49 rows=1 width=8) (actual time=2.085..2.088 rows=1 loops=1)
   ->  Hash Join  (cost=86.75..277.02 rows=187 width=0) (actual time=0.248..2.070 rows=188 loops=1)
         Hash Cond: (t.session_id = s.id)
         ->  Seq Scan on tickets t  (cost=0.00..164.00 rows=10000 width=4) (actual time=0.010..0.821 rows=10000 loops=1)
         ->  Hash  (cost=84.42..84.42 rows=187 width=4) (actual time=0.217..0.218 rows=177 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 15kB
               ->  Bitmap Heap Scan on sessions s  (cost=6.21..84.42 rows=187 width=4) (actual time=0.047..0.186 rows=177 loops=1)
                     Recheck Cond: ((date >= (CURRENT_DATE - '7 days'::interval)) AND (date < CURRENT_DATE))
                     Heap Blocks: exact=69
                     ->  Bitmap Index Scan on idx_date  (cost=0.00..6.16 rows=187 width=0) (actual time=0.032..0.032 rows=177 loops=1)
                           Index Cond: ((date >= (CURRENT_DATE - '7 days'::interval)) AND (date < CURRENT_DATE))
Planning Time: 0.577 ms
Execution Time: 2.126 ms

 -- метод поиска sessions изменился с Seq Scan на Bitmap Heap Scan
-- Вывод: использование индекса idx_date повысило скорость запроса почти в 3 раза (2,76433592)

-- с индексами
CREATE INDEX idx_date ON sessions (date);
create index idx_tsid on tickets (session_id);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
  Aggregate  (cost=252.46..252.47 rows=1 width=8) (actual time=1.457..1.458 rows=1 loops=1)
   ->  Nested Loop  (cost=6.49..252.00 rows=187 width=0) (actual time=0.071..1.392 rows=188 loops=1)
         ->  Bitmap Heap Scan on sessions s  (cost=6.21..84.42 rows=187 width=4) (actual time=0.051..0.313 rows=177 loops=1)
               Recheck Cond: ((date >= (CURRENT_DATE - '7 days'::interval)) AND (date < CURRENT_DATE))
               Heap Blocks: exact=69
               ->  Bitmap Index Scan on idx_date  (cost=0.00..6.16 rows=187 width=0) (actual time=0.024..0.025 rows=177 loops=1)
                     Index Cond: ((date >= (CURRENT_DATE - '7 days'::interval)) AND (date < CURRENT_DATE))
         ->  Index Only Scan using idx_tsid on tickets t  (cost=0.29..0.88 rows=2 width=4) (actual time=0.005..0.006 rows=1 loops=177)
               Index Cond: (session_id = s.id)
               Heap Fetches: 0
Planning Time: 1.100 ms
Execution Time: 1.512 ms

 -- Вывод: использование индексов idx_date и idx_tsid повысило скорость запроса почти в 3 раза (2,86064319),
 -- но за счет увеличения времени подготовки с поиску введение второго индекса практически не повлияло на производительность

DROP INDEX idx_date;
DROP INDEX idx_tsid;

---------------------------------------3. Формирование афиши (фильмы, которые показывают сегодня)----------------------------------------------
EXPLAIN ANALYZE SELECT m.name, s.begin_time, s.duration
    FROM sessions s 
        JOIN movies m ON s.movie_id = m.id 
    WHERE date = CURRENT_DATE;

-- с индексом PK (movies_pkey)
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Nested Loop  (cost=0.29..387.56 rows=25 width=28) (actual time=0.060..1.731 rows=23 loops=1)
   ->  Seq Scan on sessions s  (cost=0.00..224.00 rows=25 width=16) (actual time=0.036..1.340 rows=23 loops=1)
         Filter: (date = CURRENT_DATE)
         Rows Removed by Filter: 9977
   ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.54 rows=1 width=20) (actual time=0.016..0.016 rows=1 loops=23)
         Index Cond: (id = s.movie_id)
Planning Time: 0.441 ms
Execution Time: 1.761 ms

-- с индексами PK (movies_pkey) и ...
CREATE INDEX idx_date ON sessions (date);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Nested Loop  (cost=4.77..220.43 rows=25 width=28) (actual time=0.135..0.423 rows=23 loops=1)
   ->  Bitmap Heap Scan on sessions s  (cost=4.48..56.87 rows=25 width=16) (actual time=0.112..0.192 rows=23 loops=1)
         Recheck Cond: (date = CURRENT_DATE)
         Heap Blocks: exact=22
         ->  Bitmap Index Scan on idx_sdate  (cost=0.00..4.48 rows=25 width=0) (actual time=0.089..0.089 rows=23 loops=1)
               Index Cond: (date = CURRENT_DATE)
   ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.54 rows=1 width=20) (actual time=0.009..0.009 rows=1 loops=23)
         Index Cond: (id = s.movie_id)
Planning Time: 0.713 ms
Execution Time: 0.471 ms

-- Вывод: увеличение производительности почти в 2 раза

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
Limit  (cost=609.81..609.82 rows=3 width=52) (actual time=5.826..5.831 rows=3 loops=1)
   ->  Sort  (cost=609.81..610.02 rows=85 width=52) (actual time=5.823..5.827 rows=3 loops=1)
         Sort Key: (sum(t.price)) DESC
         Sort Method: top-N heapsort  Memory: 25kB
         ->  GroupAggregate  (cost=607.01..608.71 rows=85 width=52) (actual time=5.682..5.778 rows=66 loops=1)
               Group Key: m.id
               ->  Sort  (cost=607.01..607.23 rows=85 width=26) (actual time=5.665..5.681 rows=79 loops=1)
                     Sort Key: m.id
                     Sort Method: quicksort  Memory: 28kB
                     ->  Nested Loop  (cost=251.94..604.29 rows=85 width=26) (actual time=3.056..5.569 rows=79 loops=1)
                           ->  Hash Join  (cost=251.65..426.22 rows=85 width=10) (actual time=3.035..5.081 rows=79 loops=1)
                                 Hash Cond: (t.session_id = s.id)
                                 ->  Seq Scan on tickets t  (cost=0.00..164.00 rows=4026 width=10) (actual time=0.018..1.536 rows=4026 loops=1)
                                       Filter: is_sold
                                       Rows Removed by Filter: 5974
                                 ->  Hash  (cost=249.00..249.00 rows=212 width=8) (actual time=2.994..2.995 rows=200 loops=1)
                                       Buckets: 1024  Batches: 1  Memory Usage: 16kB
                                       ->  Seq Scan on sessions s  (cost=0.00..249.00 rows=212 width=8) (actual time=0.012..2.937 rows=200 loops=1)
                                             Filter: (date >= (CURRENT_DATE - '7 days'::interval))
                                             Rows Removed by Filter: 9800
                           ->  Index Scan using movies_pkey on movies m  (cost=0.29..2.09 rows=1 width=20) (actual time=0.005..0.005 rows=1 loops=79)
                                 Index Cond: (id = s.movie_id)
Planning Time: 0.707 ms
Execution Time: 5.908 ms

-- с индексами PK (movies_pkey) и ...
CREATE INDEX idx_date ON sessions (date);
CREATE INDEX idx_price ON tickets (price);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
 Limit  (cost=444.46..444.46 rows=3 width=52) (actual time=2.754..2.758 rows=3 loops=1)
   ->  Sort  (cost=444.46..444.67 rows=85 width=52) (actual time=2.752..2.755 rows=3 loops=1)
         Sort Key: (sum(t.price)) DESC
         Sort Method: top-N heapsort  Memory: 25kB
         ->  GroupAggregate  (cost=441.66..443.36 rows=85 width=52) (actual time=2.673..2.728 rows=66 loops=1)
               Group Key: m.id
               ->  Sort  (cost=441.66..441.87 rows=85 width=26) (actual time=2.658..2.665 rows=79 loops=1)
                     Sort Key: m.id
                     Sort Method: quicksort  Memory: 28kB
                     ->  Nested Loop  (cost=86.58..438.93 rows=85 width=26) (actual time=0.392..2.620 rows=79 loops=1)
                           ->  Hash Join  (cost=86.29..260.86 rows=85 width=10) (actual time=0.379..2.245 rows=79 loops=1)
                                 Hash Cond: (t.session_id = s.id)
                                 ->  Seq Scan on tickets t  (cost=0.00..164.00 rows=4026 width=10) (actual time=0.018..1.485 rows=4026 loops=1)
                                       Filter: is_sold
                                       Rows Removed by Filter: 5974
                                 ->  Hash  (cost=83.64..83.64 rows=212 width=8) (actual time=0.334..0.334 rows=200 loops=1)
                                       Buckets: 1024  Batches: 1  Memory Usage: 16kB
                                       ->  Bitmap Heap Scan on sessions s  (cost=5.93..83.64 rows=212 width=8) (actual time=0.040..0.288 rows=200 loops=1)
                                             Recheck Cond: (date >= (CURRENT_DATE - '7 days'::interval))
                                             Heap Blocks: exact=70
                                             ->  Bitmap Index Scan on idx_date  (cost=0.00..5.88 rows=212 width=0) (actual time=0.021..0.021 rows=200 loops=1)
                                                   Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))
                           ->  Index Scan using movies_pkey on movies m  (cost=0.29..2.09 rows=1 width=20) (actual time=0.004..0.004 rows=1 loops=79)
                                 Index Cond: (id = s.movie_id)
Planning Time: 0.490 ms
Execution Time: 2.825 ms

-- Вывод: увеличение производительности почти в 2 раза (1,99547511)

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
Nested Loop  (cost=0.86..213.93 rows=2 width=62) (actual time=0.651..0.803 rows=2 loops=1)
   ->  Nested Loop  (cost=0.86..24.91 rows=1 width=24) (actual time=0.031..0.034 rows=1 loops=1)
         ->  Nested Loop  (cost=0.57..16.61 rows=1 width=12) (actual time=0.022..0.024 rows=1 loops=1)
               ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..8.30 rows=1 width=12) (actual time=0.013..0.015 rows=1 loops=1)
                     Index Cond: (id = 102)
               ->  Index Scan using halls_pkey on halls h  (cost=0.29..8.30 rows=1 width=8) (actual time=0.004..0.004 rows=1 loops=1)
                     Index Cond: (id = s.hall_id)
         ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=20) (actual time=0.009..0.009 rows=1 loops=1)
               Index Cond: (id = s.movie_id)
   ->  Seq Scan on tickets t  (cost=0.00..189.00 rows=2 width=15) (actual time=0.618..0.766 rows=2 loops=1)
         Filter: (session_id = 102)
         Rows Removed by Filter: 9998
Planning Time: 0.475 ms
Execution Time: 0.844 ms

-- с индексами PK (sessions_pkey, halls_pkey, movies_pkey) и ...
CREATE INDEX idx_session_id ON tickets (session_id);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Nested Loop  (cost=5.16..36.20 rows=2 width=62) (actual time=0.122..0.129 rows=2 loops=1)
   ->  Nested Loop  (cost=0.86..24.91 rows=1 width=24) (actual time=0.041..0.043 rows=1 loops=1)
         ->  Nested Loop  (cost=0.57..16.61 rows=1 width=12) (actual time=0.029..0.031 rows=1 loops=1)
               ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..8.30 rows=1 width=12) (actual time=0.015..0.016 rows=1 loops=1)
                     Index Cond: (id = 102)
               ->  Index Scan using halls_pkey on halls h  (cost=0.29..8.30 rows=1 width=8) (actual time=0.005..0.006 rows=1 loops=1)
                     Index Cond: (id = s.hall_id)
         ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=20) (actual time=0.010..0.010 rows=1 loops=1)
               Index Cond: (id = s.movie_id)
   ->  Bitmap Heap Scan on tickets t  (cost=4.30..11.26 rows=2 width=15) (actual time=0.076..0.080 rows=2 loops=1)
         Recheck Cond: (session_id = 102)
         Heap Blocks: exact=2
         ->  Bitmap Index Scan on idx_session_id  (cost=0.00..4.30 rows=2 width=0) (actual time=0.061..0.061 rows=2 loops=1)
               Index Cond: (session_id = 102)
Planning Time: 0.863 ms
Execution Time: 0.186 ms

 -- Вывод: относительно незначительное увеличение производительности в 1,25738799 раза (0.475 + 0.844) / (0.863 + 0.186) обуслвлено тем, 
 -- что поиск по 3 из 4х столбцов в запросе осуществлялся изначально по алгоритму Index Scan по первочным ключам

 ---------------------------------------6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс----------------------------------------------
EXPLAIN ANALYZE SELECT MIN(price) AS min_price,
       MAX(price) AS man_price
    FROM sessions s
        JOIN tickets t ON s.id = t.session_id
    WHERE s.id = <sessionID>;

-- с индексм PK (sessions_pkey)
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Aggregate  (cost=193.33..193.34 rows=1 width=64) (actual time=1.335..1.336 rows=1 loops=1)
   ->  Nested Loop  (cost=0.29..193.32 rows=2 width=6) (actual time=1.051..1.285 rows=2 loops=1)
         ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.29..4.30 rows=1 width=4) (actual time=0.036..0.037 rows=1 loops=1)
               Index Cond: (id = 102)
               Heap Fetches: 0
         ->  Seq Scan on tickets t  (cost=0.00..189.00 rows=2 width=10) (actual time=1.013..1.244 rows=2 loops=1)
               Filter: (session_id = 102)
               Rows Removed by Filter: 9998
Planning Time: 0.380 ms
Execution Time: 1.410 ms

 -- с индексами PK (sessions_pkey) и ...
CREATE INDEX idx_session_id ON tickets (session_id);
CREATE INDEX idx_price ON tickets (price);
----------------------------------------------QUERY PLAN---------------------------------------------------------------------
Aggregate  (cost=15.60..15.61 rows=1 width=64) (actual time=0.051..0.052 rows=1 loops=1)
   ->  Nested Loop  (cost=4.59..15.59 rows=2 width=6) (actual time=0.035..0.040 rows=2 loops=1)
         ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.29..4.30 rows=1 width=4) (actual time=0.014..0.015 rows=1 loops=1)
               Index Cond: (id = 102)
               Heap Fetches: 0
         ->  Bitmap Heap Scan on tickets t  (cost=4.30..11.26 rows=2 width=10) (actual time=0.018..0.021 rows=2 loops=1)
               Recheck Cond: (session_id = 102)
               Heap Blocks: exact=2
               ->  Bitmap Index Scan on idx_session_id  (cost=0.00..4.30 rows=2 width=0) (actual time=0.009..0.009 rows=2 loops=1)
                     Index Cond: (session_id = 102)
Planning Time: 0.403 ms
Execution Time: 0.093 ms

-- Вывод: увеличение производительности в 3.6 раза (3,60887097) (0.380 + 1.410) / (0.403 + 0.093)