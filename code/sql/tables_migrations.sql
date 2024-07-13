CREATE TABLE genre
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE movie
(
    id       SERIAL PRIMARY KEY,
    title    varchar(255) UNIQUE,
    duration smallint NOT NULL CHECK ( duration > 0 )
);

CREATE TABLE genre_movie
(
    genre_id INT NOT NULL,
    movie_id INT NOT NULL,
    PRIMARY KEY (genre_id, movie_id)
-- ,
--     FOREIGN KEY (genre_id) REFERENCES genre (id),
--     FOREIGN KEY (movie_id) REFERENCES movie (id)
);

CREATE TABLE hall
(
    name varchar(255) PRIMARY KEY,
    rows smallint NOT NULL CHECK ( rows > 0
) ,
    columns smallint NOT NULL CHECK ( columns > 0 )
);

CREATE TABLE session
(
    id        SERIAL PRIMARY KEY,
    movie     INT          NOT NULL REFERENCES movie (id),
    hall      varchar(255) NOT NULL REFERENCES hall (name),
    dateStart TIMESTAMP    NOT NULL,
    dateEnd   TIMESTAMP    NOT NULL,
    basePrice smallint     NOT NULL CHECK ( basePrice > 0 )
);

CREATE TABLE ticket
(
    session_id   INT      NOT NULL REFERENCES session (id) ON DELETE CASCADE,
    row          smallint NOT NULL CHECK ( row > 0 ),
    columnNumber smallint NOT NULL CHECK ( columnNumber > 0),
    price        smallint NOT NULL CHECK ( price > 0 ),
    PRIMARY KEY (session_id, row, columnNumber)
);
