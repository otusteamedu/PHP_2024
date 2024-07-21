CREATE OR REPLACE FUNCTION populate_data(num_records INT) RETURNS INT AS
$$
DECLARE
i          INT;
    hall_id    INT;
    row_num    INT;
    seat_num   INT;
    session_id INT;
    seat_id    INT;
    email      TEXT;
BEGIN
FOR i IN 1..num_records / 10
        LOOP
            INSERT INTO cinemas (name, address)
            VALUES ('Cinema ' || i, 'Address ' || i);
END LOOP;

FOR i IN 1..num_records / 5
        LOOP
            INSERT INTO halls (cinema_id, name)
            VALUES ((SELECT id FROM cinemas ORDER BY random() LIMIT 1), 'Hall ' || i);
END LOOP;

FOR i IN 1..num_records
        LOOP
            hall_id := (SELECT id FROM halls ORDER BY random() LIMIT 1);
            row_num := floor(random() * 10 + 1)::int;
            seat_num := floor(random() * 20 + 1)::int;

            LOOP
BEGIN
INSERT INTO seats (hall_id, row, number, markup)
VALUES (hall_id, row_num, seat_num, (ARRAY [10, 20, 30, 50])[floor(random() * 4 + 1)]);
EXIT;
EXCEPTION
                    WHEN unique_violation THEN
                        row_num := floor(random() * 10 + 1)::int;
                        seat_num := floor(random() * 20 + 1)::int;
END;
END LOOP;
END LOOP;

FOR i IN 1..num_records
        LOOP
            email := 'customer' || i || '@example.com';

            LOOP
BEGIN
INSERT INTO customers (name, email)
VALUES ('Customer ' || i, email);
EXIT;
EXCEPTION
                    WHEN unique_violation THEN
                        email := 'customer' || i || '_' || floor(random() * 1000) || '@example.com';
END;
END LOOP;
END LOOP;

INSERT INTO genres (name)
VALUES ('Action'),
       ('Comedy'),
       ('Drama'),
       ('Horror'),
       ('Sci-Fi')
    ON CONFLICT DO NOTHING;

FOR i IN 1..num_records / 10
        LOOP
            INSERT INTO movies (title, duration, rating, genre_id, release_date, description)
            VALUES ('Movie ' || i,
                    floor(random() * 120 + 60)::int,
                    'Rating ' || floor(random() * 10 + 1),
                    (SELECT id FROM genres ORDER BY random() LIMIT 1),
                    CURRENT_DATE - (floor(random() * 1000) * INTERVAL '1 day'),
                    'Description of movie ' || i);
END LOOP;

FOR i IN 1..num_records
        LOOP
            INSERT INTO sessions (hall_id, movie_id, start_time, price)
            VALUES ((SELECT id FROM halls ORDER BY random() LIMIT 1),
                    (SELECT id FROM movies ORDER BY random() LIMIT 1),
                    CURRENT_DATE + (floor(random() * 1000) * INTERVAL '1 hour'),
                    round((random() * 20 + 5)::numeric, 2));
END LOOP;

FOR i IN 1..num_records
        LOOP
            session_id := (SELECT id FROM sessions ORDER BY random() LIMIT 1);
            seat_id := (SELECT id FROM seats ORDER BY random() LIMIT 1);

            LOOP
BEGIN
INSERT INTO tickets (session_id, seat_id, customer_id, purchased_at)
VALUES (session_id,
        seat_id,
        (SELECT id FROM customers ORDER BY random() LIMIT 1),
            CURRENT_DATE - (floor(random() * 30) * INTERVAL '1 day'));
EXIT;
EXCEPTION
                    WHEN unique_violation THEN
                        session_id := (SELECT id FROM sessions ORDER BY random() LIMIT 1);
                        seat_id := (SELECT id FROM seats ORDER BY random() LIMIT 1);
END;
END LOOP;
END LOOP;

RETURN num_records;
END
$$ LANGUAGE plpgsql;
