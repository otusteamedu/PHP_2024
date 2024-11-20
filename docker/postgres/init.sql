DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS countries;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS directors;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS movie_genre;
DROP TABLE IF EXISTS movie_director;
DROP TABLE IF EXISTS movie_country;
DROP TABLE IF EXISTS seats;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS tickets;

CREATE TABLE IF NOT EXISTS movies
(
    id    SERIAL PRIMARY KEY,
    title   VARCHAR(255) NOT NULL,
    release_date    TIMESTAMP NOT NULL,
    duration_minutes    INT NOT NULL
);

CREATE TABLE IF NOT EXISTS countries
(
    id  SERIAL PRIMARY KEY,
    name    VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS genres
(
    id    SERIAL PRIMARY KEY,
    name    VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS directors
(
    id SERIAL PRIMARY KEY,
    first_name  VARCHAR(50) NOT NULL,
    last_name   VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS halls
(
    id SERIAL PRIMARY KEY,
    name    VARCHAR(45) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS movie_genre
(
    movie_id    INT NOT NULL,
    genre_id    INT NOT NULL,
    PRIMARY KEY (movie_id, genre_id),
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (genre_id) REFERENCES genres (id)
);

CREATE TABLE IF NOT EXISTS movie_director
(
    movie_id    INT NOT NULL,
    director_id INT NOT NULL,
    PRIMARY KEY (movie_id, director_id),
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (director_id) REFERENCES directors (id)
);

CREATE TABLE IF NOT EXISTS movie_country
(
    movie_id    INT NOT NULL,
    country_id  INT NOT NULL,
    PRIMARY KEY (movie_id, country_id),
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (country_id) REFERENCES countries (id)
);

CREATE TABLE IF NOT EXISTS seats
(
    id INT PRIMARY KEY,
    row INT NOT NULL,
    number  INT NOT NULL,
    hall_id INT NOT NULL,
    CONSTRAINT number_seat_hall_id UNIQUE (number, hall_id),
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE IF NOT EXISTS sessions
(
    id SERIAL PRIMARY KEY,
    start_time   TIMESTAMP NOT NULL,
    end_time TIMESTAMP NOT NULL,
    movie_id    INT NOT NULL,
    hall_id INT NOT NULL,
    CONSTRAINT start_hall_id UNIQUE (start_time, hall_id),
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (movie_id) REFERENCES movies (id)
);

CREATE TABLE IF NOT EXISTS tickets
(
    id   SERIAL PRIMARY KEY,
    price   DECIMAL(10, 2) NOT NULL,
    purchase   TIMESTAMP,
    session_id  INT NOT NULL,
    seat_id INT NOT NULL,
    FOREIGN KEY (session_id) REFERENCES sessions (id),
    FOREIGN KEY (seat_id) REFERENCES seats (id)
);