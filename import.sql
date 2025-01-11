-- Генерация случайного текста
CREATE OR REPLACE FUNCTION generate_random_text(
    max_length INT DEFAULT 255
)
    RETURNS TEXT AS $$
DECLARE
    text_length INT;
    random_char VARCHAR(1);
    result TEXT;
    char_set TEXT;
    char_set_length INT;
    random_index INT; -- Новая переменная для целочисленного индекса
BEGIN
    text_length := floor(random() * max_length) + 1; -- Случайная длина текста
    result := '';
    char_set := 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    char_set_length := char_length(char_set);

    FOR i IN 1..text_length LOOP
        random_index := floor(random() * char_set_length) + 1; -- Получаем целочисленный индекс
        random_char := substr(char_set, random_index, 1);
        result := result || random_char;
    END LOOP;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

--#################
-- Залы
CREATE OR REPLACE FUNCTION fill_halls_data(
    num_halls INT DEFAULT 10
)
    RETURNS VOID AS $$
DECLARE
    i INT;
BEGIN
    FOR i IN 1..num_halls LOOP
        INSERT INTO halls (name)
        VALUES ('Зал ' || i);
    END LOOP;
END;
$$ LANGUAGE plpgsql;

select fill_halls_data();

--#################
-- Места
CREATE OR REPLACE FUNCTION fill_seats_data(
    num_halls INT DEFAULT 10,
    num_row_per_hall INT DEFAULT 5,
    num_seats_per_row_hall INT DEFAULT 5
)
    RETURNS VOID AS $$
DECLARE
    hall_id_start INTEGER;
    hall_id_end INTEGER;
    i INTEGER;
    j INTEGER;
    k INTEGER;
BEGIN
    hall_id_start := (SELECT hall_id FROM halls ORDER BY hall_id ASC LIMIT 1);
    hall_id_end := (SELECT hall_id FROM halls ORDER BY hall_id DESC LIMIT 1);

    FOR i IN hall_id_start..hall_id_end LOOP
        FOR j IN 1..num_row_per_hall LOOP
            FOR k IN 1..num_seats_per_row_hall LOOP
                INSERT INTO seats (hall_id, seat_row, seat_number)
                VALUES (i, j, k);
            END LOOP;
        END LOOP;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

select fill_seats_data();

--#################
-- Фильмы
CREATE OR REPLACE FUNCTION fill_films_data(
    num_films INT DEFAULT 100
)
    RETURNS VOID AS $$
DECLARE
    i INT;
    title_text text;
    description_text text;
BEGIN

    FOR i IN 1..num_films LOOP
        title_text := generate_random_text(50);
        description_text := generate_random_text(100);

        INSERT INTO films (title, description, duration, start_date, end_date, age_rating, directors)
        VALUES (
               title_text || i,
               description_text,
               floor(random() * 180) + 60,
               NOW() - (random() * 365 * '1 day'::INTERVAL),
               NOW() + (random() * 15 * '1 day'::INTERVAL),
               CASE
                   WHEN random() > 0.5 THEN 0
                   WHEN random() > 0.25 THEN 16
                   ELSE 16
                   END,
               generate_random_text(50)
               );
        END LOOP;
END;
$$ LANGUAGE plpgsql;

select fill_films_data();

--#################
-- Сеансы
CREATE OR REPLACE FUNCTION fill_sessions_data(
    num_sessions INT DEFAULT 10
)
    RETURNS VOID AS $$
DECLARE
    i INT;
    film_id_var INT;
    hall_id_var INT;
    start_time_var timestamp;
    end_time_var timestamp;
    recommended_price_var money;
BEGIN

    FOR i IN 1..num_sessions LOOP
        film_id_var := (SELECT film_id FROM films ORDER BY random() LIMIT 1);
        hall_id_var := (SELECT hall_id FROM halls ORDER BY random() LIMIT 1);
        start_time_var := NOW() - (random() * 1 * '1 day'::INTERVAL) + (random() * 24 * '1 hour'::INTERVAL) + (random() * 60 * '1 minute'::INTERVAL);
        end_time_var := NOW() + (random() * 7 * '1 day'::INTERVAL) + (random() * 24 * '1 hour'::INTERVAL) + (random() * 60 * '1 minute'::INTERVAL);
        recommended_price_var := round((100 + random() * (5000 - 100))::numeric, 3);
        INSERT INTO sessions (film_id, hall_id, start_time, end_time, recommended_price)
        VALUES (film_id_var, hall_id_var, start_time_var, end_time_var, recommended_price_var);
    END LOOP;
END;
$$ LANGUAGE plpgsql;

select fill_sessions_data();

--#################
-- Покупатели
CREATE OR REPLACE FUNCTION fill_customers_data(
    num_customers INT DEFAULT 100
)
    RETURNS VOID AS $$
DECLARE
    i INT;
    customer_name_var text;
    customer_email_var text;
BEGIN
    FOR i IN 1..num_customers LOOP
        customer_name_var := generate_random_text(50);
        customer_email_var := generate_random_text(100);
        INSERT INTO customers (customer_name, email)
        VALUES (customer_name_var, customer_email_var);
    END LOOP;
END;
$$ LANGUAGE plpgsql;

select fill_customers_data();

--#################
-- Билеты
CREATE OR REPLACE FUNCTION fill_tickets_data(
    num_tickets INT DEFAULT 100
)
    RETURNS VOID AS $$
DECLARE
    i INT;
    session_id_var INT;
    customer_id_var INT;
    ticket_price_var money;
    seats_for_hall INT[];
    seat_id_from_list INT;
BEGIN
    -- Билеты
    FOR i IN 1..num_tickets LOOP
        session_id_var := (SELECT session_id FROM sessions ORDER BY random() LIMIT 1);
        customer_id_var:= (SELECT customer_id FROM customers ORDER BY random() LIMIT 1);

        ticket_price_var := round((100 + random() * (5000 - 100))::numeric, 3);
        SELECT array_agg(seat_id) INTO seats_for_hall
        FROM seats
        WHERE hall_id = (SELECT hall_id FROM sessions WHERE session_id = session_id_var);

        IF array_length(seats_for_hall, 1) > 0 THEN
            seat_id_from_list := seats_for_hall[floor(random() * array_length(seats_for_hall, 1)) + 1];
        ELSE
            seat_id_from_list := NULL;
        END IF;

        IF seat_id_from_list IS NOT NULL THEN
            INSERT INTO tickets (session_id, seat_id, price, customer_id)
            VALUES (session_id_var, seat_id_from_list, ticket_price_var, customer_id_var);
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

select fill_tickets_data();