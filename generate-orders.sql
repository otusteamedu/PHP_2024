INSERT INTO orders (id, order_date, screening_date, screening_id, seat_id, sum)
SELECT
    (select id + uid from orders order by id desc limit 1),
    NOW() + (random() * (INTERVAL '1 day' * 30)),
    CURRENT_DATE + (random() * (INTERVAL '1 day' * 30)),
    (SELECT id FROM screenings ORDER BY RANDOM() LIMIT 1),
    (SELECT id FROM hall_seats ORDER BY RANDOM() LIMIT 1),
    floor(100 + (random() * 401))
FROM generate_series(1,10000) AS uid;
