DROP DATABASE IF EXISTS cinema_db;

CREATE DATABASE cinema_db WITH ENCODING 'UTF8';

\c  cinema_db

CREATE TABLE IF NOT EXISTS halls
(
    id    SERIAL PRIMARY KEY,
    title VARCHAR(45) NOT NULL
);

CREATE TABLE IF NOT EXISTS seats
(
    id      SERIAL PRIMARY KEY,
    num     INT NOT NULL,
    row     INT NOT NULL,
    hall_id INT NOT NULL,
    UNIQUE (num, row, hall_id),
    CONSTRAINT fk_halls FOREIGN KEY (hall_id)
        REFERENCES halls (id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS films
(
    id          SERIAL PRIMARY KEY,
    title       VARCHAR(45) NOT NULL,
    rental_cost FLOAT NOT NULL
);

CREATE TABLE IF NOT EXISTS sessions
(
    id         SERIAL PRIMARY KEY,
    start_time TIME NOT NULL
);

CREATE TABLE IF NOT EXISTS pivot_with_base_prices
(
    id         SERIAL PRIMARY KEY,
    hall_id    INT NOT NULL,
    film_id    INT NOT NULL,
    session_id INT NOT NULL,
    base_price FLOAT NOT NULL,
    UNIQUE (hall_id, film_id, session_id),
    CONSTRAINT fk_pivot_films FOREIGN KEY (film_id)
        REFERENCES films (id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_pivot_halls FOREIGN KEY (hall_id)
        REFERENCES halls (id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_session FOREIGN KEY (session_id)
        REFERENCES sessions (id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS tickets
(
    id_pivot_with_base_prices INT NOT NULL,
    seat_id                   INT NOT NULL,
    session_date              DATE NOT NULL,
    real_price                FLOAT,
    PRIMARY KEY (id_pivot_with_base_prices, seat_id, session_date),
    CONSTRAINT fk_pivot_with_base_prices
        FOREIGN KEY (id_pivot_with_base_prices)
            REFERENCES pivot_with_base_prices (id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
    CONSTRAINT fk_seats FOREIGN KEY (seat_id)
        REFERENCES seats (id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);
