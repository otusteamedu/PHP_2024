-- 1.1 Выбор всех фильмов на сегодня без оптимизации
EXPLAIN ANALYZE SELECT *
FROM Movies
WHERE release_date = CURRENT_DATE;

QUERY PLAN
Gather  (cost=1000.00..157504.44 rows=5464 width=42) (actual time=5.671..288.278 rows=5453 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on movies  (cost=0.00..155958.04 rows=2277 width=42) (actual time=5.266..267.411 rows=1818 loops=3)
        Filter: (release_date = CURRENT_DATE)
        Rows Removed by Filter: 3331516
Planning Time: 0.096 ms
JIT:
  Functions: 6
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 0.859 ms (Deform 0.281 ms), Inlining 0.000 ms, Optimization 0.620 ms, Emission 8.952 ms, Total 10.431 ms"
Execution Time: 288.948 ms

-- 1.2 Создание простого индекса на дату релиза
CREATE INDEX idx_release_date ON movies (release_date);

EXPLAIN ANALYZE SELECT *
                FROM Movies
                WHERE release_date = CURRENT_DATE;
-- Результат простого индекса
QUERY PLAN
Bitmap Heap Scan on movies  (cost=62.78..17584.69 rows=5464 width=42) (actual time=1.689..5.863 rows=5453 loops=1)
  Recheck Cond: (release_date = CURRENT_DATE)
  Heap Blocks: exact=5295
  ->  Bitmap Index Scan on release_date_idx  (cost=0.00..61.42 rows=5464 width=0) (actual time=1.139..1.140 rows=5453 loops=1)
        Index Cond: (release_date = CURRENT_DATE)
Planning Time: 0.294 ms
Execution Time: 6.004 ms
/**
    cost:
        - было: 1000.00..157504.44
        - стало: 62.78..17584.69
        - изменения: Индекс позволяет значительным образом сократить стоимость операции доступа к данным (с 157504.44 до 17584.69), что означает более эффективный поиск с меньшими затратами на чтение данных.
    actual time:
        - было: 5.671..288.278
        - стало: 1.689..5.863
        - изменения: Значительное сокращение реального времени выполнения запроса. Время выполнения было уменьшено с 288.278 ms до 5.863 ms.
    execution Time:
        - было: 288.948 ms
        - стало: 6.004 ms
        - изменения: Общее время выполнения запроса сократилось с 288.948 ms до 6.004 ms, что указывает на улучшение производительности в 48 раз.
    workers:
        - было: 2
        - стало: 0
        - изменения: В случае без индекса используется параллельное выполнение запроса с двумя рабочими потоками, что позволяет распределить нагрузку, однако это не приводит к значительному улучшению, так как без индекса запрос требует больших временных затрат на поиск. В случае с индексом параллельное выполнение не требуется, что уменьшает сложность выполнения.
    rows removed by filter:
        - было: 3331516
        - стало: 0
        - изменения: В запросе без индекса было удалено большое количество строк (3331516), что говорит о том, что фильтрация выполнялась по большому объему данных, не имеющих индексации. При использовании индекса отфильтровываются только нужные строки.
    heap blocks:
        - было: не указано
        - стало: exact=5295
        - изменения: В запросе с индексом количество блоков в куче, проверяемых для выполнения запроса, составляет 5295, что подтверждает более эффективный доступ к данным благодаря индексации.
    planning time:
        - было: 0.096 ms
        - стало: 0.294 ms
        - изменения: Время планирования запроса увеличилось, что связано с добавлением индекса и требованием дополнительных шагов для его использования. Однако это увеличение незначительное и компенсируется улучшением общей производительности запроса.
    JIT:
        - было: 6 функций, инлайнинг выключен, оптимизация выключена
        - стало: данные не указаны
        - изменения: В первом плане использования индекса активирован JIT с функциями для оптимизации выполнения запроса. В случае с индексом возможно сокращение или отсутствие необходимости в JIT, так как операции с индексами обычно проще и требуют меньше оптимизаций в реальном времени.
 */
-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################

-- 2.1 Подсчёт проданных билетов за неделю без оптимизации
EXPLAIN ANALYZE SELECT COUNT(*) AS tickets_sold
FROM Tickets
WHERE session_id IN (SELECT id
                     FROM Sessions
                     WHERE start_time >= CURRENT_DATE -
    INTERVAL '7 days'
  AND start_time
    < CURRENT_DATE
    );

QUERY PLAN
Finalize Aggregate  (cost=296682.34..296682.35 rows=1 width=8) (actual time=1345.318..1348.405 rows=1 loops=1)
  ->  Gather  (cost=296682.13..296682.34 rows=2 width=8) (actual time=1344.801..1348.378 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=295682.13..295682.14 rows=1 width=8) (actual time=1328.496..1328.499 rows=1 loops=3)
              ->  Parallel Hash Semi Join  (cost=168365.34..295465.21 rows=86767 width=0) (actual time=491.870..1325.097 rows=63547 loops=3)
                    Hash Cond: (tickets.session_id = sessions.id)
                    ->  Parallel Seq Scan on tickets  (cost=0.00..115197.00 rows=4166700 width=4) (actual time=0.097..197.108 rows=3333333 loops=3)
                    ->  Parallel Hash  (cost=167280.75..167280.75 rows=86767 width=4) (actual time=491.113..491.114 rows=63527 loops=3)
                          Buckets: 262144  Batches: 1  Memory Usage: 9536kB
                          ->  Parallel Seq Scan on sessions  (cost=0.00..167280.75 rows=86767 width=4) (actual time=9.051..465.895 rows=63527 loops=3)
                                Filter: ((start_time < CURRENT_DATE) AND (start_time >= (CURRENT_DATE - '7 days'::interval)))
                                Rows Removed by Filter: 3269806
Planning Time: 0.200 ms
JIT:
  Functions: 41
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.715 ms (Deform 0.470 ms), Inlining 0.000 ms, Optimization 1.237 ms, Emission 25.772 ms, Total 28.724 ms"
Execution Time: 1349.159 ms

-- 2.2 Создание индекса на start_time в таблице Sessions и создание индекса на session_id в таблице Tickets
CREATE INDEX sessions_start_time_idx ON Sessions (start_time);
CREATE INDEX tickets_session_id_idx ON Tickets (session_id);

EXPLAIN ANALYZE SELECT COUNT(*) AS tickets_sold
                FROM Tickets
                WHERE session_id IN (SELECT id
                                     FROM Sessions
                                     WHERE start_time >= CURRENT_DATE -
                    INTERVAL '7 days'
                  AND start_time
                    < CURRENT_DATE
                    );

QUERY PLAN
Finalize Aggregate  (cost=258643.15..258643.16 rows=1 width=8) (actual time=1223.170..1227.587 rows=1 loops=1)
  ->  Gather  (cost=258642.94..258643.15 rows=2 width=8) (actual time=1222.472..1227.570 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=257642.94..257642.95 rows=1 width=8) (actual time=1182.965..1182.968 rows=1 loops=3)
              ->  Parallel Hash Semi Join  (cost=130326.59..257426.02 rows=86766 width=0) (actual time=439.063..1179.925 rows=63547 loops=3)
                    Hash Cond: (tickets.session_id = sessions.id)
                    ->  Parallel Seq Scan on tickets  (cost=0.00..115196.67 rows=4166667 width=4) (actual time=0.034..181.764 rows=3333333 loops=3)
                    ->  Parallel Hash  (cost=129242.01..129242.01 rows=86766 width=4) (actual time=437.337..437.338 rows=63527 loops=3)
                          Buckets: 262144  Batches: 1  Memory Usage: 9568kB
                          ->  Parallel Bitmap Heap Scan on sessions  (cost=2870.88..129242.01 rows=86766 width=4) (actual time=19.316..414.684 rows=63527 loops=3)
                                Recheck Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time < CURRENT_DATE))
                                Rows Removed by Index Recheck: 1467322
                                Heap Blocks: exact=11745 lossy=11081
                                ->  Bitmap Index Scan on sessions_start_time_idx  (cost=0.00..2818.82 rows=208238 width=0) (actual time=38.752..38.752 rows=190582 loops=1)
                                      Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time < CURRENT_DATE))
