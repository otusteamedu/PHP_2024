DROP TABLE IF EXISTS theatres CASCADE;
DROP TABLE IF EXISTS movies CASCADE;
DROP TABLE IF EXISTS shows CASCADE;
DROP TABLE IF EXISTS tickets CASCADE;

CREATE TABLE IF NOT EXISTS theatres
(
    id       SERIAL PRIMARY KEY,
    title    VARCHAR(255) NOT NULL,
    location TEXT         NOT NULL,
    capacity INT          NOT NULL
);

CREATE TABLE IF NOT EXISTS movies
(
    id    SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS shows
(
    id        SERIAL PRIMARY KEY,
    movie_id  INT       NOT NULL,
    theatre_id INT       NOT NULL,
    start     TIMESTAMP NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(id),
    FOREIGN KEY (theatre_id) REFERENCES theatres(id)
);

CREATE TABLE IF NOT EXISTS tickets
(
    id        SERIAL PRIMARY KEY,
    show_id   INT     NOT NULL,
    seat      INT     NOT NULL,
    price     INT     NOT NULL,
    available BOOLEAN NOT NULL DEFAULT true,
    FOREIGN KEY (show_id) REFERENCES shows(id)
);
