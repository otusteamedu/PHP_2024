-- 1.1 Выбор всех фильмов на сегодня без оптимизации
EXPLAIN ANALYZE SELECT * FROM Movies WHERE release_date = CURRENT_DATE;

QUERY PLAN
Seq Scan on movies  (cost=0.00..244.00 rows=5 width=42) (actual time=0.061..0.823 rows=8 loops=1)
Filter: (release_date = CURRENT_DATE)
Rows Removed by Filter: 9992
Planning Time: 0.166 ms
Execution Time: 0.858 ms

-- 1.2 Выбор всех фильмов на сегодня с индексом на release_date
CREATE INDEX idx_release_date ON movies (release_date);

QUERY PLAN
Bitmap Heap Scan on movies  (cost=4.33..20.94 rows=5 width=42) (actual time=0.078..0.089 rows=8 loops=1)
  Recheck Cond: (release_date = CURRENT_DATE)
  Heap Blocks: exact=7
  ->  Bitmap Index Scan on idx_release_date  (cost=0.00..4.33 rows=5 width=0) (actual time=0.054..0.055 rows=8 loops=1)
        Index Cond: (release_date = CURRENT_DATE)
Planning Time: 0.488 ms
Execution Time: 0.108 ms

/**
    Результаты выполнения запроса показывают существенные различия в плане выполнения и времени выполнения между
    использованием индекса и последовательным сканированием таблицы.
    1. Тип сканирования
    Без индекса: Используется Seq Scan (последовательное сканирование) — то есть PostgreSQL читает всю таблицу и
    применяет фильтр (release_date = CURRENT_DATE) ко всем строкам.

    С индексом: Используется Bitmap Heap Scan, где поиск начинается с Bitmap Index Scan. Индекс позволяет сразу найти
    нужные строки, а затем — обратиться к соответствующим блокам таблицы.
    ####################################################################################################################
    2. Фильтрация строк
    Без индекса: PostgreSQL перебрал 10,000 строк, из которых 9992 были отброшены.

    С индексом: Индекс позволил сразу найти только 8 строк, которые соответствуют условию, без необходимости полного
    перебора.
    ####################################################################################################################
    3. Временные характеристики
    Без индекса: Время планирования (Planning Time): 0.166 ms. Время выполнения (Execution Time): 0.858 ms.

    С индексом: Время планирования: 0.488 ms (чуть больше из-за использования индекса). Время выполнения: 0.108 ms
    (значительно быстрее благодаря индексу).
    ####################################################################################################################
    4. Итог
    Использование индекса позволило существенно сократить общее время выполнения запроса (почти в 8 раз).
    Вместо полного перебора всех строк таблицы с помощью Seq Scan, запрос быстро нашел нужные строки через индекс и
    обратился к ним напрямую.
    Индексирование столбца release_date значительно улучшает производительность запросов, особенно если условие
    фильтрации (WHERE release_date = CURRENT_DATE) избирательно и охватывает малую долю записей таблицы.
 */
DROP INDEX idx_release_date;
-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################



-- 2.1 Подсчёт проданных билетов за неделю без оптимизации
EXPLAIN ANALYZE
SELECT COUNT(*) AS tickets_sold
FROM Tickets
WHERE session_id IN (
    SELECT id
    FROM Sessions
    WHERE start_time >= CURRENT_DATE - INTERVAL '7 days'
  AND start_time < CURRENT_DATE
    );

