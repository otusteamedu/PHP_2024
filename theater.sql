CREATE TABLE theater
(
    id      SERIAL PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL
);

CREATE TABLE hall
(
    id         SERIAL PRIMARY KEY,
    theater_id INT REFERENCES theater (id) ON DELETE CASCADE,
    name       VARCHAR(255) NOT NULL,
    capacity   INT          NOT NULL
);

CREATE TABLE seat_type
(
    id   SERIAL PRIMARY KEY,
    type VARCHAR(50) NOT NULL
);

CREATE TABLE seat
(
    id           SERIAL PRIMARY KEY,
    hall_id      INT REFERENCES hall (id) ON DELETE CASCADE,
    seat_type_id INT REFERENCES seat_type (id) ON DELETE SET NULL,
    row_number   INT NOT NULL,
    col_number   INT NOT NULL
);

CREATE TABLE movie
(
    id          SERIAL PRIMARY KEY,
    title       VARCHAR(255) NOT NULL,
    description TEXT         NOT NULL,
    duration    INT          NOT NULL,
    rating      VARCHAR(50)
);

CREATE TABLE session
(
    id         SERIAL PRIMARY KEY,
    movie_id   INT REFERENCES movie (id) ON DELETE CASCADE,
    hall_id    INT REFERENCES hall (id) ON DELETE CASCADE,
    start_time TIMESTAMP NOT NULL,
    end_time   TIMESTAMP NOT NULL
);

CREATE TABLE price
(
    id           SERIAL PRIMARY KEY,
    session_id   INT REFERENCES session (id) ON DELETE CASCADE,
    seat_type_id INT REFERENCES seat_type (id) ON DELETE CASCADE,
    price        DECIMAL(10, 2) NOT NULL
);

CREATE TABLE ticket
(
    id       SERIAL PRIMARY KEY,
    price_id INT REFERENCES price (id) ON DELETE CASCADE,
    sold_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);