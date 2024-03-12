CREATE db;

CREATE TABLE IF NOT EXISTS db.movies
(
    id    SERIAL PRIMARY KEY,
    title   VARCHAR(255) NOT NULL,
    release_date    INT NOT NULL,
    duration_minutes    INT NOT NULL,
    country_name    VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS db.genres
(
    id    SERIAL PRIMARY KEY,
    name    VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS db.directors
(
    id SERIAL PRIMARY KEY,
    first_name  VARCHAR(50) NOT NULL,
    last_name   VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS db.halls
(
    id SERIAL PRIMARY KEY,
    name    VARCHAR(45) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS db.visitors
(
    id  SERIAL PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    email   VARCHAR(45) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS db.movie_genre
(
    movie_id    INT NOT NULL,
    genre_id    INT NOT NULL,
    PRIMARY KEY (movie_id, genre_id),
    FOREIGN KEY (movie_id) REFERENCES db.movies (id),
    FOREIGN KEY (genre_id) REFERENCES db.genres (id)
);

CREATE TABLE IF NOT EXISTS db.movie_director
(
    movie_id    INT NOT NULL,
    director_id INT NOT NULL,
    PRIMARY KEY (movie_id, director_id),
    FOREIGN KEY (movie_id) REFERENCES db.movies (id),
    FOREIGN KEY (director_id) REFERENCES db.directors (id)
);

CREATE TABLE IF NOT EXISTS db.seats
(
    id SERIAL PRIMARY KEY,
    row INT NOT NULL,
    number  INT NOT NULL,
    hall_id INT NOT NULL,
    CONSTRAINT number_seat_hall_id UNIQUE (number, hall_id),
    FOREIGN KEY (hall_id) REFERENCES db.halls (id)
);

CREATE TABLE IF NOT EXISTS db.sessions
(
    id SERIAL PRIMARY KEY,
    start   TIMESTAMP NOT NULL,
    end TIMESTAMP NOT NULL,
    movie_id    INT NOT NULL,
    hall_id INT NOT NULL,
    CONSTRAINT start_hall_id UNIQUE (start, hall_id),
    FOREIGN KEY (hall_id) REFERENCES db.halls (id),
    FOREIGN KEY (movie_id) REFERENCES db.movies (id)
);

CREATE TABLE IF NOT EXISTS db.tickets
(
    id   SERIAL PRIMARY KEY,
    visitor_id  INT NOT NULL,
    price   DECIMAL(10, 2) NOT NULL,
    purchase   TIMESTAMP,
    session_id  INT NOT NULL,
    seat_id INT NOT NULL,
    FOREIGN KEY (session_id) REFERENCES db.sessions (id),
    FOREIGN KEY (visitor_id) REFERENCES db.visitors (id),
    FOREIGN KEY (seat_id) REFERENCES db.seats (id)
);