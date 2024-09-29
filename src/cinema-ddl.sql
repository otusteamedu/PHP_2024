-- Cleanup
DROP TABLE IF EXISTS movies CASCADE;
DROP SEQUENCE IF EXISTS movies_id;
DROP TABLE IF EXISTS halls CASCADE;
DROP SEQUENCE IF EXISTS halls_id;
DROP TYPE IF EXISTS hall_seat_type CASCADE;
DROP TABLE IF EXISTS hall_seats CASCADE;
DROP SEQUENCE IF EXISTS hall_seats_id;
DROP TABLE IF EXISTS sessions CASCADE;
DROP SEQUENCE IF EXISTS sessions_id;
DROP TABLE IF EXISTS sales CASCADE;
DROP SEQUENCE IF EXISTS sales_id;

-- Create "movies" table
CREATE SEQUENCE movies_id;

CREATE TABLE movies(
    id BIGINT NOT NULL DEFAULT nextval('movies_id'),
    title VARCHAR(255) NOT NULL,

    PRIMARY KEY(id)
);

-- Create "halls" table
CREATE SEQUENCE halls_id;

CREATE TABLE halls(
    id SMALLINT NOT NULL DEFAULT nextval('halls_id'),
    name VARCHAR(255) NOT NULL,

    PRIMARY KEY(id)
);

-- Create "hall_seats" table
CREATE TYPE hall_seat_type AS ENUM ('regular', 'comfort', 'VIP');

CREATE SEQUENCE hall_seats_id;

CREATE TABLE hall_seats(
    id BIGINT NOT NULL DEFAULT nextval('hall_seats_id'),
    hall_id SMALLINT NOT NULL,
    type hall_seat_type,
    row_number SMALLINT NOT NULL,
    place_number SMALLINT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(hall_id) REFERENCES halls(id),
    UNIQUE(hall_id, row_number, place_number)
);

-- Create "sessions" table
CREATE SEQUENCE sessions_id;

CREATE TABLE sessions(
    id BIGINT NOT NULL DEFAULT nextval('sessions_id'),
    movie_id BIGINT NOT NULL,
    hall_id SMALLINT NOT NULL,
    date_start TIMESTAMP NOT NULL,
    date_end TIMESTAMP NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(movie_id) REFERENCES movies(id),
    FOREIGN KEY(hall_id) REFERENCES halls(id)
);

-- Create "sales" table
CREATE SEQUENCE sales_id;

CREATE TABLE sales(
    id BIGINT NOT NULL DEFAULT nextval('sales_id'),
    session_id BIGINT NOT NULL,
    seat_id BIGINT NOT NULL,
    date TIMESTAMP NOT NULL,
    grand_total DECIMAL(10, 2) NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(session_id) REFERENCES sessions(id),
    FOREIGN KEY(seat_id) REFERENCES hall_seats(id),
    UNIQUE(session_id, seat_id)
);
