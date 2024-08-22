DROP FUNCTION IF EXISTS generate_tickets(INT);
CREATE OR REPLACE FUNCTION generate_tickets(max_showtimes INT) RETURNS VOID AS $$
DECLARE
    start_time TIMESTAMP;
    end_time TIMESTAMP;
    showtime_count INT := 0;
    showtime_id INT;
    showtime_price_factor NUMERIC(10, 2);

    film_id INT;
    film_price NUMERIC(10, 2);

    screen_identificator INT;
    screen_price_factor NUMERIC(10, 2);

    seat_id INT;
    seat_price_factor NUMERIC(10, 2);

    cur_date DATE := CURRENT_DATE - INTERVAL '30 days';
    ticket_price NUMERIC(10, 2);
    ticket_amount INT := 0;

    purchase_id INT;
BEGIN
    DELETE FROM ticket WHERE id > 0;
    DELETE FROM purchase WHERE id > 0;
    DELETE FROM showtime WHERE id > 0;

    WHILE showtime_count < max_showtimes LOOP
        FOR screen_identificator, screen_price_factor IN (SELECT screen.id, screen_type.price_factor FROM screen JOIN screen_type ON screen.type = screen_type.id) LOOP
            FOR film_id, film_price IN (SELECT id, price FROM film) LOOP
                FOR hour_offset IN 0..7 LOOP
                    start_time := cur_date + INTERVAL '10 hours' + INTERVAL '2 hours' * hour_offset;
                    end_time := start_time + (SELECT duration FROM film WHERE id = film_id) * INTERVAL '1 minute';

                    CASE
                        WHEN hour_offset BETWEEN 1 AND 2 THEN showtime_price_factor := 0.9;
                        WHEN hour_offset BETWEEN 5 AND 6 THEN showtime_price_factor := 1.2;
                        WHEN hour_offset = 7 THEN showtime_price_factor := 0.7;
                        ELSE showtime_price_factor := 1.0;
                    END CASE;

                    INSERT INTO showtime ("screen_id", "film_id", "start", "end", "price_factor")
                    VALUES (screen_identificator, film_id, start_time, end_time, showtime_price_factor)
                    RETURNING id INTO showtime_id;

                    FOR seat_id, seat_price_factor IN (
                        SELECT s.id, st.price_factor FROM seat s JOIN seat_type st ON s.seat_type = st.id WHERE s.screen_id = screen_identificator) LOOP

                        IF random() * 10 > 7 THEN
                            CONTINUE;
                        END IF;

                        IF (ticket_amount <= 0) THEN
                            ticket_amount := (random() * 10 + 1)::INT;
                            INSERT INTO purchase (purchase_date, price, bonuses, customer_id, employer_id)
                            VALUES (start_time - INTERVAL '1 day', 0, 0, NULL, NULL)
                            RETURNING id INTO purchase_id;
                        END IF;

                        ticket_price := ROUND(film_price * showtime_price_factor * screen_price_factor * seat_price_factor, 2);

                        INSERT INTO ticket ("purchase_id", "showtime_id", "seat_id", "price")
                        VALUES (purchase_id, showtime_id, seat_id, ticket_price);

                        UPDATE purchase SET price = price + ticket_price WHERE id = purchase_id;

                        ticket_amount := ticket_amount - 1;
                    END LOOP;
                    showtime_count := showtime_count + 1;
                    EXIT WHEN showtime_count >= max_showtimes;
                END LOOP;
                EXIT WHEN showtime_count >= max_showtimes;
            END LOOP;
            EXIT WHEN showtime_count >= max_showtimes;
        END LOOP;

        cur_date := cur_date + INTERVAL '1 day';
    END LOOP;

    RETURN;
END $$ LANGUAGE plpgsql;

SELECT generate_tickets(1000);