QUERY PLAN
Aggregate  (cost=501.78..501.79 rows=1 width=8) (actual time=2.182..2.184 rows=1 loops=1)
  ->  Hash Join  (cost=301.10..501.36 rows=168 width=0) (actual time=1.235..2.174 rows=176 loops=1)
        Hash Cond: (tickets.session_id = sessions.id)
        ->  Seq Scan on tickets  (cost=0.00..174.00 rows=10000 width=4) (actual time=0.006..0.403 rows=10000 loops=1)
        ->  Hash  (cost=299.00..299.00 rows=168 width=4) (actual time=1.216..1.217 rows=171 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 15kB
              ->  Seq Scan on sessions  (cost=0.00..299.00 rows=168 width=4) (actual time=0.008..1.197 rows=171 loops=1)
                    Filter: ((start_time < CURRENT_DATE) AND (start_time >= (CURRENT_DATE - '7 days'::interval)))
                    Rows Removed by Filter: 9829
Planning Time: 0.240 ms
Execution Time: 2.208 ms

-- 2.1 Подсчёт проданных билетов за неделю с индексами на start_time и session_id, а
CREATE INDEX idx_sessions_start_time ON Sessions (start_time);
CREATE INDEX idx_tickets_session_id ON Tickets (session_id);

QUERY PLAN
Aggregate  (cost=249.33..249.34 rows=1 width=8) (actual time=0.501..0.512 rows=1 loops=1)
  ->  Nested Loop  (cost=6.30..248.91 rows=168 width=0) (actual time=0.048..0.500 rows=176 loops=1)
        ->  Bitmap Heap Scan on sessions s  (cost=6.01..83.79 rows=168 width=4) (actual time=0.043..0.274 rows=171 loops=1)
              Recheck Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time < CURRENT_DATE))
              Heap Blocks: exact=65
              ->  Bitmap Index Scan on idx_sessions_start_time  (cost=0.00..5.97 rows=168 width=0) (actual time=0.018..0.028 rows=171 loops=1)
                    Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time < CURRENT_DATE))
        ->  Index Only Scan using idx_tickets_session_id on tickets t  (cost=0.29..0.96 rows=2 width=4) (actual time=0.001..0.001 rows=1 loops=171)
              Index Cond: (session_id = s.id)
              Heap Fetches: 0
Planning Time: 0.522 ms
Execution Time: 0.570 ms

/**
    1. Без индекса:
        - Общая стоимость (cost): 501.78..501.79.
        - Фактическое время выполнения: 2.182..2.184 ms.
        - Основной алгоритм соединения: Hash Join. Используется хэш-таблица для соединения данных.
        - Детали плана:
            * Таблица tickets полностью сканируется (Seq Scan), что затратно по времени (0.006..0.403 ms), так как нужно
            пройти все 10,000 строк.
            * Таблица sessions также сканируется полностью (Seq Scan). Для отбора строк используется фильтр по дате, из
            10,000 строк остается только 171, а 9,829 строк отбрасываются.
            * Для соединения двух таблиц по session_id создается хэш-таблица, что требует дополнительной памяти и
            увеличивает общее время выполнения.
    2. С индексом:
        - Общая стоимость (cost): 249.33..249.34.
        - Фактическое время выполнения: 0.469..0.470 ms.
        - Основной алгоритм соединения: Nested Loop. Индексы используются для выборки данных.
        - Детали плана:
            * Таблица sessions обрабатывается с использованием индекса idx_sessions_start_time. Вместо полного
            сканирования используется Bitmap Index Scan, что значительно ускоряет выборку (0.043..0.146 ms).
            * Таблица tickets обрабатывается с использованием индекса idx_tickets_session_id. Это позволяет избежать
            сканирования всей таблицы и выбирать только необходимые строки.
            * Соединение выполняется через вложенный цикл (Nested Loop), где для каждой строки из sessions используется
            индекс для выборки из tickets. Это эффективно, так как таблица sessions уже фильтруется индексом.
    3. Итог
    Общая стоимость снизилось на ~50%. Время выполнения 4 раза быстрее. Использование индексов позволяет эффективно
    извлекать строки. Устранили  хеширование и полное сканирования
 */
-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################

-- 3.1 Формирование афиши без оптимизации
EXPLAIN ANALYZE
SELECT DISTINCT Movies.*
FROM Movies
         JOIN Sessions ON Movies.id = Sessions.movie_id
WHERE DATE(Sessions.start_time) = CURRENT_DATE;

