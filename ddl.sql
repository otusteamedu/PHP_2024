DROP TABLE IF EXISTS halls, movies, places, sessions, tickets, clients, orders, order_tickets;

CREATE TABLE IF NOT EXISTS halls
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS movies
(
    id    SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    year  SMALLINT     NOT NULL DEFAULT (0)
);


CREATE TABLE IF NOT EXISTS places
(
    id   SERIAL PRIMARY KEY,
    row  INT NOT NULL DEFAULT '0',
    seat INT NOT NULL DEFAULT '0'
);


CREATE TABLE IF NOT EXISTS sessions
(
    id         SERIAL PRIMARY KEY,
    "date"     DATE NOT NULL,
    start_time TIME NOT NULL,
    hall_id    INT  NOT NULL DEFAULT (0) REFERENCES halls (id),
    movie_id   INT  NOT NULL DEFAULT (0) REFERENCES movies (id)
);


CREATE TABLE IF NOT EXISTS tickets
(
    id         SERIAL PRIMARY KEY,
    session_id INT            NOT NULL REFERENCES sessions (id),
    place_id   INT            NOT NULL REFERENCES places (id),
    price      DECIMAL(10, 2) NOT NULL DEFAULT (0)
);


CREATE TABLE IF NOT EXISTS clients
(
    id    SERIAL PRIMARY KEY,
    "name"  varchar(100) NOT NULL DEFAULT '',
    phone varchar(20)  NOT NULL DEFAULT ''
);


CREATE TABLE IF NOT EXISTS orders
(
    id        SERIAL PRIMARY KEY,
    client_id INT NOT NULL REFERENCES clients (id),
    total     DECIMAL(10, 2) NOT NULL DEFAULT (0)
);


CREATE TABLE IF NOT EXISTS order_tickets
(
    id        SERIAL PRIMARY KEY,
    order_id  INT            NOT NULL REFERENCES orders (id),
    ticket_id INT            NOT NULL  REFERENCES tickets (id),
    price     DECIMAL(10, 2) NOT NULL DEFAULT (0)
);

