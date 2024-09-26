CREATE TABLE IF NOT EXISTS db.users
(
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(255)       NOT NULL,
    email VARCHAR(45) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS db.halls
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(45) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS db.movies
(
    id               SERIAL PRIMARY KEY,
    title            VARCHAR(255) NOT NULL,
    release_year     INT          NOT NULL,
    duration_minutes INT          NOT NULL
);

CREATE TABLE IF NOT EXISTS db.genres
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS db.movie_genres
(
    movie_id INT NOT NULL,
    genre_id INT NOT NULL,
    PRIMARY KEY (movie_id, genre_id),
    FOREIGN KEY (movie_id) REFERENCES db.movies (id),
    FOREIGN KEY (genre_id) REFERENCES db.genres (id)
);

CREATE TABLE IF NOT EXISTS db.directors
(
    id         SERIAL PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name  VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS db.movie_directors
(
    movie_id    INT NOT NULL,
    director_id INT NOT NULL,
    PRIMARY KEY (movie_id, director_id),
    FOREIGN KEY (movie_id) REFERENCES db.movies (id),
    FOREIGN KEY (director_id) REFERENCES db.directors (id)
);

CREATE TABLE IF NOT EXISTS db.seats
(
    id          SERIAL PRIMARY KEY,
    hall_id     INT NOT NULL,
    row_number  INT NOT NULL,
    seat_number INT NOT NULL,
    CONSTRAINT seat_number_hall_id UNIQUE (seat_number, hall_id),
    FOREIGN KEY (hall_id) REFERENCES db.halls (id)
);

CREATE TABLE IF NOT EXISTS db.sessions
(
    id         SERIAL PRIMARY KEY,
    movie_id   INT       NOT NULL,
    hall_id    INT       NOT NULL,
    start_time TIMESTAMP NOT NULL,
    end_time   TIMESTAMP NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES db.halls (id),
    FOREIGN KEY (movie_id) REFERENCES db.movies (id)
);

CREATE TABLE IF NOT EXISTS db.tickets
(
    id            SERIAL PRIMARY KEY,
    session_id    INT            NOT NULL,
    user_id       INT            NOT NULL,
    seat_id       INT            NOT NULL,
    price         DECIMAL(10, 2) NOT NULL,
    purchase_time TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES db.sessions (id),
    FOREIGN KEY (user_id) REFERENCES db.users (id),
    FOREIGN KEY (seat_id) REFERENCES db.seats (id)
);
