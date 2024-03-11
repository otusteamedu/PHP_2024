CREATE db;

CREATE TABLE IF NOT EXISTS db.movies
(
    movie_id    SERIAL PRIMARY KEY,
    title   VARCHAR(255) NOT NULL,
    release    INT NOT NULL,
    duration    INTNOT NULL
);

CREATE TABLE IF NOT EXISTS db.genres
(
    genre_id    SERIAL PRIMARY KEY,
    name    VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS db.directors
(
    director_id SERIAL PRIMARY KEY,
    first_name  VARCHAR(50) NOT NULL,
    last_name   VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS db.halls
(
    hall_id SERIAL PRIMARY KEY,
    name    VARCHAR(45) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS db.visitors
(
    visitor_id  SERIAL PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    email   VARCHAR(45) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS db.movie_genre
(
    movie_id    INT NOT NULL,
    genre_id    INT NOT NULL,
    PRIMARY KEY (movie_id, genre_id),
    FOREIGN KEY (movie_id) REFERENCES db.movies (movie_id),
    FOREIGN KEY (genre_id) REFERENCES db.genres (genre_id)
);

CREATE TABLE IF NOT EXISTS db.movie_director
(
    movie_id    INT NOT NULL,
    director_id INT NOT NULL,
    PRIMARY KEY (movie_id, director_id),
    FOREIGN KEY (movie_id) REFERENCES db.movies (movie_id),
    FOREIGN KEY (director_id) REFERENCES db.directors (director_id)
);

CREATE TABLE IF NOT EXISTS db.seats
(
    seat_id SERIAL PRIMARY KEY,
    row INT NOT NULL,
    number  INT NOT NULL,
    hall_id INT NOT NULL,
    CONSTRAINT number_seat_hall_id UNIQUE (number, hall_id),
    FOREIGN KEY (hall_id) REFERENCES db.halls (hall_id)
);

CREATE TABLE IF NOT EXISTS db.sessions
(
    session_id SERIAL PRIMARY KEY,
    start   TIMESTAMP NOT NULL,
    end TIMESTAMP NOT NULL,
    movie_id    INT NOT NULL,
    hall_id INT NOT NULL,
    CONSTRAINT start_hall_id UNIQUE (start, hall_id),
    FOREIGN KEY (hall_id) REFERENCES db.halls (hall_id),
    FOREIGN KEY (movie_id) REFERENCES db.movies (movie_id)
);

CREATE TABLE IF NOT EXISTS db.tickets
(
    ticket_id   SERIAL PRIMARY KEY,
    visitor_id  INT NOT NULL,
    price   DECIMAL(10, 2) NOT NULL,
    purchase   TIMESTAMP,
    session_id  INT NOT NULL,
    seat_id INT NOT NULL,
    FOREIGN KEY (session_id) REFERENCES db.sessions (session_id),
    FOREIGN KEY (visitor_id) REFERENCES db.visitors (visitor_id),
    FOREIGN KEY (seat_id) REFERENCES db.seats (seat_id)
);