Planning Time: 6.374 ms
JIT:
  Functions: 47
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 6.777 ms (Deform 0.471 ms), Inlining 0.000 ms, Optimization 1.319 ms, Emission 22.476 ms, Total 30.571 ms"
Execution Time: 1228.556 ms

/**
    Изменения не существенны
 */
-- 2.3 Пробуем вместо подзапроса использовать join, с индексами созданные ранее
EXPLAIN ANALYZE
SELECT COUNT(*) AS tickets_sold
FROM Tickets t
         JOIN Sessions s ON t.session_id = s.id
WHERE s.start_time >= CURRENT_DATE - INTERVAL '7 days'
  AND s.start_time < CURRENT_DATE;

QUERY PLAN
Finalize Aggregate  (cost=224737.91..224737.92 rows=1 width=8) (actual time=530.544..534.868 rows=1 loops=1)
  ->  Gather  (cost=224737.70..224737.91 rows=2 width=8) (actual time=530.130..534.856 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=223737.70..223737.71 rows=1 width=8) (actual time=511.050..511.051 rows=1 loops=3)
              ->  Nested Loop  (cost=2871.32..223520.78 rows=86766 width=0) (actual time=14.736..506.750 rows=63547 loops=3)
                    ->  Parallel Bitmap Heap Scan on sessions s  (cost=2870.88..129242.01 rows=86766 width=4) (actual time=13.401..315.201 rows=63527 loops=3)
                          Recheck Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time < CURRENT_DATE))
                          Rows Removed by Index Recheck: 1467322
                          Heap Blocks: exact=12041 lossy=11368
                          ->  Bitmap Index Scan on sessions_start_time_idx  (cost=0.00..2818.82 rows=208238 width=0) (actual time=25.532..25.533 rows=190582 loops=1)
                                Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time < CURRENT_DATE))
                    ->  Index Only Scan using tickets_session_id_idx on tickets t  (cost=0.43..1.07 rows=2 width=4) (actual time=0.002..0.003 rows=1 loops=190582)
                          Index Cond: (session_id = s.id)
                          Heap Fetches: 18351
