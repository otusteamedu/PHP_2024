-- Cleanup
DROP FUNCTION IF EXISTS random_string(INT);
DROP FUNCTION IF EXISTS date_from_now(INT);
DROP FUNCTION IF EXISTS random_number_between(BIGINT, BIGINT);
DROP FUNCTION IF EXISTS generate_movies(INT);
DROP FUNCTION IF EXISTS generate_sessions(INT);
DROP FUNCTION IF EXISTS generate_sales(INT);
DROP FUNCTION IF EXISTS random_sessions_id();
DROP FUNCTION IF EXISTS random_movies_id();
DROP FUNCTION IF EXISTS random_hall_seats_id_by_hall_id(INT);

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

-- Create "generate_movies" function
CREATE OR REPLACE FUNCTION generate_movies(moviesCount INT) RETURNS VOID LANGUAGE 'plpgsql' AS $$ BEGIN
    BEGIN
        FOR i IN 1..moviesCount LOOP
                INSERT INTO movies
                    (title)
                VALUES
                    (random_string(random_number_between(10, 15)))
                ;
            END LOOP;
    END;
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
                    random_movies_id(),
                    random_number_between(1, 3),
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
            sessionId := random_sessions_id();
            sessionHallId := (SELECT hall_id FROM sessions WHERE id = sessionId);
            sessionHallSeatId := random_hall_seats_id_by_hall_id(sessionHallId);
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

-- Create "random_sessions_id" function
CREATE OR REPLACE FUNCTION random_sessions_id() RETURNS TABLE(id BIGINT) LANGUAGE 'plpgsql' AS $$ BEGIN
    RETURN QUERY
        SELECT
            sessions."id"
        FROM
            sessions
        WHERE
            sessions."id" >= (SELECT random() * (max(sessions."id") - min(sessions."id")) + min(sessions."id") FROM sessions)
        ORDER BY
            sessions."id"
        LIMIT
            1;
END $$;

-- Create "random_movies_id" function
CREATE OR REPLACE FUNCTION random_movies_id() RETURNS TABLE(id BIGINT) LANGUAGE 'plpgsql' AS $$ BEGIN
    RETURN QUERY
        SELECT
            movies."id"
        FROM
            movies
        WHERE
            movies."id" >= (SELECT random() * (max(movies."id") - min(movies."id")) + min(movies."id") FROM movies)
        ORDER BY
            movies."id"
        LIMIT
            1;
END $$;

-- Create "random_hall_seats_id_by_hall_id" function
CREATE OR REPLACE FUNCTION random_hall_seats_id_by_hall_id(hallId INT) RETURNS TABLE(id BIGINT) LANGUAGE 'plpgsql' AS $$ BEGIN
    RETURN QUERY
        SELECT
            hall_seats."id"
        FROM
            hall_seats
        WHERE
            hall_seats."id" >= (SELECT random() * (max(hall_seats."id") - min(hall_seats."id")) + min(hall_seats."id") FROM hall_seats WHERE hall_seats.hall_id = hallId)
        ORDER BY
            hall_seats."id"
        LIMIT
            1;
END $$;