QUERY PLAN
Unique  (cost=537.54..538.29 rows=50 width=42) (actual time=1.264..1.271 rows=26 loops=1)
  ->  Sort  (cost=537.54..537.66 rows=50 width=42) (actual time=1.262..1.265 rows=26 loops=1)
"        Sort Key: movies.id, movies.title, movies.duration, movies.genre, movies.release_date"
        Sort Method: quicksort  Memory: 26kB
        ->  Nested Loop  (cost=0.29..536.13 rows=50 width=42) (actual time=0.064..0.999 rows=26 loops=1)
              ->  Seq Scan on sessions  (cost=0.00..249.00 rows=50 width=4) (actual time=0.048..0.897 rows=26 loops=1)
                    Filter: (date(start_time) = CURRENT_DATE)
                    Rows Removed by Filter: 9974
              ->  Index Scan using movies_pkey on movies  (cost=0.29..5.74 rows=1 width=42) (actual time=0.003..0.003 rows=1 loops=26)
                    Index Cond: (id = sessions.movie_id)
Planning Time: 0.272 ms
Execution Time: 1.323 ms

-- 3.1 Формирование афиши с индексом на DATE(start_time)
CREATE INDEX sessions_start_date_idx ON sessions (DATE(start_time));

QUERY PLAN
Unique  (cost=364.39..365.14 rows=50 width=42) (actual time=0.113..0.118 rows=26 loops=1)
  ->  Sort  (cost=364.39..364.52 rows=50 width=42) (actual time=0.112..0.113 rows=26 loops=1)
"        Sort Key: movies.id, movies.title, movies.duration, movies.genre, movies.release_date"
        Sort Method: quicksort  Memory: 26kB
        ->  Nested Loop  (cost=4.96..362.98 rows=50 width=42) (actual time=0.020..0.099 rows=26 loops=1)
              ->  Bitmap Heap Scan on sessions  (cost=4.68..75.86 rows=50 width=4) (actual time=0.013..0.036 rows=26 loops=1)
                    Recheck Cond: (date(start_time) = CURRENT_DATE)
                    Heap Blocks: exact=21
                    ->  Bitmap Index Scan on sessions_start_date_idx  (cost=0.00..4.66 rows=50 width=0) (actual time=0.007..0.007 rows=26 loops=1)
                          Index Cond: (date(start_time) = CURRENT_DATE)
              ->  Index Scan using movies_pkey on movies  (cost=0.29..5.74 rows=1 width=42) (actual time=0.002..0.002 rows=1 loops=26)
                    Index Cond: (id = sessions.movie_id)
Planning Time: 0.171 ms
Execution Time: 0.138 ms

/**
    1. Без индекса:
        - Общая стоимость (cost): 537.54 до 538.29.
        - Фактическое время выполнения: 1.323 ms.
        - Детали плана:
            * Используется последовательное сканирование таблицы sessions (Seq Scan), что приводит к необходимости
            сканировать все строки (10,000 строк, из которых 9,974 были отфильтрованы).
    2. С индексом:
        - Общая стоимость (cost): от 364.39 до 365.14.
        - Фактическое время выполнения:  0.138 ms.
        - Основной алгоритм: Bitmap Index Scan.
        - Детали плана:
            * Bitmap Index Scan на индексе sessions_start_date_idx позволяет сразу выбрать только нужные строки,
            удовлетворяющие условию date(start_time) = CURRENT_DATE.
            * Вместо последовательного сканирования всей таблицы (с удалением ненужных строк) используется точный доступ
            к данным, что снижает затраты на CPU и I/O.
    3. Итог
    Добавление индекса на sessions.start_time существенно улучшило производительность запроса за счет уменьшения объема
    обрабатываемых данных и использования более эффективного метода фильтрации.
 */
-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################