Planning Time: 0.225 ms
JIT:
  Functions: 29
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.794 ms (Deform 0.230 ms), Inlining 0.000 ms, Optimization 0.612 ms, Emission 11.025 ms, Total 13.431 ms"
Execution Time: 535.337 ms
/**
    cost:
        - без индекса: 296682.34..296682.35
        - с индексом: 258643.15..258643.16
        - с индексом и JOIN: 224737.91..224737.92
        - изменения: Стоимость запроса значительно снижается при добавлении индекса и использования JOIN.
    actual time:
        - без индекса: 1345.318..1348.405
        - с индексом: 1223.170..1227.587
        - с индексом и JOIN: 530.544..534.868
        - изменения: Время выполнения запроса значительно снижается с использованием индекса (с 1345 ms до 1227 ms) и еще сильнее с использованием JOIN и индекса (с 1345 ms до 535 ms).
    execution Time:
        - без индекса: 1349.159 ms
        - с индексом: 1228.556 ms
        - с индексом и JOIN: 535.337 ms
        - изменения: Время выполнения запроса значительно сокращается с использованием индекса и JOIN.
    workers:
        - без индекса: 2 (Workers Planned: 2, Workers Launched: 2)
        - с индексом: 2 (Workers Planned: 2, Workers Launched: 2)
        - с индексом и JOIN: 2 (Workers Planned: 2, Workers Launched: 2)
        - изменения: Число рабочих процессов одинаково в обоих случаях и не меняется.
    hash cond:
        - без индекса: Используется для соединения по полям `tickets.session_id = sessions.id`
        - с индексом: Ускоряется за счет индекса на столбце `sessions_start_time_idx`
        - с индексом и JOIN: Индексируемое соединение значительно быстрее.
    filter:
        - без индекса: Фильтрация по диапазону дат в таблице `sessions`, удаление большого количества строк.
        - с индексом: Фильтрация по диапазону дат с использованием индекса, но требуется дополнительная проверка строк.
        - с индексом и JOIN: Фильтрация по датам с использованием индекса и JOIN значительно сокращает количество проверок.
    index usage:
        - без индекса: Нет.
        - с индексом: Применяется индекс на поле `start_time` в таблице `sessions`.
        - с индексом и JOIN: Применяются индексы на полях `start_time` и `session_id`, что ускоряет выполнение.
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
Unique  (cost=300037.98..305680.59 rows=41666 width=42) (actual time=834.703..845.328 rows=27304 loops=1)
  ->  Gather Merge  (cost=300037.98..305159.77 rows=41666 width=42) (actual time=834.702..842.629 rows=27304 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Unique  (cost=299037.96..299350.45 rows=20833 width=42) (actual time=818.931..820.201 rows=9101 loops=3)
              ->  Sort  (cost=299037.96..299090.04 rows=20833 width=42) (actual time=818.929..819.211 rows=9114 loops=3)
"                    Sort Key: movies.id, movies.title, movies.duration, movies.genre, movies.release_date"
                    Sort Method: quicksort  Memory: 936kB
                    Worker 0:  Sort Method: quicksort  Memory: 931kB
                    Worker 1:  Sort Method: quicksort  Memory: 996kB
                    ->  Parallel Hash Join  (cost=146707.08..297543.55 rows=20833 width=42) (actual time=338.534..816.674 rows=9114 loops=3)
                          Hash Cond: (movies.id = sessions.movie_id)
                          ->  Parallel Seq Scan on movies  (cost=0.00..135124.67 rows=4166667 width=42) (actual time=0.032..188.879 rows=3333333 loops=3)
                          ->  Parallel Hash  (cost=146446.67..146446.67 rows=20833 width=4) (actual time=338.170..338.171 rows=9114 loops=3)
                                Buckets: 65536  Batches: 1  Memory Usage: 1632kB
                                ->  Parallel Seq Scan on sessions  (cost=0.00..146446.67 rows=20833 width=4) (actual time=8.170..333.330 rows=9114 loops=3)
                                      Filter: (date(start_time) = CURRENT_DATE)
                                      Rows Removed by Filter: 3324219
Planning Time: 0.244 ms
JIT:
  Functions: 40
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.323 ms (Deform 0.736 ms), Inlining 0.000 ms, Optimization 1.429 ms, Emission 22.612 ms, Total 26.364 ms"
Execution Time: 846.904 ms

-- 3.2 Формирование афиши с индексом на DATE(start_time)
CREATE INDEX sessions_start_date_idx ON sessions (DATE(start_time));

QUERY PLAN
Unique  (cost=224028.08..229670.69 rows=41666 width=42) (actual time=571.304..582.178 rows=27304 loops=1)
  ->  Gather Merge  (cost=224028.08..229149.87 rows=41666 width=42) (actual time=571.303..579.393 rows=27304 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Unique  (cost=223028.06..223340.55 rows=20833 width=42) (actual time=555.980..557.351 rows=9101 loops=3)
              ->  Sort  (cost=223028.06..223080.14 rows=20833 width=42) (actual time=555.979..556.288 rows=9114 loops=3)
"                    Sort Key: movies.id, movies.title, movies.duration, movies.genre, movies.release_date"
                    Sort Method: quicksort  Memory: 951kB
                    Worker 0:  Sort Method: quicksort  Memory: 954kB
                    Worker 1:  Sort Method: quicksort  Memory: 957kB
                    ->  Parallel Hash Join  (cost=70697.18..221533.65 rows=20833 width=42) (actual time=53.699..553.555 rows=9114 loops=3)
                          Hash Cond: (movies.id = sessions.movie_id)
                          ->  Parallel Seq Scan on movies  (cost=0.00..135124.67 rows=4166667 width=42) (actual time=0.026..192.982 rows=3333333 loops=3)
                          ->  Parallel Hash  (cost=70436.77..70436.77 rows=20833 width=4) (actual time=53.368..53.370 rows=9114 loops=3)
                                Buckets: 65536  Batches: 1  Memory Usage: 1664kB
                                ->  Parallel Bitmap Heap Scan on sessions  (cost=559.94..70436.77 rows=20833 width=4) (actual time=11.742..50.159 rows=9114 loops=3)
                                      Recheck Cond: (date(start_time) = CURRENT_DATE)
                                      Heap Blocks: exact=10428
                                      ->  Bitmap Index Scan on sessions_start_date_idx  (cost=0.00..547.44 rows=50000 width=0) (actual time=15.741..15.742 rows=27343 loops=1)
                                            Index Cond: (date(start_time) = CURRENT_DATE)
Planning Time: 0.145 ms
JIT:
  Functions: 43
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.845 ms (Deform 0.580 ms), Inlining 0.000 ms, Optimization 1.356 ms, Emission 25.104 ms, Total 28.304 ms"
Execution Time: 583.389 ms

/**
    cost:
        - было: 300037.98..305680.59
        - стало: 224028.08..229670.69
        - изменения: Снижение стоимости выполнения запроса указывает на более эффективное использование индекса для фильтрации данных, что снижает общий уровень затрат на выполнение.
    actual time:
        - было: 834.703..845.328
        - стало: 571.304..582.178
        - изменения: Реальное время выполнения запроса значительно снизилось. Добавление индекса позволило улучшить производительность, особенно на этапах фильтрации и соединения данных.
    execution Time:
        - было: 846.904 ms
        - стало: 583.389 ms
        - изменения: Общее время выполнения запроса уменьшилось с 846.904 ms до 583.389 ms, что подтверждает значительное улучшение производительности (снижение времени выполнения на 31%).
    planning time:
        - было: Использовался последовательный скан для таблицы "sessions" (Parallel Seq Scan), что приводило к высокой стоимости выполнения.
        - стало: Индекс был использован для фильтрации данных в таблице "sessions" с помощью Bitmap Index Scan и Bitmap Heap Scan, что значительно ускоряет выборку.
    workers: Планировалось 2 рабочих процесса, и оба были использованы в обоих запросах.
    sort: Алгоритм сортировки остался одинаковым, но за счет уменьшения общего времени выполнения улучшилась производительность сортировки.
    JIT время: Не произошло существенных изменений в времени JIT, но улучшение в основном связано с более быстрым извлечением данных.
*/
-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################

