DROP TABLE IF EXISTS movies_directors;
DROP TABLE IF EXISTS movies_countries;
DROP TABLE IF EXISTS movies_genres;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS directors;
DROP TABLE IF EXISTS countries;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS seats;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS movies;

CREATE TABLE IF NOT EXISTS directors
(
    id serial PRIMARY KEY,
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL DEFAULT '',
    full_name varchar(255) NOT NULL,
    CONSTRAINT directors__first_name__is_not_empty_string CHECK (trim(first_name) <> ''),
    CONSTRAINT directors__full_name__is_not_empty_string CHECK (trim(full_name) <> '')
);

CREATE TABLE IF NOT EXISTS countries
(
    id smallserial PRIMARY KEY,
    name varchar(255) NOT NULL,
    CONSTRAINT countries__name__uniqie UNIQUE (name)
);

CREATE TABLE IF NOT EXISTS genres
(
    id smallserial PRIMARY KEY,
    name varchar(255) NOT NULL,
    CONSTRAINT genres__name__unique UNIQUE (name)
);

CREATE TABLE IF NOT EXISTS movies
(
    id serial PRIMARY KEY,
    title varchar(255) NOT NULL,
    release_date date NOT NULL,
    duration smallint NOT NULL,
    description text DEFAULT NULL,
    CONSTRAINT movies__duration__positive CHECK (duration > 0)
);

CREATE TABLE IF NOT EXISTS movies_directors
(
    movie_id integer NOT NULL,
    director_id integer NOT NULL,
    PRIMARY KEY (movie_id, director_id),
    FOREIGN KEY (movie_id) REFERENCES movies(id),
    FOREIGN KEY (director_id) REFERENCES directors(id)
);

CREATE INDEX index__movies_directors__movie_id ON movies_directors(movie_id);
CREATE INDEX index__movies_directors__director_id ON movies_directors(director_id);

CREATE TABLE IF NOT EXISTS movies_countries
(
    movie_id integer NOT NULL,
    country_id smallint NOT NULL,
    PRIMARY KEY (movie_id, country_id),
    FOREIGN KEY (movie_id) REFERENCES movies(id),
    FOREIGN KEY (country_id) REFERENCES countries(id)
);

CREATE INDEX index__movies_countries__movie_id ON movies_countries(movie_id);
CREATE INDEX index__movies_countries__country_id ON movies_countries(country_id);

CREATE TABLE IF NOT EXISTS movies_genres
(
    movie_id integer NOT NULL,
    genre_id smallint NOT NULL,
    PRIMARY KEY (movie_id, genre_id),
    FOREIGN KEY (movie_id) REFERENCES movies(id),
    FOREIGN KEY (genre_id) REFERENCES genres(id)
);

CREATE INDEX index__movies_genres__movie_id ON movies_genres(movie_id);
CREATE INDEX index__movies_genres__genre_id ON movies_genres(genre_id);

CREATE TABLE IF NOT EXISTS halls
(
    id smallserial PRIMARY KEY,
    name varchar(255) NOT NULL,
    CONSTRAINT halls__name__unique UNIQUE (name)
);

CREATE TABLE IF NOT EXISTS seats
(
    id serial PRIMARY KEY,
    hall_id smallint NOT NULL,
    row_number smallint NOT NULL,
    seat_number smallint NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls(id),
    CONSTRAINT seats__hall_id__row_number__seat_number__unique UNIQUE(hall_id, row_number, seat_number),
    CONSTRAINT seats__row_number__positive CHECK (row_number > 0),
    CONSTRAINT seats__seat_number__positive CHECK (seat_number > 0)
);

CREATE INDEX index__seats__hall_id ON seats(hall_id);

CREATE TABLE IF NOT EXISTS sessions
(
    id serial PRIMARY KEY,
    movie_id integer NOT NULL,
    hall_id smallint NOT NULL,
    starts_at timestamptz NOT NULL,
    ends_at timestamptz NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(id),
    FOREIGN KEY (hall_id) REFERENCES halls(id),
    CONSTRAINT sessions__hall_id__starts_at__unique UNIQUE(hall_id, starts_at),
    CONSTRAINT sessions__stats_at__less_tham__ends_at CHECK (starts_at < ends_at)
);

CREATE INDEX index__sessions__movie_id ON sessions(movie_id);
CREATE INDEX index__sessions__hall_id ON sessions(hall_id);

CREATE TABLE IF NOT EXISTS tickets
(
    id bigserial PRIMARY KEY,
    session_id integer NOT NULL,
    seat_id integer NOT NULL,
    price numeric(10, 2) NOT NULL,
    sold_at timestamptz DEFAULT NULL,
    FOREIGN KEY (session_id) REFERENCES  sessions(id),
    FOREIGN KEY (seat_id) REFERENCES seats(id),
    CONSTRAINT tickets__session_id__seat_id__unique UNIQUE(session_id, seat_id),
    CONSTRAINT tickets__price__positive CHECK (price > 0)
);

CREATE INDEX index__tickets__session_id ON tickets(session_id);
CREATE INDEX index__tickets__seat_id ON tickets(seat_id);