-- 4. Поиск 3 самых прибыльных фильмов за неделю без оптимизации
EXPLAIN ANALYZE
SELECT Movies.title, SUM(TicketSales.total_amount) AS total_revenue
FROM TicketSales
         JOIN Tickets ON TicketSales.ticket_id = Tickets.id
         JOIN Sessions ON Tickets.session_id = Sessions.id
         JOIN Movies ON Sessions.movie_id = Movies.id
WHERE TicketSales.sale_time >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY Movies.id, Movies.title
ORDER BY total_revenue DESC
    LIMIT 3;


QUERY PLAN
Limit  (cost=1080.07..1080.08 rows=3 width=48) (actual time=6.507..6.513 rows=3 loops=1)
  ->  Sort  (cost=1080.07..1083.24 rows=1267 width=48) (actual time=6.505..6.511 rows=3 loops=1)
        Sort Key: (sum(ticketsales.total_amount)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  HashAggregate  (cost=1047.86..1063.70 rows=1267 width=48) (actual time=6.084..6.325 rows=1051 loops=1)
              Group Key: movies.id
              Batches: 1  Memory Usage: 577kB
              ->  Hash Join  (cost=797.35..1041.52 rows=1267 width=21) (actual time=4.175..5.466 rows=1265 loops=1)
                    Hash Cond: (movies.id = sessions.movie_id)
                    ->  Seq Scan on movies  (cost=0.00..194.00 rows=10000 width=16) (actual time=0.005..0.477 rows=10000 loops=1)
                    ->  Hash  (cost=781.51..781.51 rows=1267 width=9) (actual time=4.158..4.162 rows=1265 loops=1)
                          Buckets: 2048  Batches: 1  Memory Usage: 71kB
                          ->  Hash Join  (cost=557.35..781.51 rows=1267 width=9) (actual time=2.842..3.997 rows=1265 loops=1)
                                Hash Cond: (sessions.id = tickets.session_id)
                                ->  Seq Scan on sessions  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.003..0.397 rows=10000 loops=1)
                                ->  Hash  (cost=541.51..541.51 rows=1267 width=9) (actual time=2.828..2.831 rows=1265 loops=1)
                                      Buckets: 2048  Batches: 1  Memory Usage: 71kB
                                      ->  Hash Join  (cost=254.84..541.51 rows=1267 width=9) (actual time=1.513..2.687 rows=1265 loops=1)
                                            Hash Cond: (tickets.id = ticketsales.ticket_id)
                                            ->  Seq Scan on tickets  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.004..0.399 rows=10000 loops=1)
                                            ->  Hash  (cost=239.00..239.00 rows=1267 width=9) (actual time=1.495..1.495 rows=1265 loops=1)
                                                  Buckets: 2048  Batches: 1  Memory Usage: 71kB
                                                  ->  Seq Scan on ticketsales  (cost=0.00..239.00 rows=1267 width=9) (actual time=0.008..1.357 rows=1265 loops=1)
                                                        Filter: (sale_time >= (CURRENT_DATE - '7 days'::interval))
                                                        Rows Removed by Filter: 8735
Planning Time: 0.561 ms
Execution Time: 6.640 ms

-- 4. Поиск 3 самых прибыльных фильмов за неделю используем индексы
-- Для таблицы TicketSales:
CREATE INDEX idx_ticket_sales_sale_time ON TicketSales(sale_time);
CREATE INDEX idx_ticket_sales_ticket_id ON TicketSales(ticket_id);

-- Для таблицы Tickets:
CREATE INDEX idx_tickets_session_id ON Tickets(session_id);

-- Для таблицы Sessions:
CREATE INDEX idx_sessions_movie_id ON Sessions(movie_id);

-- Для таблицы Movies:
CREATE INDEX idx_movies_id ON Movies(id);