-- 4.1 Поиск 3 самых прибыльных фильмов за неделю без оптимизации
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
Limit  (cost=904149.38..904149.39 rows=3 width=48) (actual time=6075.695..6184.324 rows=3 loops=1)
  ->  Sort  (cost=904149.38..906969.40 rows=1128009 width=48) (actual time=5886.196..5994.824 rows=3 loops=1)
        Sort Key: (sum(ticketsales.total_amount)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=746994.55..889570.08 rows=1128009 width=48) (actual time=4916.120..5849.104 rows=977547 loops=1)
"              Group Key: movies.id, movies.title"
              ->  Gather Merge  (cost=746994.55..866069.88 rows=940008 width=48) (actual time=4916.088..5404.293 rows=977547 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=745994.52..756569.61 rows=470004 width=48) (actual time=4899.486..5110.141 rows=325849 loops=3)
"                          Group Key: movies.id, movies.title"
                          ->  Sort  (cost=745994.52..747169.53 rows=470004 width=21) (actual time=4899.424..4941.976 rows=383207 loops=3)
"                                Sort Key: movies.id, movies.title"
                                Sort Method: external merge  Disk: 11696kB
                                Worker 0:  Sort Method: external merge  Disk: 12248kB
                                Worker 1:  Sort Method: external merge  Disk: 10968kB
                                ->  Parallel Hash Join  (cost=496380.69..692075.71 rows=470004 width=21) (actual time=4262.408..4814.960 rows=383207 loops=3)
                                      Hash Cond: (movies.id = sessions.movie_id)
                                      ->  Parallel Seq Scan on movies  (cost=0.00..135124.67 rows=4166667 width=16) (actual time=0.528..265.743 rows=3333333 loops=3)
                                      ->  Parallel Hash  (cost=488210.64..488210.64 rows=470004 width=9) (actual time=3309.580..3309.587 rows=383207 loops=3)
                                            Buckets: 262144  Batches: 16  Memory Usage: 5504kB
                                            ->  Parallel Hash Join  (cost=320581.62..488210.64 rows=470004 width=9) (actual time=2638.833..3236.002 rows=383207 loops=3)
                                                  Hash Cond: (sessions.id = tickets.session_id)
                                                  ->  Parallel Seq Scan on sessions  (cost=0.00..115196.67 rows=4166667 width=8) (actual time=0.093..268.868 rows=3333333 loops=3)
                                                  ->  Parallel Hash  (cost=312411.57..312411.57 rows=470004 width=9) (actual time=1925.860..1925.865 rows=383207 loops=3)
                                                        Buckets: 262144  Batches: 16  Memory Usage: 5504kB
                                                        ->  Parallel Hash Join  (cost=144782.56..312411.57 rows=470004 width=9) (actual time=1302.142..1856.695 rows=383207 loops=3)
                                                              Hash Cond: (tickets.id = ticketsales.ticket_id)
                                                              ->  Parallel Seq Scan on tickets  (cost=0.00..115196.67 rows=4166667 width=8) (actual time=0.065..246.217 rows=3333333 loops=3)
                                                              ->  Parallel Hash  (cost=136612.51..136612.51 rows=470004 width=9) (actual time=593.662..593.663 rows=383207 loops=3)
                                                                    Buckets: 262144  Batches: 16  Memory Usage: 5472kB
                                                                    ->  Parallel Seq Scan on ticketsales  (cost=0.00..136612.51 rows=470004 width=9) (actual time=167.813..529.647 rows=383207 loops=3)
                                                                          Filter: (sale_time >= (CURRENT_DATE - '7 days'::interval))
                                                                          Rows Removed by Filter: 2950126
