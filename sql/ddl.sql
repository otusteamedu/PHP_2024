CREATE TABLE Cinemas
(
    id       SERIAL PRIMARY KEY,
    name     TEXT NOT NULL,
    location TEXT NOT NULL
);

CREATE TABLE Halls
(
    id         SERIAL PRIMARY KEY,
    cinema_id  INTEGER REFERENCES Cinemas (id),
    name       TEXT    NOT NULL,
    seat_count INTEGER NOT NULL
);

CREATE TABLE Movies
(
    id           SERIAL PRIMARY KEY,
    title        TEXT     NOT NULL,
    duration     INTERVAL NOT NULL,
    genre        TEXT     NOT NULL,
    release_date DATE     NOT NULL
);

CREATE TABLE Sessions
(
    id         SERIAL PRIMARY KEY,
    hall_id    INTEGER REFERENCES Halls (id),
    movie_id   INTEGER REFERENCES Movies (id),
    start_time TIMESTAMP      NOT NULL,
    price      DECIMAL(10, 2) NOT NULL
);

CREATE TABLE Seats
(
    id          SERIAL PRIMARY KEY,
    hall_id     INTEGER REFERENCES Halls (id),
    row         INTEGER NOT NULL,
    seat_number INTEGER NOT NULL
);

CREATE TABLE Tickets
(
    id            SERIAL PRIMARY KEY,
    session_id    INTEGER REFERENCES Sessions (id),
    seat_id       INTEGER REFERENCES Seats (id),
    customer_name TEXT           NOT NULL,
    price         DECIMAL(10, 2) NOT NULL
);

CREATE TABLE TicketSales
(
    id           SERIAL PRIMARY KEY,
    ticket_id    INTEGER REFERENCES Tickets (id),
    sale_time    TIMESTAMP      NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL
);
