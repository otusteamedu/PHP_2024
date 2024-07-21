CREATE TABLE cinemas
(
    id      SERIAL PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL
);

CREATE TABLE halls
(
    id        SERIAL PRIMARY KEY,
    cinema_id INT REFERENCES cinemas (id) NOT NULL,
    name      VARCHAR(255)                NOT NULL
);

CREATE TABLE seats
(
    id      SERIAL PRIMARY KEY,
    hall_id INT REFERENCES halls (id) NOT NULL,
    row     INT                       NOT NULL,
    number  INT                       NOT NULL,
    markup  INT                       NOT NULL DEFAULT 0,
    UNIQUE (hall_id, row, number)
);

CREATE TABLE customers
(
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE genres
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE movies
(
    id           SERIAL PRIMARY KEY,
    title        VARCHAR(255)               NOT NULL,
    duration     INT                        NOT NULL,
    rating       VARCHAR(10)                NOT NULL,
    genre_id     INT REFERENCES genres (id) NOT NULL,
    release_date DATE                       NOT NULL,
    description  TEXT
);

CREATE TABLE sessions
(
    id         SERIAL PRIMARY KEY,
    hall_id    INT REFERENCES halls (id)  NOT NULL,
    movie_id   INT REFERENCES movies (id) NOT NULL,
    start_time TIMESTAMP                  NOT NULL,
    price      DECIMAL(10, 2)             NOT NULL
);

CREATE TABLE tickets
(
    id           SERIAL PRIMARY KEY,
    session_id   INT REFERENCES sessions (id)  NOT NULL,
    seat_id      INT REFERENCES seats (id)     NOT NULL,
    customer_id  INT REFERENCES customers (id) NOT NULL,
    purchased_at TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (session_id, seat_id)
);