Planning Time: 0.259 ms
JIT:
  Functions: 103
"  Options: Inlining true, Optimization true, Expressions true, Deforming true"
"  Timing: Generation 3.103 ms (Deform 1.201 ms), Inlining 196.170 ms, Optimization 279.427 ms, Emission 217.910 ms, Total 696.609 ms"
Execution Time: 6186.470 ms


-- 4.2 Поиск 3 самых прибыльных фильмов за неделю используем индексы
-- Для таблицы TicketSales:
CREATE INDEX idx_ticket_sales_sale_time ON TicketSales(sale_time);
CREATE INDEX idx_ticket_sales_ticket_id ON TicketSales(ticket_id);

-- Для таблицы Tickets:
CREATE INDEX idx_tickets_session_id ON Tickets(session_id);

-- Для таблицы Sessions:
CREATE INDEX idx_sessions_movie_id ON Sessions(movie_id);

-- Для таблицы Movies:
CREATE INDEX idx_movies_id ON Movies(id);

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
Limit  (cost=852168.39..852168.40 rows=3 width=48) (actual time=6383.887..6490.530 rows=3 loops=1)
  ->  Sort  (cost=852168.39..854988.38 rows=1127996 width=48) (actual time=6142.244..6248.886 rows=3 loops=1)
        Sort Key: (sum(ticketsales.total_amount)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=695015.53..837589.25 rows=1127996 width=48) (actual time=5159.758..6098.830 rows=977547 loops=1)
