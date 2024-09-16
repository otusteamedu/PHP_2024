CREATE TABLE IF NOT EXISTS films
(
    id          bigint PRIMARY KEY,
    name        varchar(255),
    year_date   int,
    description text,
    duration    smallint
);

CREATE TABLE IF NOT EXISTS halls
(
    id   bigint PRIMARY KEY,
    name varchar(255) unique
);

CREATE TABLE IF NOT EXISTS countries
(
    id   bigint PRIMARY KEY,
    name varchar(255) unique
);

CREATE TABLE IF NOT EXISTS films_countries
(
    countries_id bigint NOT NULL,
    film_id      bigint NOT NULL,
    PRIMARY KEY (film_id, countries_id),
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (countries_id) REFERENCES countries (id)
);

CREATE TABLE IF NOT EXISTS genres
(
    id   bigint PRIMARY KEY,
    name varchar(255) unique
);

CREATE TABLE IF NOT EXISTS films_genres
(
    genre_id bigint NOT NULL,
    film_id  bigint NOT NULL,
    PRIMARY KEY (film_id, genre_id),
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (genre_id) REFERENCES genres (id)
);

CREATE TABLE IF NOT EXISTS films_sessions
(
    id         bigint PRIMARY KEY,
    hall_id    bigint    NOT NULL,
    film_id    bigint    NOT NULL,
    start_time timestamp NOT NULL,
    end_time   timestamp NOT NULL,
    base_price money NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (film_id) REFERENCES films (id)
);

CREATE TABLE IF NOT EXISTS seats
(
    id          bigint PRIMARY KEY,
    hall_id     bigint NOT NULL,
    seat_number int    NOT NULL,
    row_number  int    NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE IF NOT EXISTS tickets
(
    id         bigint PRIMARY KEY,
    session_id bigint    NOT NULL,
    seat_id    bigint    NOT NULL,
    price      money     NOT NULL,
    pay_time   timestamp NOT NULL,
    FOREIGN KEY (session_id) REFERENCES films_sessions (id),
    FOREIGN KEY (seat_id) REFERENCES seats (id)
);

