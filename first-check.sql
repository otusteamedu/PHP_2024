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

-- 52 307

-- Выбираем уникальные фильмы, которые показываются на сегодня
SELECT DISTINCT m.id    AS movie_id,
                m.title AS movie_title
FROM schedule s
         JOIN
     movie m ON s.movie_id = m.id
WHERE DATE(s.show_time) = CURRENT_DATE
ORDER BY m.title;

-- Первоначальный запрос
/*
Unique  (cost=24.39..24.41 rows=2 width=520)
  ->  Sort  (cost=24.39..24.40 rows=2 width=520)
"        Sort Key: m.title, m.id"
        ->  Hash Join  (cost=12.27..24.38 rows=2 width=520)
              Hash Cond: (m.id = s.movie_id)
              ->  Seq Scan on movie m  (cost=0.00..11.40 rows=140 width=520)
              ->  Hash  (cost=12.24..12.24 rows=2 width=4)
                    ->  Seq Scan on schedule s  (cost=0.00..12.24 rows=2 width=4)
                          Filter: (date(show_time) = (CURRENT_DATE + 6))
*/
-- Предположение добавить индекс на внешний ключ schedule.movie_id (HASH)
    -- CREATE INDEX idx_schedule_movie_id ON schedule USING HASH (movie_id);
    -- Ничего не дало
    -- drop index idx_schedule_movie_id;

-- Добавить индекс на show_time (B-Tree)
    -- CREATE INDEX idx_schedule_show_time ON schedule (show_time);
    -- Ничего не дало
    -- drop index idx_schedule_show_time;

-- Подсчитываем количество билетов проданных за неделю
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
 Aggregate  (cost=159.08..159.09 rows=1 width=8)
  ->  Nested Loop  (cost=0.58..158.99 rows=36 width=0)
        ->  Nested Loop  (cost=0.29..135.70 rows=72 width=4)
              ->  Seq Scan on schedule s  (cost=0.00..15.71 rows=1 width=4)
                    Filter: ((show_time >= (CURRENT_DATE - '6 days'::interval)) AND (show_time <= ((CURRENT_DATE + '1 day'::interval) - '00:00:01'::interval)))
              ->  Index Scan using price_list_schedule_id_seat_id_key on price_list pl  (cost=0.29..119.28 rows=72 width=8)
                    Index Cond: (schedule_id = s.id)
        ->  Index Only Scan using ticket_price_list_id_customer_id_key on ticket t  (cost=0.29..0.31 rows=1 width=4)
              Index Cond: (price_list_id = pl.id)
*/
-- Добавить индекс на show_time (B-Tree)
-- CREATE INDEX idx_schedule_show_time ON schedule (show_time);

-- Результат:
/*
 Aggregate  (cost=151.55..151.56 rows=1 width=8)
  ->  Nested Loop  (cost=0.74..151.46 rows=36 width=0)
        ->  Nested Loop  (cost=0.45..128.18 rows=72 width=4)
              ->  Index Scan using idx_schedule_show_time on schedule s  (cost=0.16..8.18 rows=1 width=4)
                    Index Cond: ((show_time >= (CURRENT_DATE - '6 days'::interval)) AND (show_time <= ((CURRENT_DATE + '1 day'::interval) - '00:00:01'::interval)))
              ->  Index Scan using price_list_schedule_id_seat_id_key on price_list pl  (cost=0.29..119.28 rows=72 width=8)
                    Index Cond: (schedule_id = s.id)
        ->  Index Only Scan using ticket_price_list_id_customer_id_key on ticket t  (cost=0.29..0.31 rows=1 width=4)
              Index Cond: (price_list_id = pl.id)
 */

-- Получили небольшой прирост т.к. Seq Scan заменился на Index Scan
-- drop index idx_schedule_show_time;


-- Формирование афиши на сегодня
SELECT DISTINCT m.title AS "Название фильма"
FROM movie m
         JOIN
     schedule s ON m.id = s.movie_id
WHERE DATE(s.show_time) = CURRENT_DATE
ORDER BY m.title;
/*
 Unique  (cost=23.24..23.25 rows=2 width=516)
  ->  Sort  (cost=23.24..23.25 rows=2 width=516)
        Sort Key: m.title
        ->  Hash Join  (cost=11.11..23.23 rows=2 width=516)
              Hash Cond: (m.id = s.movie_id)
              ->  Seq Scan on movie m  (cost=0.00..11.40 rows=140 width=520)
              ->  Hash  (cost=11.09..11.09 rows=2 width=4)
                    ->  Seq Scan on schedule s  (cost=0.00..11.09 rows=2 width=4)
                          Filter: (date(show_time) = CURRENT_DATE)
 */