"              Group Key: movies.id, movies.title"
              ->  Gather Merge  (cost=695015.53..814089.34 rows=939996 width=48) (actual time=5159.704..5641.113 rows=977547 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=694015.50..704590.46 rows=469998 width=48) (actual time=5139.024..5350.237 rows=325849 loops=3)
"                          Group Key: movies.id, movies.title"
                          ->  Sort  (cost=694015.50..695190.50 rows=469998 width=21) (actual time=5138.973..5180.650 rows=383207 loops=3)
"                                Sort Key: movies.id, movies.title"
                                Sort Method: external merge  Disk: 12152kB
                                Worker 0:  Sort Method: external merge  Disk: 11640kB
                                Worker 1:  Sort Method: external merge  Disk: 11120kB
                                ->  Parallel Hash Join  (cost=444402.30..640097.30 rows=469998 width=21) (actual time=4410.778..5035.608 rows=383207 loops=3)
                                      Hash Cond: (movies.id = sessions.movie_id)
                                      ->  Parallel Seq Scan on movies  (cost=0.00..135124.67 rows=4166667 width=16) (actual time=0.078..245.713 rows=3333333 loops=3)
                                      ->  Parallel Hash  (cost=436232.33..436232.33 rows=469998 width=9) (actual time=3302.079..3302.085 rows=383207 loops=3)
                                            Buckets: 262144  Batches: 16  Memory Usage: 5504kB
                                            ->  Parallel Hash Join  (cost=268603.33..436232.33 rows=469998 width=9) (actual time=2655.833..3222.434 rows=383207 loops=3)
                                                  Hash Cond: (sessions.id = tickets.session_id)
                                                  ->  Parallel Seq Scan on sessions  (cost=0.00..115196.67 rows=4166667 width=8) (actual time=0.090..232.818 rows=3333333 loops=3)
                                                  ->  Parallel Hash  (cost=260433.35..260433.35 rows=469998 width=9) (actual time=1881.858..1881.863 rows=383207 loops=3)
                                                        Buckets: 262144  Batches: 16  Memory Usage: 5472kB
                                                        ->  Parallel Hash Join  (cost=92804.35..260433.35 rows=469998 width=9) (actual time=1263.061..1805.191 rows=383207 loops=3)
                                                              Hash Cond: (tickets.id = ticketsales.ticket_id)
                                                              ->  Parallel Seq Scan on tickets  (cost=0.00..115196.67 rows=4166667 width=8) (actual time=0.058..235.799 rows=3333333 loops=3)
                                                              ->  Parallel Hash  (cost=84634.38..84634.38 rows=469998 width=9) (actual time=493.326..493.327 rows=383207 loops=3)
                                                                    Buckets: 262144  Batches: 16  Memory Usage: 5472kB
                                                                    ->  Parallel Bitmap Heap Scan on ticketsales  (cost=12714.41..84634.38 rows=469998 width=9) (actual time=307.000..414.583 rows=383207 loops=3)
                                                                          Recheck Cond: (sale_time >= (CURRENT_DATE - '7 days'::interval))
                                                                          Heap Blocks: exact=47142
                                                                          ->  Bitmap Index Scan on idx_ticket_sales_sale_time  (cost=0.00..12432.41 rows=1127996 width=0) (actual time=121.276..121.276 rows=1149622 loops=1)
                                                                                Index Cond: (sale_time >= (CURRENT_DATE - '7 days'::interval))
