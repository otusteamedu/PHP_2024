DROP TABLE IF EXISTS ticket;
DROP TABLE IF EXISTS session;
DROP TABLE IF EXISTS genre_movie;
DROP TABLE IF EXISTS movie;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS hall;

CREATE TABLE genre
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE movie
(
    id       serial primary key,
    title    varchar(255) UNIQUE,
    country    varchar(255) UNIQUE,
    duration smallint NOT NULL CHECK ( duration > 0 ), -- minutes
    creation_year bigint NOT NULL CHECK ( creation_year > 0)
);

CREATE TABLE genre_movie
(
    genre_id INT NOT NULL,
    movie_id INT NOT NULL,
    PRIMARY KEY (genre_id, movie_id),
    FOREIGN KEY (genre_id) REFERENCES genre(id),
    FOREIGN KEY (movie_id) REFERENCES movie(id)
);

CREATE TABLE hall
(
    nick                    varchar(255) primary key,
    number_of_rows          smallint NOT NULL CHECK ( number_of_rows > 0 ),
    number_of_seats_per_row smallint NOT NULL CHECK ( number_of_seats_per_row > 0 )
);

CREATE TABLE session
(
    id          serial primary key,
    movie       serial NOT NULL REFERENCES movie (id),
    hall        varchar(255) NOT NULL REFERENCES hall (nick),
    start_ts    timestamptz  NOT NULL,
    end_ts      timestamptz  NOT NULL,
    ticket_cost int          NOT NULL CHECK ( ticket_cost > 0 )
);

CREATE TABLE ticket
(
    session_id serial NOT NULL REFERENCES session (id) ON DELETE CASCADE,
    row        int NOT NULL CHECK ( row > 0 ),
    seat       int NOT NULL CHECK ( row > 0 ),
    PRIMARY KEY(session_id, row, seat)
);
