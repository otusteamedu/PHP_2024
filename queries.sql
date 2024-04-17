--  1
SELECT
    DISTINCT f.film
FROM
    films f,
    sessions s
WHERE
    s.film_id = f.id
  AND s.session_at BETWEEN TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
    AND TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 23:59:59'), 'YYYY-MM-DD HH24:MI:SS');


--  2
SELECT
    count(*) AS Количество_проданных_билетов
FROM
    sessions s,
    booking_session_seats b
WHERE
    s.session_at BETWEEN
        TO_TIMESTAMP(concat(current_date - interval '7 days', ' ', '00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
        AND TO_TIMESTAMP(concat(current_date, ' ', '23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
  AND s.hall_id = b.hall_id AND b.is_reserved = true;


-- 3
SELECT
    f.film Фильм, s.hall_id Номер_зала, s.session_at::time Время
FROM
    films f,
    sessions s
WHERE
    s.film_id = f.id
  AND s.session_at BETWEEN TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
    AND TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
ORDER BY
    session_at, hall_id;

EXPLAIN SELECT
    f.film Фильм, s.hall_id Номер_зала, s.session_at::time Время
FROM
    films f,
    sessions s
WHERE
    s.film_id = f.id
  AND s.session_at BETWEEN TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
    AND TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD 23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
ORDER BY
    session_at, hall_id;

-- 4
SELECT
    f.film Фильм,
    SUM(b.price) Выручка
FROM
    sessions s,
    booking_session_seats b,
    films f
WHERE
    s.session_at BETWEEN
        TO_TIMESTAMP(concat(current_date - interval '7 days', ' ', '00:00:00'), 'YYYY-MM-DD HH24:MI:SS')
        AND TO_TIMESTAMP(concat(current_date, ' ', '23:59:59'), 'YYYY-MM-DD HH24:MI:SS')
  AND b.session_id = s.id AND s.film_id = f.id AND b.is_reserved = true
GROUP BY
    f.id
ORDER BY
    Выручка DESC
    LIMIT 3;

-- 5
CREATE EXTENSION IF NOT EXISTS tablefunc;
SELECT
    *
FROM
    crosstab(
            'SELECT
    st.line,st.number, b.is_reserved
FROM
    sessions s,
    halls h,
    seats st,
    booking_session_seats b
WHERE
    s.id = 2 AND s.hall_id = h.id AND st.hall_id = h.id AND b.hall_id = h.id
    AND b.session_id = s.id AND b.seat_id = st.id'
    ) AS ct (line varchar(100), A1 bool ,A2 bool,A3 bool,A4 bool,A5 bool,A6 bool,A7 bool,A8 bool,A9 bool,A10 bool,
             B1 bool,B2 bool,B3 bool,B4 bool,B5 bool,B6 bool,B7 bool,B8 bool,B9 bool,B10 bool,C1 bool,C2 bool,C3 bool,
             C4 bool,C5 bool,C6 bool,C7 bool,C8 bool,C9 bool,C10 bool);

-- 6
SELECT
    min(b.price) Минимальная_цена,
    max(b.price) Максимальная_цена
FROM
    booking_session_seats b
WHERE
    b.session_id = 100 and b.is_reserved = false



-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
SELECT nspname || '.' || relname AS "relation",
       pg_size_pretty(pg_relation_size(C.oid)) AS "size"
FROM pg_class C
         LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname IN ('public')
ORDER BY pg_relation_size(C.oid) DESC
limit 15;

-- самых часто используемых индексов
SELECT
    indexrelname самые_часто_используемые_индексы
FROM
    pg_stat_user_indexes
ORDER BY
    idx_scan DESC
LIMIT
    5;

-- самых редко используемых индексов
SELECT
    indexrelname самые_редко_используемые_индексы
FROM
    pg_stat_user_indexes
ORDER BY
    idx_scan
LIMIT
    5;