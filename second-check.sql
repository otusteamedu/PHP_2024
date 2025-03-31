-- Получаем общее количество записей в таблицах
WITH table_counts AS (SELECT 'cinema' AS table_name,
                             COUNT(*) AS record_count
                      FROM cinema
                      UNION ALL
                      SELECT 'hall'   AS table_name,
                             COUNT(*) AS record_count
                      FROM hall
                      UNION ALL
                      SELECT 'seat'   AS table_name,
                             COUNT(*) AS record_count
                      FROM seat
                      UNION ALL
                      SELECT 'movie'  AS table_name,
                             COUNT(*) AS record_count
                      FROM movie
                      UNION ALL
                      SELECT 'schedule' AS table_name,
                             COUNT(*)   AS record_count
                      FROM schedule
                      UNION ALL
                      SELECT 'customer' AS table_name,
                             COUNT(*)   AS record_count
                      FROM customer
                      UNION ALL
                      SELECT 'price_list' AS table_name,
                             COUNT(*)     AS record_count
                      FROM price_list
                      UNION ALL
                      SELECT 'ticket' AS table_name,
                             COUNT(*) AS record_count
                      FROM ticket)
SELECT SUM(record_count) AS total_records_count
FROM table_counts;

--  > 7 000 000

-- 1. Выбираем уникальные фильмы, которые показываются на сегодня
-- Удалил из запроса функцию DATE() и поменял фильтрацию
SELECT DISTINCT m.id    AS movie_id,
                m.title AS movie_title
FROM schedule s
         JOIN
     movie m ON s.movie_id = m.id
WHERE s.show_time >= CURRENT_DATE AND s.show_time < CURRENT_DATE + INTERVAL '1 day'
ORDER BY m.title;

/*
До индекса:
Unique  (cost=2061.18..2098.98 rows=5000 width=21)

Добавляем индекс:
CREATE INDEX idx_schedule_show_time ON schedule (show_time);

После индекса:
Unique  (cost=1009.04..1046.84 rows=5000 width=21)
 */

/*
Удаляем индекс по дате и добавляем составной индекс:
CREATE INDEX idx_schedule_date_movie ON schedule (show_time, movie_id);

После индекса:
Unique  (cost=605.78..643.58 rows=5000 width=21)
*/

-- Вариант с дополнительной оптимизацией запроса
EXPLAIN SELECT DISTINCT m.id AS movie_id, m.title AS movie_title
        FROM movie m
                 JOIN (
            SELECT DISTINCT movie_id
            FROM schedule
            WHERE show_time >= CURRENT_DATE AND show_time < CURRENT_DATE + INTERVAL '1 day'
        ) s ON s.movie_id = m.id
        ORDER BY m.title;
/*
До индексов:
Unique  (cost=1793.50..1802.86 rows=1248 width=21)

Добавляем индекс:
CREATE INDEX idx_schedule_show_time ON schedule (show_time);

После индекса:
Unique  (cost=741.35..750.71 rows=1248 width=21)

Удаляем индекс и добавляем составной (покрывающий) индекс:
CREATE INDEX idx_schedule_date_movie ON schedule (show_time, movie_id);

После индекса:
Unique  (cost=338.09..347.45 rows=1248 width=21)
*/

-- Итого: Надо использовать составной индекс - CREATE INDEX idx_schedule_date_movie ON schedule (show_time, movie_id);

-- 2. Подсчитываем количество билетов проданных за неделю
SELECT COUNT(*) AS tickets_sold_last_week
FROM ticket t
         JOIN
     price_list pl ON t.price_list_id = pl.id
         JOIN
     schedule s ON pl.schedule_id = s.id
WHERE
    -- За последние 7 дней включая сегодняшний день
    s.show_time BETWEEN CURRENT_DATE - INTERVAL '6 days' AND CURRENT_DATE + INTERVAL '1 day' - INTERVAL '1 second';

/*
До создания индекса:
Finalize Aggregate  (cost=77985.21..77985.22 rows=1 width=8)
*/

-- Оптимизируем запрос
SELECT COUNT(*) AS tickets_sold_last_week
FROM ticket t
         JOIN price_list pl ON t.price_list_id = pl.id
         JOIN schedule s ON pl.schedule_id = s.id
WHERE s.show_time >= CURRENT_DATE - INTERVAL '6 days'
  AND s.show_time < CURRENT_DATE + INTERVAL '1 day';

/*
До создания индекса:
Finalize Aggregate  (cost=77847.71..77847.72 rows=1 width=8)

Создаем индекс:
CREATE INDEX idx_schedule_show_time ON schedule(show_time);

После создания индекса небольшой прирост:
Finalize Aggregate  (cost=76670.67..76670.68 rows=1 width=8)
*/

-- Итого можно создать индекс - CREATE INDEX idx_schedule_show_time ON schedule(show_time);
-- Но прирост очень небольшой, т.к. запрос аналитический, возможно такие запросы стоит делать не в PostgreSQL
-- А в ClickHouse?

-- 3. Формирование афиши на сегодня
SELECT DISTINCT m.title AS "Название фильма"
FROM movie m
         JOIN
     schedule s ON m.id = s.movie_id
WHERE DATE(s.show_time) = CURRENT_DATE
ORDER BY m.title;

/*
Неоптимизированный запрос без индекса:
Unique  (cost=1474.86..1476.24 rows=275 width=17)
*/