Planning Time: 0.752 ms
JIT:
  Functions: 106
"  Options: Inlining true, Optimization true, Expressions true, Deforming true"
"  Timing: Generation 4.648 ms (Deform 1.625 ms), Inlining 271.996 ms, Optimization 309.146 ms, Emission 223.364 ms, Total 809.153 ms"
Execution Time: 6493.817 ms

/**
   Добавление индекса позволило улучшить стоимость запроса и использовать более эффективный способ фильтрации данных через Bitmap Index Scan.
    Однако, это также привело к увеличению времени выполнения,из-за работы с дополнительными индексами и битмапами.
    Индекс не улучшил производительность
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
    WHERE id = 157984
);

QUERY PLAN
Gather  (cost=1008.89..107160.39 rows=2 width=40) (actual time=217.642..220.624 rows=1 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  InitPlan 1
    ->  Index Scan using idx_sessions_session_id_movie_id on sessions  (cost=0.43..8.45 rows=1 width=4) (actual time=7.072..7.081 rows=1 loops=1)
          Index Cond: (id = 2)
  ->  Nested Loop Left Join  (cost=0.43..106151.74 rows=1 width=40) (actual time=152.494..193.881 rows=0 loops=3)
        Join Filter: (seats.id = tickets.seat_id)
        ->  Parallel Seq Scan on seats  (cost=0.00..106139.24 rows=1 width=12) (actual time=150.268..191.654 rows=0 loops=3)
              Filter: (hall_id = (InitPlan 1).col1)
              Rows Removed by Filter: 3333333
        ->  Index Scan using tickets_session_id_idx on tickets  (cost=0.43..12.47 rows=2 width=8) (actual time=6.642..6.642 rows=0 loops=1)
              Index Cond: (session_id = 4)
Planning Time: 0.136 ms
JIT:
  Functions: 42
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.154 ms (Deform 0.984 ms), Inlining 0.000 ms, Optimization 1.174 ms, Emission 28.024 ms, Total 31.352 ms"
Execution Time: 221.301 ms

-- 5. Схема зала с оптимизацией
-- Индекс на Seats.hall_id:
CREATE INDEX idx_seats_hall_id ON Seats (hall_id);
-- Создание составного индекса по столбцам seat_id и session_id:
CREATE INDEX idx_tickets_seat_id_session_id ON Tickets (seat_id, session_id);

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
    WHERE id = 158970
);

QUERY PLAN
Nested Loop Left Join  (cost=9.32..33.46 rows=2 width=40) (actual time=2.522..2.524 rows=1 loops=1)
  Join Filter: (seats.id = tickets.seat_id)
  InitPlan 1
    ->  Index Scan using idx_sessions_session_id_movie_id on sessions  (cost=0.43..8.45 rows=1 width=4) (actual time=1.451..1.453 rows=1 loops=1)
          Index Cond: (id = 157984)
  ->  Index Scan using idx_seats_hall_id on seats  (cost=0.43..12.47 rows=2 width=12) (actual time=2.503..2.504 rows=1 loops=1)
        Index Cond: (hall_id = (InitPlan 1).col1)
  ->  Materialize  (cost=0.43..12.48 rows=2 width=8) (actual time=0.013..0.013 rows=0 loops=1)
        ->  Index Scan using tickets_session_id_idx on tickets  (cost=0.43..12.47 rows=2 width=8) (actual time=0.010..0.010 rows=0 loops=1)
              Index Cond: (session_id = 4)
Planning Time: 0.163 ms
Execution Time: 2.547 ms

/**
     Cost:
        Было: 1008.89..107160.39
        Стало: 9.32..33.46
        Изменения: Снижение стоимости в 100 раз.
     Actual Time:
        Было: 217.642..220.624
        Стало: 2.522..2.524
        Изменения: Время выполнения запроса значительно снизилось с 220.624 мс до 2.524 мс.
     Execution Time:
        Было: 221.301 мс
        Стало: 2.547 мс
        Изменения: Время выполнения запроса сократилось почти в 100 раз (с 221.301 мс до 2.547 мс).
     Workers:
        Было: 2 запланировано, 2 запущено
        Стало: нет
        Изменения: параллельная обработка была не использована,благодаря использованию индекса.
     Planning Time:
        Было: 0.136 мс
        Стало: 0.163 мс
        Изменения: время планирования немного увеличилось, из-за дополнительной работы по построению индекса.
    Использование индекса значительно ускоряет выполнение запроса, уменьшает количество обработанных строк, а также снижает стоимость выполнения.
 */