QUERY PLAN
Limit  (cost=953.35..953.36 rows=3 width=48) (actual time=7.752..7.758 rows=3 loops=1)
  ->  Sort  (cost=953.35..956.52 rows=1267 width=48) (actual time=7.750..7.755 rows=3 loops=1)
        Sort Key: (sum(ticketsales.total_amount)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  HashAggregate  (cost=921.14..936.98 rows=1267 width=48) (actual time=7.256..7.485 rows=1051 loops=1)
              Group Key: movies.id
              Batches: 1  Memory Usage: 577kB
              ->  Hash Join  (cost=670.63..914.80 rows=1267 width=21) (actual time=5.327..6.580 rows=1265 loops=1)
                    Hash Cond: (movies.id = sessions.movie_id)
                    ->  Seq Scan on movies  (cost=0.00..194.00 rows=10000 width=16) (actual time=0.008..0.425 rows=10000 loops=1)
                    ->  Hash  (cost=654.80..654.80 rows=1267 width=9) (actual time=5.275..5.278 rows=1265 loops=1)
                          Buckets: 2048  Batches: 1  Memory Usage: 71kB
                          ->  Hash Join  (cost=430.63..654.80 rows=1267 width=9) (actual time=4.034..5.160 rows=1265 loops=1)
                                Hash Cond: (sessions.id = tickets.session_id)
                                ->  Seq Scan on sessions  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.004..0.387 rows=10000 loops=1)
                                ->  Hash  (cost=414.79..414.79 rows=1267 width=9) (actual time=4.024..4.027 rows=1265 loops=1)
                                      Buckets: 2048  Batches: 1  Memory Usage: 71kB
                                      ->  Hash Join  (cost=128.12..414.79 rows=1267 width=9) (actual time=0.784..3.779 rows=1265 loops=1)
                                            Hash Cond: (tickets.id = ticketsales.ticket_id)
                                            ->  Seq Scan on tickets  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.015..1.338 rows=10000 loops=1)
                                            ->  Hash  (cost=112.28..112.28 rows=1267 width=9) (actual time=0.727..0.729 rows=1265 loops=1)
                                                  Buckets: 2048  Batches: 1  Memory Usage: 71kB
                                                  ->  Bitmap Heap Scan on ticketsales  (cost=26.11..112.28 rows=1267 width=9) (actual time=0.089..0.460 rows=1265 loops=1)
                                                        Recheck Cond: (sale_time >= (CURRENT_DATE - '7 days'::interval))
                                                        Heap Blocks: exact=64
                                                        ->  Bitmap Index Scan on idx_ticket_sales_sale_time  (cost=0.00..25.79 rows=1267 width=0) (actual time=0.078..0.078 rows=1265 loops=1)
                                                              Index Cond: (sale_time >= (CURRENT_DATE - '7 days'::interval))
Planning Time: 1.137 ms
Execution Time: 7.893 ms

/**
   cost:
        было: 1080.07..1080.08
        стало: 953.35..953.36
        изменения: Стоимость выполнения запроса снизилась с 1080.07 до 953.35. Несущественные изменения
    actual time:
        было: 6.507..6.513
        стало: 7.752..7.758
        изменения: Время фактического выполнения запроса увеличилось с 6.507 до 7.752 мс. Несмотря на улучшение стоимости запроса, использование индекса увеличило общее время выполнения
    execution Time:
        было: 6.640 ms
        стало: 7.893 ms
        изменения: Время выполнения запроса увеличилось с 6.640 до 7.893 мс.
    Индекс повлиял отрицательно
 */
-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################
-- 5. Схема зала без оптимизации
EXPLAIN ANALYZE
SELECT
    Seats.row,
    Seats.seat_number,
    CASE
        WHEN Tickets.id IS NOT NULL THEN 'Занято'
        ELSE 'Свободно'
        END AS seat_status
FROM Seats
         LEFT JOIN Tickets ON Seats.id = Tickets.seat_id AND Tickets.session_id = 4
WHERE Seats.hall_id = (
    SELECT hall_id
    FROM Sessions
    WHERE id = 2
    );

