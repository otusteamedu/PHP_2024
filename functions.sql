create function insert_films(count_films integer) returns void
    language plpgsql
as
$$
BEGIN
    FOR film_id IN 1..count_films
        LOOP
            INSERT INTO films (id, date_begin, date_end, name)
            VALUES (film_id, CURRENT_DATE - random() * (interval '7 days'), get_random_date(), get_random_string(15));
        END LOOP;
END
$$;

alter function insert_films(integer) owner to postgres;

create function insert_hall_row_seats(hall_row integer, seats_number integer) returns void
    language plpgsql
as
$$
DECLARE
    counter          int := 1;
BEGIN
    FOR current_seat IN 1..seats_number
        LOOP
            INSERT INTO hall_row_seats (id, hall_row_id, number) VALUES (counter, hall_row, current_seat);
            counter := counter + 1;
        END LOOP;
END
$$;

alter function insert_hall_row_seats(integer, integer) owner to postgres;

create function insert_hall_rows(hall integer, rows_number integer, capacity integer) returns void
    language plpgsql
as
$$
DECLARE
    counter          int := 1;
BEGIN
    FOR current_row IN 1..rows_number
        LOOP
            INSERT INTO hall_rows (id, hall_id, number, capacity) VALUES (counter, hall, current_row, capacity);
            counter := counter + 1;
        END LOOP;
END
$$;

alter function insert_hall_rows(integer, integer, integer) owner to postgres;

create function insert_halls(count_halls integer) returns void
    language plpgsql
as
$$
BEGIN
    FOR hall_id IN 1..count_halls
        LOOP
            INSERT INTO halls (id, name)
            VALUES (hall_id, get_random_string(10));
        END LOOP;
END
$$;

alter function insert_halls(integer) owner to postgres;

create function insert_sessions(count_sessions integer) returns void
    language plpgsql
as
$$
DECLARE
    count_movies     int := (SELECT max(id) FROM films);
    counter          int := 1;
    film             int;
    price            int;
    begin_timestamp  timestamp;
    end_timestamp    timestamp;
BEGIN
    WHILE counter < count_sessions
        LOOP
            film := get_random_int(1, count_movies);
            price := get_random_int(500, 900);
            begin_timestamp := CURRENT_TIMESTAMP - random() * (interval '7 days');
            end_timestamp := get_random_date();

            INSERT INTO sessions (id, hall_id, film_id, datetime_begin, datetime_end, price)
            VALUES (counter, 1, film, begin_timestamp, end_timestamp, price);

            counter := counter + 1;
        END LOOP;
END;
$$;

alter function insert_sessions(integer) owner to postgres;

create function insert_tickets(count_tickets integer) returns void
    language plpgsql
as
$$
DECLARE
    count_sessions  int := (SELECT max(id) FROM sessions);
    count_rows      int := (SELECT max(id) FROM hall_rows);
    count_seats     int := (SELECT max(id) FROM hall_row_seats);
    count_users     int := (SELECT max(id) FROM users);
    counter         int := 0;
BEGIN
    WHILE counter < count_tickets
        LOOP
            counter := counter + 1;
            INSERT INTO tickets (id, user_id, session_id, row_id, seat_id, price)
            VALUES (counter,
                    get_random_int(1, count_users),
                    get_random_int(1, count_sessions),
                    get_random_int(1, count_rows),
                    get_random_int(1, count_seats),
                    get_random_int(500, 900));
        END LOOP;
END;
$$;

alter function insert_tickets(integer) owner to postgres;

create function insert_users(count_users integer) returns void
    language plpgsql
as
$$
BEGIN
    FOR user_id IN 1..count_users
        LOOP
            INSERT INTO users (id, name, email)
            VALUES (user_id, get_random_string(10), CONCAT(get_random_string(5), '@mail.ru'));
        END LOOP;
END;
$$;

alter function insert_users(integer) owner to postgres;

create function get_random_date() returns date
    language plpgsql
as
$$
BEGIN
    RETURN CURRENT_DATE + random() * (interval '60 days');
END;
$$;

alter function get_random_date() owner to postgres;

create function get_random_int(min_value integer, max_value integer) returns integer
    language plpgsql
as
$$
BEGIN
    RETURN random() * (max_value - min_value) + min_value;
END
$$;

alter function get_random_int(integer, integer) owner to postgres;

create function get_random_string(length integer) returns text
    language plpgsql
as
$$
DECLARE
    chars   text[] := '{0,1,2,3,4,5,6,7,8,9,А,Б,В,Г,Д,Е,Ё,Ж,З,И,Й,К,Л,М,Н,О,П,Р,С,Т,У,Ф,Х,Ц,Ч,Ш,Щ,Ъ,Ы,Ь,Э,Ю,Я,а,б,в,г,д,е,ё,ж,з,и,й,к,л,м,н,о,п,р,с,т,у,ф,х,ц,ч,ш,щ,ъ,ы,ь,э,ю,я}';
    result  text   := '';
    counter int    := 0;
BEGIN
    WHILE counter < length
        LOOP
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
            counter := counter + 1;
        END LOOP;
    RETURN result;
END
$$;

alter function get_random_string(integer) owner to postgres;

