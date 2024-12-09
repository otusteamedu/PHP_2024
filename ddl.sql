DROP DATABASE IF EXISTS cinema_db;

CREATE DATABASE cinema_db WITH ENCODING 'UTF8';

\c  cinema_db

CREATE TABLE IF NOT EXISTS halls
(
    id         SERIAL PRIMARY KEY,
    title      VARCHAR(45),
    seat_count INT
);

CREATE TABLE IF NOT EXISTS films
(
    id          SERIAL PRIMARY KEY,
    title       VARCHAR(45),
    rental_cost FLOAT
);

CREATE TABLE IF NOT EXISTS sessions
(
    id         SERIAL PRIMARY KEY,
    start_time TIME
);

CREATE TABLE IF NOT EXISTS pivot_with_base_prices
(
    id         SERIAL PRIMARY KEY,
    hall_id    INT,
    film_id    INT,
    session_id INT,
    price      FLOAT,
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
    id_pivot_with_base_prices INT,
    seat                 INT,
    session_date         DATE,
    PRIMARY KEY (id_pivot_with_base_prices, seat, session_date),
    CONSTRAINT fk_pivot_with_base_prices
        FOREIGN KEY (id_pivot_with_base_prices)
            REFERENCES pivot_with_base_prices (id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
);
