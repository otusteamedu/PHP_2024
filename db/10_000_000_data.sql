TRUNCATE "cinema_shows" RESTART IDENTITY CASCADE;
DO $$
DECLARE
    ddate1 timestamp;
    ttime1 timestamp;
    hhalls RECORD;
    hfilms RECORD;
begin
FOR hhalls IN
        SELECT * FROM halls
    LOOP
        FOR hfilms IN
            SELECT * FROM films
            LOOP
                FOR ddate1 IN SELECT ddate FROM generate_series(CURRENT_DATE - 1, CURRENT_DATE, interval '1 day') AS ddate  LOOP
                            FOR ttime1 IN SELECT ttime FROM generate_series('2024-01-01 10:00', '2024-01-01 18:00', '6 hours'::interval) AS ttime LOOP
                                INSERT INTO cinema_shows ("hall_id", "film_id", "date", "start", "end") 
                                VALUES (hhalls.id, hfilms.id, ddate1, ttime1, ttime1 + INTERVAL '6 HOUR');
                            END LOOP;
                        END LOOP;
            END LOOP;
    END LOOP;
END $$;

--cinema_show_seat
TRUNCATE "cinema_show_seat" RESTART IDENTITY CASCADE;
DO $$
DECLARE 
    rseats RECORD;
    hcinema_show RECORD;
BEGIN
    FOR hcinema_show IN
        SELECT * from cinema_shows
        LOOP
            FOR rseats IN
                SELECT * FROM seats
                LOOP
                    INSERT INTO cinema_show_seat (seat_id, price, cinema_show_id) VALUES (rseats.id, (CASE rseats.id % 2 WHEN 0 THEN 500 ELSE 700 END), hcinema_show.id);
            END LOOP;
        END LOOP;
END; $$

---orders
TRUNCATE "orders" RESTART IDENTITY CASCADE;
DO $$
BEGIN
    FOR r in 1..8000000 LOOP
        INSERT INTO orders(date_created, user_id) VALUES (date_trunc('second', 
            (CURRENT_DATE - 2)::timestamp +  round(random()*1000) * '1 second'::interval
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
        SELECT * FROM cinema_show_seat ORDER BY id ASC LIMIT 8000000 
    LOOP
        INSERT INTO tickets (cinema_show_seat_id, order_id, price) VALUES
            (temprow.id, temprow.id, temprow.price);
    END LOOP;
END $$;