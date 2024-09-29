-- Cleanup
DROP TABLE IF EXISTS movies CASCADE;
DROP TABLE IF EXISTS halls CASCADE;
DROP TYPE IF EXISTS hall_seat_type CASCADE;
DROP TABLE IF EXISTS hall_seats CASCADE;
DROP TABLE IF EXISTS sessions CASCADE;
DROP TABLE IF EXISTS sales CASCADE;

-- Create "movies" table
CREATE SEQUENCE movies_id_seq;

CREATE TABLE movies(
    id BIGINT NOT NULL DEFAULT nextval('movies_id_seq'),
    title VARCHAR(255) NOT NULL,

    PRIMARY KEY(id)
);

ALTER SEQUENCE movies_id_seq OWNED BY movies.id;

-- Create "halls" table
CREATE SEQUENCE halls_id_seq;

CREATE TABLE halls(
    id SMALLINT NOT NULL DEFAULT nextval('halls_id_seq'),
    name VARCHAR(255) NOT NULL,

    PRIMARY KEY(id)
);

ALTER SEQUENCE halls_id_seq OWNED BY halls.id;

-- Create "hall_seats" table
CREATE TYPE hall_seat_type AS ENUM ('regular', 'comfort', 'VIP');

CREATE SEQUENCE hall_seats_id_seq;

CREATE TABLE hall_seats(
    id BIGINT NOT NULL DEFAULT nextval('hall_seats_id_seq'),
    hall_id SMALLINT NOT NULL,
    type hall_seat_type,
    row_number SMALLINT NOT NULL,
    place_number SMALLINT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(hall_id) REFERENCES halls(id),
    UNIQUE(hall_id, row_number, place_number)
);

ALTER SEQUENCE hall_seats_id_seq OWNED BY hall_seats.id;

-- Create "sessions" table
CREATE SEQUENCE sessions_id_seq;

CREATE TABLE sessions(
    id BIGINT NOT NULL DEFAULT nextval('sessions_id_seq'),
    movie_id BIGINT NOT NULL,
    hall_id SMALLINT NOT NULL,
    date_start TIMESTAMP NOT NULL,
    date_end TIMESTAMP NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(movie_id) REFERENCES movies(id),
    FOREIGN KEY(hall_id) REFERENCES halls(id)
);

ALTER SEQUENCE sessions_id_seq OWNED BY sessions.id;

-- Create "sales" table
CREATE SEQUENCE sales_id_seq;

CREATE TABLE sales(
    id BIGINT NOT NULL DEFAULT nextval('sales_id_seq'),
    session_id BIGINT NOT NULL,
    seat_id BIGINT NOT NULL,
    date TIMESTAMP NOT NULL,
    grand_total DECIMAL(10, 2) NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(session_id) REFERENCES sessions(id),
    FOREIGN KEY(seat_id) REFERENCES hall_seats(id),
    UNIQUE(session_id, seat_id)
);

ALTER SEQUENCE sales_id_seq OWNED BY sales.id;
