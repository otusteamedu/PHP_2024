-- 1. Выбор всех фильмов на сегодня
EXPLAIN
SELECT f.title
FROM films f
WHERE CURRENT_DATE BETWEEN f.start_date AND f.end_date;
-- Улучшение
-- CREATE INDEX films_start_date_idx ON films (start_date);
-- CREATE INDEX films_end_date_idx ON films (end_date);

-- UPD: не помогает, т.к. у нас изначально мало записей в данной таблице и добавление индексов, по сути, не влияет на скорость работы


-- 2. Подсчёт проданных билетов за неделю
EXPLAIN
SELECT f.title,
       COUNT(t.*)
FROM films f
         JOIN random_tickets_with_base_prices rtwbp ON f.id = rtwbp.film_id
         JOIN tickets t ON rtwbp.id = t.random_tickets_with_base_prices_id
WHERE t.session_date BETWEEN CURRENT_DATE - INTERVAL '7 DAYS' AND CURRENT_DATE
GROUP BY f.title;
-- Улучшение
-- CREATE INDEX tickets_session_date_idx ON tickets (session_date);

-- 3. Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN
SELECT f.title,
       s.start_time
FROM films f
         JOIN random_tickets_with_base_prices rtwbp ON f.id = rtwbp.film_id
         JOIN sessions s ON rtwbp.session_id = s.id
WHERE CURRENT_DATE BETWEEN f.start_date AND f.end_date
ORDER BY s.start_time;
-- Улучшение
-- CREATE INDEX sessions_start_time_idx ON sessions (start_time);
-- CREATE INDEX films_start_date_idx ON films (start_date);
-- CREATE INDEX films_end_date_idx ON films (end_date);


-- 4. Поиск 3 самых прибыльных фильмов за неделю
EXPLAIN
WITH revenue AS (SELECT f.id                                                                            AS film_id,
                        f.title,
                        SUM(CASE WHEN t.real_price IS NULL THEN rtwbp.base_price ELSE t.real_price END) AS revenue_sum
                 FROM tickets t
                          JOIN random_tickets_with_base_prices rtwbp ON rtwbp.id = t.random_tickets_with_base_prices_id
                          JOIN films f ON f.id = rtwbp.film_id
                 WHERE t.session_date BETWEEN CURRENT_DATE - INTERVAL '7 DAYS' AND CURRENT_DATE
                 GROUP BY f.id, f.title),
     cnt_show_days_and_cost AS (SELECT f.id                                        AS film_id,
                                       CASE
                                           WHEN (CURRENT_DATE - f.start_date) < 7 THEN CURRENT_DATE - f.start_date
                                           ELSE 7 END                              AS cnt_days,
                                       f.rental_cost / (f.end_date - f.start_date) AS cost_per_day
                                FROM films f
                                WHERE CURRENT_DATE - f.start_date > 0
                                  AND CURRENT_DATE - f.end_date < 7)
SELECT r.title,
       (r.revenue_sum - (csdac.cnt_days * csdac.cost_per_day))::DECIMAL(10, 2) AS income
FROM revenue r
         JOIN cnt_show_days_and_cost csdac ON r.film_id = csdac.film_id
ORDER BY income DESC
LIMIT 3;
-- Улучшение
-- CREATE INDEX tickets_session_date_idx ON tickets (session_date);


-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
EXPLAIN
WITH t1 AS (SELECT distinct s.id AS s_id, s.num AS s_num, s.row AS s_row, rtwbp.id AS pwbp_id
            FROM films f
                     JOIN random_tickets_with_base_prices rtwbp ON f.id = rtwbp.film_id
                     JOIN halls h ON h.id = rtwbp.hall_id
                     JOIN seats s ON h.id = s.hall_id
            WHERE rtwbp.hall_id = 10
              AND rtwbp.film_id = 1
              AND rtwbp.session_id = 2)
SELECT f.title       AS Фильм,
       ss.start_time AS Время,
       h.title       AS Зал,
       t1.s_row      AS Ряд,
       STRING_AGG(CASE
                      WHEN t.seat_id IS NULL THEN CONCAT(t1.s_num, ' - free')
                      ELSE CONCAT(t1.s_num, ' - taken')
                      END,
                  ', '
       )             AS Cхема
FROM t1
         JOIN random_tickets_with_base_prices rtwbp ON rtwbp.id = t1.pwbp_id
         JOIN films f ON rtwbp.film_id = f.id
         JOIN sessions ss ON rtwbp.session_id = ss.id
         JOIN halls h ON h.id = rtwbp.hall_id
         LEFT JOIN tickets t
                   ON t.random_tickets_with_base_prices_id = t1.pwbp_id AND t.seat_id = t1.s_id AND
                      t.session_date = '2025-01-01'
GROUP BY f.title, ss.start_time, h.title, t1.s_row;


-- 6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
EXPLAIN
SELECT f.title                        AS Фильм,
       t.session_date                 AS Дата,
       ss.start_time                  AS Время,
       h.title                        AS Зал,
       CASE
           WHEN
               (CASE WHEN min(t.real_price) IS NULL THEN rtwbp.base_price ELSE min(t.real_price) END)
                   >= rtwbp.base_price THEN rtwbp.base_price
           ELSE min(t.real_price) END AS "Минимальная цена",
       CASE
           WHEN
               (CASE WHEN max(t.real_price) IS NULL THEN rtwbp.base_price ELSE max(t.real_price) END)
                   <= rtwbp.base_price THEN rtwbp.base_price
           ELSE max(t.real_price) END AS "Максимальная цена"
FROM films f
         JOIN random_tickets_with_base_prices rtwbp ON f.id = rtwbp.film_id
         JOIN sessions ss ON rtwbp.session_id = ss.id
         JOIN halls h ON h.id = rtwbp.hall_id
         JOIN seats s ON h.id = s.hall_id
         JOIN tickets t ON rtwbp.id = t.random_tickets_with_base_prices_id
WHERE t.session_date = '2025-01-10'
  AND ss.id = 1
  AND f.id = 1
  AND h.id = 1
GROUP BY f.title, t.session_date, ss.start_time, h.title, rtwbp.base_price;

-- Улучшение
-- CREATE INDEX films_title_idx ON films (title);
-- CREATE INDEX sessions_start_time_idx ON sessions (start_time);
-- CREATE INDEX halls_title_idx ON halls (title);