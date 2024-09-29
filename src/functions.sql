-- Cleanup
DROP FUNCTION IF EXISTS random_string(INT);
DROP FUNCTION IF EXISTS date_from_now(INT);
DROP FUNCTION IF EXISTS random_number_between(BIGINT, BIGINT);
DROP FUNCTION IF EXISTS generate_sessions(INT);
DROP FUNCTION IF EXISTS generate_sales(INT);
DROP FUNCTION IF EXISTS random_element(ANYARRAY);

-- Create "random_string" function
CREATE OR REPLACE FUNCTION random_string(INT) RETURNS TEXT LANGUAGE 'plpgsql' AS $$ BEGIN
    RETURN string_agg(substring('0123456789bcdfghjkmnpqrstvwxyz', round(random() * 30)::integer, 1), '') FROM generate_series(1, $1);
END $$;

-- Create "random_date" function
CREATE OR REPLACE FUNCTION date_from_now(INT) RETURNS TIMESTAMP WITHOUT TIME ZONE LANGUAGE 'plpgsql' AS $$ BEGIN
    RETURN (now() + $1 * interval '1 day')::timestamp;
END $$;

-- Create "random_number_between" function
CREATE OR REPLACE FUNCTION random_number_between(min BIGINT, max BIGINT) RETURNS INT LANGUAGE 'plpgsql' AS $$ BEGIN
    RETURN floor(random() * (max - min + 1) + min);
END $$;

-- Create "generate_sessions" function
CREATE OR REPLACE FUNCTION generate_sessions(sessionCount INT) RETURNS VOID LANGUAGE 'plpgsql' AS $$ BEGIN
    BEGIN
        FOR i IN 0..sessionCount - 1 LOOP
            INSERT INTO sessions
                (
                    movie_id,
                    hall_id,
                    date_start,
                    date_end
                )
            VALUES
                (
                    random_number_between(1, (SELECT COUNT(id) FROM movies)),
                    random_number_between(1, (SELECT COUNT(id) FROM halls)),
                    date_from_now(i % 10),
                    date_from_now(i % 10) + interval '3 hours'
                )
            ;
        END LOOP;
    END;
END $$;

-- Create "generate_sales" function
CREATE OR REPLACE FUNCTION generate_sales(salesCount INT) RETURNS VOID LANGUAGE 'plpgsql' AS $$ BEGIN
    DECLARE
        sessionId BIGINT;
        sessionHallId INT;
        sessionHallSeatId INT;
        sessionHallSeatPrice DECIMAL(10, 2);

    BEGIN
        FOR i IN 1..salesCount LOOP
            sessionId := random_number_between(1, (SELECT COUNT(id) FROM sessions));
            sessionHallId := (SELECT hall_id FROM sessions WHERE id = sessionId);
            sessionHallSeatId := random_element(ARRAY(SELECT id FROM hall_seats WHERE hall_id = sessionHallId))::int;
            sessionHallSeatPrice := (SELECT price FROM hall_seats WHERE id = sessionHallSeatId);

            INSERT INTO sales
                (
                    session_id,
                    seat_id,
                    date,
                    grand_total
                )
            VALUES
                (
                    sessionId,
                    sessionHallSeatId,
                    date_from_now(i % 10),
                    sessionHallSeatPrice
                )
            ON CONFLICT(session_id, seat_id) DO NOTHING;
        END LOOP;
    END;
END $$;

CREATE OR REPLACE FUNCTION random_element(elements anyarray) RETURNS anyelement LANGUAGE 'plpgsql' AS $$ BEGIN
    RETURN elements[trunc(random() * array_length(elements, 1) + 1)];
END $$;
