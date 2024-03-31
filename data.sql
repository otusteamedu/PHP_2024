TRUNCATE tbl_film  RESTART IDENTITY CASCADE;
TRUNCATE tbl_hall  RESTART IDENTITY CASCADE;
TRUNCATE tbl_place  RESTART IDENTITY CASCADE;
TRUNCATE tbl_show  RESTART IDENTITY CASCADE;
TRUNCATE tbl_ticket  RESTART IDENTITY CASCADE;

INSERT INTO tbl_film (title, description, duration)
VALUES (
    'Матрица',
    'Хакер узнает от повстанцев о своей роли в войне против контролирующих.',
     (RANDOM() * 60 + 110)::integer
),(
    'Начало',
    'Вор входит в сны других, чтобы украсть секреты из подсознания.',
     (RANDOM() * 60 + 110)::integer
),(
    'Криминальное чтиво',
    'Убийцы мафии, боксер, гангстер и бандиты из закусочной переплетаются в рассказах.',
     (RANDOM() * 60 + 110)::integer
);


INSERT INTO tbl_hall ("name", "rows", "cols")
VALUES
	 ('Зал 1', (RANDOM() * 6 + 8)::integer, (RANDOM() * 6 + 8)::integer),
	 ('Зал 2', (RANDOM() * 6 + 8)::integer, (RANDOM() * 6 + 8)::integer),
	 ('Зал 3', (RANDOM() * 6 + 8)::integer, (RANDOM() * 6 + 8)::integer),
	 ('Зал 4', (RANDOM() * 6 + 8)::integer, (RANDOM() * 6 + 8)::integer);


INSERT INTO tbl_place (hall_id,row,col)
SELECT
    th.id as hall_id,
    tr.num AS row,
    tc.num AS col
FROM
    tbl_hall th,
    LATERAL (SELECT generate_series(1, th.rows) AS num) AS tr,
    LATERAL (SELECT generate_series(1, th.cols) AS num) AS tc;


INSERT INTO tbl_show (film_id,hall_id,"date",time_start,time_end) VALUES
	 (1,1,'2024-04-01','2024-04-01 09:00:00','2024-04-01 11:16:00'),
	 (2,1,'2024-04-02','2024-04-01 13:30:00','2024-04-01 16:08:00'),
	 (1,1,'2024-04-04','2024-04-01 20:00:00','2024-04-01 22:16:00'),
	 (3,2,'2024-04-03','2024-04-01 17:45:00','2024-04-01 20:59:00');

INSERT INTO tbl_price (show_id,place_id,price)
SELECT
    ts.id as show_id,
    tp.id as place_id,
	((RANDOM() * 40 + 20)::integer)::money AS price
    FROM tbl_show ts
    left join tbl_place tp on tp.hall_id = ts.hall_id;


INSERT INTO tbl_ticket (show_id,place_id,price,paid)
SELECT * FROM (
    SELECT
        ts.id as show_id,
        tp.id as place_id,
        tpr.price as price,
        RANDOM() < 0.5 AS paid
        FROM tbl_show ts
        left join tbl_place tp on tp.hall_id = ts.hall_id
        left join
            tbl_price tpr ON tpr.place_id = tp.id AND tpr.show_id = ts.id
) as tt
WHERE tt.paid = true;

