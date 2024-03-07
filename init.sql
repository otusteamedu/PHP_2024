DROP TABLE IF EXISTS ticket;
DROP TABLE IF EXISTS session;
DROP TABLE IF EXISTS movie;
DROP TABLE IF EXISTS hall;

CREATE TABLE movie
(
    slug     varchar(255) primary key,
    title    varchar(255) UNIQUE,
    duration smallint NOT NULL CHECK ( duration > 0 )
);

CREATE TABLE hall
(
    nick                    varchar(255) primary key,
    number_of_rows          smallint NOT NULL CHECK ( number_of_rows > 0 ),
    number_of_seats_per_row smallint NOT NULL CHECK ( number_of_seats_per_row > 0 )
);

CREATE TABLE session
(
    id          serial primary key,
    movie       varchar(255) NOT NULL REFERENCES movie (slug),
    hall        varchar(255) NOT NULL REFERENCES hall (nick),
    start_ts    timestamptz  NOT NULL,
    end_ts      timestamptz  NOT NULL,
    ticket_cost int          NOT NULL CHECK ( ticket_cost > 0 )
);

CREATE TABLE ticket
(
    session_id serial REFERENCES session (id) ON DELETE CASCADE,
    row        int NOT NULL CHECK ( row > 0 ),
    seat       int NOT NULL CHECK ( row > 0 ),
    PRIMARY KEY(session_id, row, seat)
);

CREATE OR REPLACE FUNCTION session_compare_durations() RETURNS TRIGGER LANGUAGE plpgsql AS
$$
BEGIN
    IF (SELECT EXTRACT(EPOCH FROM NEW.end_ts::TIMESTAMP - NEW.start_ts::TIMESTAMP) < (SELECT movie.duration from movie where slug = NEW.movie)) THEN
        RAISE EXCEPTION 'Session duration cannot be less then movie duration.';
    END IF;
    RETURN NEW;
END;
$$;

CREATE OR REPLACE FUNCTION session_check_ts_intersection() RETURNS TRIGGER LANGUAGE plpgsql AS
$$
begin
    IF (EXISTS(SELECT id from session
                    WHERE (start_ts < NEW.start_ts AND end_ts > NEW.end_ts)
                       OR (start_ts > NEW.start_ts AND end_ts < NEW.end_ts)
                    )) THEN
        RAISE EXCEPTION 'Session cannot be intersected with another one.';
    END IF;
    RETURN NEW;
end;
$$;


CREATE OR REPLACE TRIGGER session_check_ts_1
    BEFORE INSERT OR UPDATE on session
    FOR EACH ROW
    EXECUTE PROCEDURE session_compare_durations();


CREATE OR REPLACE TRIGGER session_check_ts_2
    BEFORE INSERT OR UPDATE on session
    FOR EACH ROW
    EXECUTE PROCEDURE session_check_ts_intersection();
