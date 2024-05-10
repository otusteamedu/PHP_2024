DROP TABLE IF EXISTS movies_genres;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS movies;

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