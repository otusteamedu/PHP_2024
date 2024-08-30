CREATE TABLE cinema
(
    cinema_id    SERIAL PRIMARY KEY,
    name         VARCHAR(255) NOT NULL,
    address      VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20)
);

CREATE TABLE hall
(
    hall_id       SERIAL PRIMARY KEY,
    cinema_id     INT,
    name          VARCHAR(255) NOT NULL,
    seat_capacity INT          NOT NULL,
    FOREIGN KEY (cinema_id) REFERENCES cinema (cinema_id)
);

CREATE TABLE seat
(
    seat_id     SERIAL PRIMARY KEY,
    hall_id     INT,
    row_number  INT NOT NULL,
    seat_number INT NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES hall (hall_id)
);

CREATE TABLE movie
(
    movie_id SERIAL PRIMARY KEY,
    title    VARCHAR(255) NOT NULL,
    duration INT          NOT NULL,
    genre    VARCHAR(100),
    rating   VARCHAR(10)
);

CREATE TABLE show
(
    show_id          SERIAL PRIMARY KEY,
    hall_id          INT,
    movie_id         INT,
    start_time       DATE           NOT NULL,
    price_per_ticket DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES hall (hall_id),
    FOREIGN KEY (movie_id) REFERENCES movie (movie_id)
);

CREATE TABLE ticket
(
    ticket_id     SERIAL PRIMARY KEY,
    show_id       INT,
    seat_id       INT,
    purchase_time DATE           NOT NULL,
    price         DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (show_id) REFERENCES show (show_id),
    FOREIGN KEY (seat_id) REFERENCES seat (seat_id)
);