QUERY PLAN
Nested Loop Left Join  (cost=8.30..387.37 rows=2 width=40) (actual time=0.714..0.715 rows=0 loops=1)
  Join Filter: (seats.id = tickets.seat_id)
  InitPlan 1
    ->  Index Scan using sessions_pkey on sessions  (cost=0.29..8.30 rows=1 width=4) (actual time=0.008..0.008 rows=1 loops=1)
          Index Cond: (id = 2)
  ->  Seq Scan on seats  (cost=0.00..180.00 rows=2 width=12) (actual time=0.714..0.714 rows=0 loops=1)
        Filter: (hall_id = (InitPlan 1).col1)
        Rows Removed by Filter: 10000
  ->  Materialize  (cost=0.00..199.01 rows=2 width=8) (never executed)
        ->  Seq Scan on tickets  (cost=0.00..199.00 rows=2 width=8) (never executed)
              Filter: (session_id = 4)
Planning Time: 0.268 ms
Execution Time: 0.734 ms


-- 5. Схема зала с оптимизацией
-- Индекс на Seats.hall_id:
CREATE INDEX idx_seats_hall_id ON Seats (hall_id);
-- Создание составного индекса по столбцам seat_id и session_id:
CREATE INDEX idx_tickets_seat_id_session_id ON Tickets (seat_id, session_id);

QUERY PLAN
Nested Loop Left Join  (cost=16.90..30.89 rows=2 width=40) (actual time=0.019..0.020 rows=0 loops=1)
  Join Filter: (seats.id = tickets.seat_id)
  InitPlan 1
    ->  Index Scan using sessions_pkey on sessions  (cost=0.29..8.30 rows=1 width=4) (actual time=0.008..0.009 rows=1 loops=1)
          Index Cond: (id = 2)
  ->  Bitmap Heap Scan on seats  (cost=4.30..11.18 rows=2 width=12) (actual time=0.019..0.019 rows=0 loops=1)
        Recheck Cond: (hall_id = (InitPlan 1).col1)
        ->  Bitmap Index Scan on idx_seats_hall_id  (cost=0.00..4.30 rows=2 width=0) (actual time=0.016..0.016 rows=0 loops=1)
              Index Cond: (hall_id = (InitPlan 1).col1)
  ->  Materialize  (cost=4.30..11.35 rows=2 width=8) (never executed)
        ->  Bitmap Heap Scan on tickets  (cost=4.30..11.34 rows=2 width=8) (never executed)
              Recheck Cond: (session_id = 4)
              ->  Bitmap Index Scan on idx_tickets_session_id  (cost=0.00..4.30 rows=2 width=0) (never executed)
                    Index Cond: (session_id = 4)
Planning Time: 0.534 ms
Execution Time: 0.045 ms

/**
    1. Без индекса:
        - Общая стоимость (cost): 8.30..387.37.
        - Фактическое время выполнения: 0.714 ms.
        - Детали плана:
            * Для таблиц seats и tickets используются последовательные сканирования (Seq Scan), что приводит к обработке
            большого объема данных, даже если часть из них не подходит по условиям.
    2. С индексом:
        - Общая стоимость (cost): 16.90..30.89.
        - Фактическое время выполнения:  0.019 ms.
        - Детали плана:
            * Используется индекс для сканирования таблиц seats и tickets (Bitmap Index Scan), что значительно сокращает
            объем данных, которые нужно обработать.
    3. Итог
    Использование индексов значительно улучшает производительность за счет:
        * Сокращения количества строк, которые требуется обработать.
        * Ускорения поиска данных с использованием индексов (Bitmap Index Scan) вместо последовательного сканирования
        (Seq Scan)
 */
-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################

-- 6. Диапазон цен на билет
EXPLAIN ANALYZE
SELECT MIN(price) AS min_price, MAX(price) AS max_price
FROM Tickets
WHERE session_id = 99;