-- #####################################################################################################################
-- #####################################################################################################################
-- #####################################################################################################################

-- 6. Диапазон цен на билет
EXPLAIN ANALYZE
SELECT MIN(price) AS min_price, MAX(price) AS max_price
FROM Tickets
WHERE session_id = 82723;

QUERY PLAN
Aggregate  (cost=12.48..12.49 rows=1 width=64) (actual time=0.995..0.996 rows=1 loops=1)
  ->  Index Scan using tickets_session_id_idx on tickets  (cost=0.43..12.47 rows=2 width=5) (actual time=0.986..0.987 rows=1 loops=1)
        Index Cond: (session_id = 82723)
Planning Time: 7.394 ms
Execution Time: 1.032 ms

-- 6. Диапазон цен на билет оптимизация
--  Индекс на session_id
CREATE INDEX idx_session_id ON Tickets(session_id);
-- Индекс для агрегатных функций
CREATE INDEX idx_session_price ON Tickets(session_id, price);

EXPLAIN ANALYZE
SELECT MIN(price) AS min_price, MAX(price) AS max_price
FROM Tickets
WHERE session_id = 82723;

QUERY PLAN
Aggregate  (cost=8.48..8.49 rows=1 width=64) (actual time=0.102..0.103 rows=1 loops=1)
  ->  Index Only Scan using idx_session_price on tickets  (cost=0.43..8.47 rows=2 width=5) (actual time=0.095..0.096 rows=1 loops=1)
        Index Cond: (session_id = 82723)
        Heap Fetches: 0
Planning Time: 0.362 ms
Execution Time: 0.121 ms

/**
    cost:
        было: 12.48..12.49
        стало: 8.48..8.49
        изменения: с уменьшением стоимости запроса, использование индекса типа Index Only Scan вместо обычного Index Scan привело к более эффективному выполнению запроса.
    actual time:
        было: 0.995..0.996
        стало: 0.102..0.103
        изменения: Время выполнения запроса значительно сократилось, что указывает на более быстрый доступ к данным благодаря использованию Index Only Scan.
    execution Time:
        было: 1.032 ms
        стало: 0.121 ms
        изменения: Время выполнения запроса значительно уменьшилось, что также подтверждает повышение производительности после внедрения индекса.
    planning time:
        было: 7.394 ms
        стало: 0.362 ms
        изменения: Время планирования запроса значительно сократилось, из-за использования более простого плана с индексом, который требует меньше вычислений.
    С внедрением индекса запрос стал гораздо быстрее
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
-- name                                         totalsize   relsize
public.tickets,                                 1465 MB,    574 MB
public.sessions,                                924 MB,     574 MB
public.ticketsales,                             798 MB,     498 MB
public.movies,                                  797 MB,     730 MB
public.seats,                                   610 MB,     422 MB
public.halls,                                   567 MB,     567 MB
public.idx_session_price,                       301 MB,     301 MB
public.idx_ticket_sales_ticket_id_sale_time,    301 MB,     301 MB
public.idx_sessions_session_id_movie_id,        214 MB,     214 MB
public.idx_tickets_seat_id_session_id,          214 MB,     214 MB
public.idx_seats_hall_id,                       188 MB,     188 MB
public.idx_session_id,                          188 MB,     188 MB
public.tickets_session_id_idx,                  188 MB,     188 MB
public.sessions_start_time_idx,                 69 MB,      69 MB
public.release_date_func_idx,                   67 MB,      67 MB

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
-- index_name                       scan_count
tickets_session_id_idx,             762349
idx_sessions_session_id_movie_id,   13
release_date_func_idx,              8
idx_seats_hall_id,                  7
sessions_start_time_idx,            7








