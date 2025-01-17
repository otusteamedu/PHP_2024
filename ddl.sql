CREATE DATABASE cinema;

CREATE TABLE movies
(
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    duration INTEGER NOT NULL
);

CREATE TABLE halls
(
    id          SERIAL PRIMARY KEY,
    room_number INTEGER NOT NULL
);

CREATE TABLE places
(
    id      SERIAL PRIMARY KEY,
    row     INTEGER NOT NULL,
    place   INTEGER NOT NULL,
    hall_id INTEGER REFERENCES halls (id)
);

CREATE TABLE sessions
(
    id       SERIAL PRIMARY KEY,
    date     TIMESTAMP NOT NULL,
    movie_id INTEGER REFERENCES movies (id),
    hall_id  INTEGER REFERENCES halls (id)
);

CREATE TABLE tickets
(
    id         SERIAL PRIMARY KEY,
    price      DECIMAL(10, 2) NOT NULL,
    session_id INTEGER REFERENCES sessions (id),
    place_id   INTEGER REFERENCES places (id)
);

CREATE TABLE users
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE tickets_sold
(
    id        SERIAL PRIMARY KEY,
    ticket_id INTEGER UNIQUE REFERENCES tickets (id),
    user_id   INTEGER REFERENCES users (id)
);