QUERY PLAN
Aggregate  (cost=199.01..199.02 rows=1 width=64) (actual time=0.503..0.503 rows=1 loops=1)
  ->  Seq Scan on tickets  (cost=0.00..199.00 rows=2 width=5) (actual time=0.500..0.500 rows=0 loops=1)
        Filter: (session_id = 99)
        Rows Removed by Filter: 10000
Planning Time: 0.121 ms
Execution Time: 0.520 ms

-- 6. Диапазон цен на билет оптимизация
--  Индекс на session_id
CREATE INDEX idx_session_id ON Tickets(session_id);
-- Индекс для агрегатных функций
CREATE INDEX idx_session_price ON Tickets(session_id, price);

QUERY PLAN
Aggregate  (cost=4.33..4.34 rows=1 width=64) (actual time=0.053..0.054 rows=1 loops=1)
  ->  Index Only Scan using idx_session_price on tickets  (cost=0.29..4.32 rows=2 width=5) (actual time=0.051..0.051 rows=0 loops=1)
        Index Cond: (session_id = 99)
        Heap Fetches: 0
Planning Time: 7.602 ms
Execution Time: 0.077 ms

/**
    1. Без индекса:
        - Общая стоимость (cost): 199.01..199.02.
        - Фактическое время выполнения: 0.520 ms
        - Детали плана:
            * Полное последовательное сканирование таблицы (Seq Scan), что означает, что все строки в таблице (10,000)
            проверяются на наличие соответствия условию session_id = 99.
    2. С индексом:
        - Общая стоимость (cost): 4.33..4.34.
        - Фактическое время выполнения:  0.077 ms.
        - Детали плана:
            * Вместо полного сканирования используется Index Only Scan (индексное сканирование).
            Индекс idx_session_price используется для поиска строк с session_id = 99, что позволяет избежать последовательного сканирования всей таблицы..
    3. Итог
    Использование индексов значительно улучшает производительность:
        * Используется Index Only Scan, что значительно снижает стоимость выполнения запроса (4.32).
        * Время выполнения сокращается до 0.077 мс — почти в 7 раз быстрее.
        * Индекс позволяет эффективно искать строки с нужным session_id, без необходимости сканировать всю таблицу, и
        запрос выполняется непосредственно через индекс без дополнительных обращений к данным в таблице.
 */
-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################

-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
SELECT nspname || '.' || relname                     AS name,
       pg_size_pretty(pg_total_relation_size(C.oid)) AS totalsize,
       pg_size_pretty(pg_relation_size(C.oid))       AS relsize
FROM pg_class C
         LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname = 'public'
  AND C.relkind IN ('r', 'i')
ORDER BY pg_total_relation_size(C.oid) DESC
    LIMIT 15;

-- Result
-- name                                 totalsize   relsize
public.tickets,                         2112 kB,    592 kB
public.sessions,                        1376 kB,    592 kB
public.movies,                          1272 kB,    752 kB
public.ticketsales,                     1200 kB,    512 kB
public.seats,                           920 kB,     440 kB
public.halls,                           792 kB,     512 kB
public.idx_session_price,               328 kB,     328 kB
public.idx_tickets_seat_id_session_id,  240 kB,     240 kB
public.seats_pkey,                      240 kB,     240 kB
public.halls_pkey,                      240 kB,     240 kB
public.tickets_pkey,                    240 kB,     240 kB
public.sessions_pkey,                   240 kB,     240 kB
public.ticketsales_pkey,                240 kB,     240 kB
public.movies_pkey,                     240 kB,     240 kB
public.idx_movies_id,                   240 kB,     240 kB


-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################
-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов
SELECT indexrelname AS index_name,
       idx_scan     AS scan_count
FROM pg_catalog.pg_stat_user_indexes
WHERE schemaname = 'public'
ORDER BY idx_scan DESC
    LIMIT 5;

-- Result
-- index_name       scan_count
halls_pkey,         20000
movies_pkey,        10086
sessions_pkey,      10015
seats_pkey,         10006
tickets_pkey,       10004