-- Добавить индекс на show_time (B-Tree)
-- CREATE INDEX idx_schedule_show_time ON schedule (show_time);
-- Нет результата
-- drop index idx_schedule_show_time;

-- Поиск 3 самых прибыльных фильмов за неделю
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
 Limit  (cost=1389.22..1389.23 rows=3 width=624)
  ->  Sort  (cost=1389.22..1389.57 rows=140 width=624)
        Sort Key: (sum(pl.price)) DESC
        ->  HashAggregate  (cost=1384.96..1387.41 rows=140 width=624)
              Group Key: m.id
              ->  Hash Join  (cost=601.08..1334.83 rows=4011 width=537)
                    Hash Cond: (s.movie_id = m.id)
                    ->  Hash Join  (cost=587.93..1310.83 rows=4011 width=21)
                          Hash Cond: (pl.schedule_id = s.id)
                          ->  Hash Join  (cost=574.54..1286.80 rows=4011 width=21)
                                Hash Cond: (pl.id = t.price_list_id)
                                ->  Seq Scan on price_list pl  (cost=0.00..546.93 rows=33393 width=13)
                                ->  Hash  (cost=524.40..524.40 rows=4011 width=16)
                                      ->  Seq Scan on ticket t  (cost=0.00..524.40 rows=4011 width=16)
                                            Filter: ((purchased_at >= (CURRENT_DATE - '7 days'::interval)) AND (purchased_at < (CURRENT_DATE + '1 day'::interval)))
                          ->  Hash  (cost=7.62..7.62 rows=462 width=8)
                                ->  Seq Scan on schedule s  (cost=0.00..7.62 rows=462 width=8)
                    ->  Hash  (cost=11.40..11.40 rows=140 width=520)
                          ->  Seq Scan on movie m  (cost=0.00..11.40 rows=140 width=520)
*/
-- Добавить индекс ticket.purchased_at
-- CREATE INDEX idx_ticket_purchased_at ON ticket (purchased_at);
-- Результат: Limit  (cost=1161.66..1161.67 rows=3 width=624)
-- Индекс уменьшает сложность запроса, работаем дальше
-- Добавить HASH индексы на внешние ключи
-- CREATE INDEX idx_schedule_movie_id ON schedule USING HASH (movie_id);
-- CREATE INDEX idx_price_list_schedule_id ON price_list USING HASH (schedule_id);
-- CREATE INDEX idx_ticket_price_list_id ON ticket USING HASH (price_list_id);
-- Результат: прироста производительности нет
-- drop index idx_schedule_movie_id;
-- drop index idx_price_list_schedule_id;
-- drop index idx_ticket_price_list_id;


-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
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
 GroupAggregate  (cost=34.73..34.84 rows=2 width=36)
  Group Key: s.row_number
  ->  Sort  (cost=34.73..34.74 rows=2 width=17)
"        Sort Key: s.row_number, s.seat_number"
        ->  Nested Loop Left Join  (cost=1.27..34.72 rows=2 width=17)
              ->  Nested Loop Left Join  (cost=0.99..23.57 rows=2 width=17)
                    ->  Nested Loop  (cost=0.70..18.88 rows=2 width=16)
                          ->  Nested Loop  (cost=0.42..16.51 rows=1 width=12)
                                ->  Index Scan using schedule_pkey on schedule sch  (cost=0.27..8.29 rows=1 width=8)
                                      Index Cond: (id = 10)
                                ->  Index Only Scan using hall_pkey on hall h  (cost=0.15..8.17 rows=1 width=4)
                                      Index Cond: (id = sch.hall_id)
                          ->  Index Scan using seat_hall_id_row_number_seat_number_key on seat s  (cost=0.28..1.65 rows=72 width=16)
                                Index Cond: (hall_id = h.id)
                    ->  Index Scan using price_list_schedule_id_seat_id_key on price_list pl  (cost=0.29..2.34 rows=1 width=17)
                          Index Cond: ((schedule_id = 10) AND (seat_id = s.id))
              ->  Index Scan using ticket_price_list_id_customer_id_key on ticket t  (cost=0.29..5.57 rows=1 width=8)
                    Index Cond: (price_list_id = pl.id)
 */
-- Запрос не сложный, Seq Scan - нет, предположение, что индексы не требуются

-- Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
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

-- По итогам прихожу к выводу, что можно добавить индексы
CREATE INDEX idx_schedule_show_time ON schedule (show_time);
CREATE INDEX idx_ticket_purchased_at ON ticket (purchased_at);
