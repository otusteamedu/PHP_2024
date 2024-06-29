
TRUNCATE tbl_film  RESTART IDENTITY CASCADE;
TRUNCATE tbl_hall  RESTART IDENTITY CASCADE;
TRUNCATE tbl_place  RESTART IDENTITY CASCADE;
TRUNCATE tbl_show  RESTART IDENTITY CASCADE;
TRUNCATE tbl_price  RESTART IDENTITY CASCADE;
TRUNCATE tbl_ticket  RESTART IDENTITY CASCADE;

-- Генерация данных для tbl_hall
INSERT INTO tbl_film (title)
SELECT 'Film ' || generate_series(1, 1000);

-- Генерация данных для tbl_hall
INSERT INTO tbl_hall ("name", "rows", "cols")
SELECT
    'Hall ' || generate_series(1, 4) AS "name",
    (random() * (10 - 5) + 5)::int AS "rows",
    (random() * (10 - 5) + 5)::int AS "cols";


DO $$
DECLARE
    tbl_hall RECORD;
    r INT;
    c INT;
BEGIN
    FOR tbl_hall IN SELECT * FROM tbl_hall LOOP
        FOR r IN 1..tbl_hall.rows LOOP
            FOR c IN 1..tbl_hall.cols LOOP
                INSERT INTO tbl_place (hall_id, "row", col)
                VALUES (tbl_hall.id, r, c);
            END LOOP;
        END LOOP;
    END LOOP;
END $$;


INSERT INTO tbl_show (film_id, hall_id, "date", time_start, time_end)
SELECT
    floor(random() * 1000) + 1 AS film_id,
    h.id AS hall_id,
    to_date(to_char(gs.start_time, 'YYYY-MM-DD'), 'YYYY-MM-DD') AS "date",
    gs.start_time AS time_start,
    gs.start_time + interval '140 minutes' + (interval '100 minutes' * random()) AS time_end
FROM
    tbl_hall h
    CROSS JOIN (
        SELECT start_time
        FROM generate_series('2023-01-28 09:00'::timestamp, '2024-06-30 22:00'::timestamp, '2.5 hours'::interval) AS start_time
    ) AS gs
WHERE EXTRACT(HOUR FROM gs.start_time) BETWEEN 9 AND 22;


INSERT INTO tbl_price (show_id, place_id, price)
SELECT
    s.id AS show_id,
    p.id AS place_id,
    CAST(random() * (20 - 10) + 10 AS numeric(10,2)) AS price
FROM
    tbl_show s
    INNER JOIN tbl_place p ON p.hall_id = s.hall_id;


INSERT INTO tbl_ticket (show_id, place_id, price_id, paid, time_create, time_paid)
SELECT
    tc.show_id,
    tc.place_id,
    tc.price_id,
    tc.paid,
    tc.time_create,
    CASE
        WHEN tc.paid THEN
            tc.time_create + INTERVAL '5 minutes' + (INTERVAL '5 minutes' * random())
        ELSE NULL
    END AS time_paid
FROM (
    SELECT
        p.id AS price_id,
        p.show_id as show_id,
        p.place_id as place_id,
        s.time_end - INTERVAL '6 hours' - INTERVAL '6 hours' * random() AS time_create,
        random() < 0.5 AS paid
    FROM
        tbl_price p
        LEFT JOIN tbl_show s ON s.id = p.show_id
) AS tc;

