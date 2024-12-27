DROP TABLE IF EXISTS cinemas CASCADE;
DROP TABLE IF EXISTS cinema_halls CASCADE;
DROP TABLE IF EXISTS movies CASCADE;
DROP TABLE IF EXISTS shows CASCADE;
DROP TABLE IF EXISTS tickets CASCADE;
DROP TABLE IF EXISTS customers CASCADE;
DROP TABLE IF EXISTS purchases CASCADE;
DROP TABLE IF EXISTS purchase_tickets CASCADE;

CREATE TABLE IF NOT EXISTS cinemas (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    location TEXT NOT NULL,
    contacts TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS cinema_halls (
    id SERIAL PRIMARY KEY,
    cinema_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    type INT NOT NULL,
    FOREIGN KEY (cinema_id) REFERENCES cinemas(id)
);

CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(255),
    duration INT,
    release_date DATE,
    description TEXT
);

CREATE TABLE IF NOT EXISTS shows (
    id SERIAL PRIMARY KEY,
    cinema_hall_id INT NOT NULL,
    movie_id INT,
    start TIMESTAMP NOT NULL,
    "end" TIMESTAMP NOT NULL,
    FOREIGN KEY (cinema_hall_id) REFERENCES cinema_halls(id),
    FOREIGN KEY (movie_id) REFERENCES movies(id)
);

CREATE TABLE IF NOT EXISTS customers (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS purchases (
    id SERIAL PRIMARY KEY,
    purchase_date TIMESTAMP NOT NULL,
    customer_id INT,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

CREATE TABLE IF NOT EXISTS tickets (
    id SERIAL PRIMARY KEY,
    show_id INT NOT NULL,
    row INT NOT NULL,
    seat INT NOT NULL,
    price INT NOT NULL,
    UNIQUE (show_id, row, seat),
    FOREIGN KEY (show_id) REFERENCES shows(id)
);

CREATE TABLE IF NOT EXISTS purchase_tickets (
    id SERIAL PRIMARY KEY,
    purchase_id INT NOT NULL,
    ticket_id INT,
    UNIQUE (ticket_id),
    FOREIGN KEY (purchase_id) REFERENCES purchases(id),
    FOREIGN KEY (ticket_id) REFERENCES tickets(id)
);