SELECT DISTINCT m.title AS "Название фильма"
FROM movie m
         JOIN schedule s ON m.id = s.movie_id
WHERE s.show_time >= CURRENT_DATE
  AND s.show_time < CURRENT_DATE + INTERVAL '1 day'
ORDER BY m.title;

/*
Оптимизированный запрос без индекса:
Unique  (cost=2061.18..2086.38 rows=5000 width=17)

-- Индекс для условия фильтрации по дате
CREATE INDEX idx_schedule_show_time ON schedule(show_time);
Unique  (cost=1009.04..1034.24 rows=5000 width=17)
*/

EXPLAIN SELECT DISTINCT m.title AS "Название фильма"
        FROM movie m
                 JOIN (
            SELECT DISTINCT movie_id
            FROM schedule
            WHERE show_time >= CURRENT_DATE
              AND show_time < CURRENT_DATE + INTERVAL '1 day'
        ) s ON m.id = s.movie_id
        ORDER BY m.title;

/*
Дополнительная оптимизация через подзапрос
Unique  (cost=741.35..747.59 rows=1248 width=17)

Составной индекс:
CREATE INDEX idx_schedule_date_movie ON schedule(show_time, movie_id);
Unique  (cost=338.09..344.33 rows=1248 width=17)
 */

-- Итого изменение запроса на запрос с подзапросом и составной индекс CREATE INDEX idx_schedule_date_movie ON schedule(show_time, movie_id); - лучшее решение


-- 4. Поиск 3 самых прибыльных фильмов за неделю
SELECT m.title                                    AS "Название фильма",
       SUM(pl.price)                              AS "Общая выручка",
       COUNT(t.id)                                AS "Количество проданных билетов",
       TO_CHAR(MIN(t.purchased_at), 'DD.MM.YYYY') AS "Первая продажа за период",
       TO_CHAR(MAX(t.purchased_at), 'DD.MM.YYYY') AS "Последняя продажа за период"
FROM movie m
         JOIN
     schedule s ON m.id = s.movie_id
         JOIN
     price_list pl ON s.id = pl.schedule_id
         JOIN
     ticket t ON pl.id = t.price_list_id
WHERE t.purchased_at >= CURRENT_DATE - INTERVAL '7 days'
  AND t.purchased_at < CURRENT_DATE + INTERVAL '1 day'
GROUP BY m.id, m.title
ORDER BY "Общая выручка" DESC
LIMIT 3;

/*
Стоимость запроса без индексов:
Limit (cost=114627.65..114627.66 rows=3 width=125)

Запрос с любыми индексами выполняется долго, запрос считается аналитическим, возможно стоит перенести его в
ClickHouse
*/

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
WITH seat_status AS (SELECT s.id                  AS seat_id,
                            s.hall_id,
                            s.row_number,
                            s.seat_number,
                            CASE
                                WHEN t.id IS NOT NULL THEN 'занято'
                                ELSE 'свободно'
                                END               AS status,
                            COALESCE(pl.price, 0) AS price
                     FROM hall h
                              JOIN
                          seat s ON h.id = s.hall_id
                              JOIN
                          schedule sch ON h.id = sch.hall_id
                              LEFT JOIN
                          price_list pl ON s.id = pl.seat_id AND sch.id = pl.schedule_id
                              LEFT JOIN
                          ticket t ON pl.id = t.price_list_id
                     WHERE sch.id = :schedule_id -- Здесь нужно указать ID конкретного сеанса
)
SELECT row_number AS "Ряд",
       STRING_AGG(
               seat_number || ' (' || status || ', ' ||
               CASE
                   WHEN status = 'свободно' AND price > 0 THEN price::text || ' руб.)'
                   WHEN status = 'свободно' AND price = 0 THEN 'нет цены)'
                   ELSE 'продано)'
                   END,
               '  |  '
               ORDER BY seat_number
       )          AS "Места (статус, цена)"
FROM seat_status
GROUP BY row_number
ORDER BY row_number;

/*
Без дополнительных индексов:
GroupAggregate  (cost=725.50..728.62 rows=10 width=36)

Не придумал индексов для улучшения
*/

-- Итого нет индексов для улучшения плана запроса

-- 6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
SELECT
    MIN(pl.price) AS "Минимальная цена",
    MAX(pl.price) AS "Максимальная цена"
FROM
    price_list pl
WHERE
    pl.schedule_id = :schedule_id;  -- Здесь нужно указать ID конкретного сеанса
/*
 Aggregate  (cost=145.27..145.28 rows=1 width=64)
  ->  Index Scan using price_list_schedule_id_seat_id_key on price_list pl  (cost=0.29..144.81 rows=92 width=5)
        Index Cond: (schedule_id = 10)
 */
-- Уже используется индекс от уникального поля

/*
Если запрос выполняется часто, то можно добавить покрывающий индекс:
CREATE INDEX idx_price_list_schedule_price ON price_list(schedule_id, price);

Результат впечатляющий:
Result  (cost=1.00..1.01 rows=1 width=64)
 */

-- Итого можно добавить индекс - CREATE INDEX idx_price_list_schedule_price ON price_list(schedule_id, price);

-- Общее итого:
-- По итогам прихожу к выводу, что можно добавить индексы:
CREATE INDEX idx_price_list_schedule_price ON price_list(schedule_id, price);
CREATE INDEX idx_schedule_date_movie ON schedule(show_time, movie_id);