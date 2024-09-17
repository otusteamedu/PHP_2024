--cinema_shows hall_1
TRUNCATE "cinema_shows" RESTART IDENTITY CASCADE;
INSERT INTO "cinema_shows" ("hall_id", "film_id", "date", "start", "end") 
    VALUES ((SELECT id FROM halls WHERE name = 'Зал 1'), (SELECT id FROM films WHERE name = 'Бременские музыканты'), CURRENT_DATE, '9:00', '11:00'),
            ((SELECT id FROM halls WHERE name = 'Зал 1'), (SELECT id FROM films WHERE name = 'Кунг-фу Панда 4'), CURRENT_DATE, '11:00', '13:00');

--cinema_show_seat
TRUNCATE "cinema_show_seat" RESTART IDENTITY CASCADE;
DO $$
DECLARE rseats RECORD;
BEGIN FOR rseats IN
    SELECT * FROM seats where hall_id = 1
    LOOP
        INSERT INTO cinema_show_seat (seat_id, price, cinema_show_id) VALUES (rseats.id, (CASE rseats.id % 2 WHEN 0 THEN 500 ELSE 700 END), 1);
        INSERT INTO cinema_show_seat (seat_id, price, cinema_show_id) VALUES (rseats.id, (CASE rseats.id % 2 WHEN 0 THEN 400 ELSE 600 END), 2);
 END LOOP;
END; $$

---orders
TRUNCATE "orders" RESTART IDENTITY CASCADE;
DO $$
BEGIN
    FOR r in 1..7000 LOOP
        INSERT INTO orders(date_created, user_id) VALUES (date_trunc('second', 
            (CURRENT_DATE - 1)::timestamp +  round(random()*1000) * '1 second'::interval
        ), 1);
    END LOOP;
END;
$$;

--tickets
TRUNCATE "tickets" RESTART IDENTITY CASCADE;
DO $$
DECLARE temprow RECORD;
BEGIN
    FOR temprow IN
        SELECT * FROM cinema_show_seat LIMIT 7000
    LOOP
        INSERT INTO tickets (cinema_show_seat_id, order_id, price) VALUES
            (temprow.id, temprow.id, temprow.price);
    END LOOP;
END $$;