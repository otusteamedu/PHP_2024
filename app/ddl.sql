CREATE TABLE countries (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    UNIQUE (name)
);

CREATE TABLE genres (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    UNIQUE (name)
);

CREATE TABLE films (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
);

CREATE TABLE film_genres (
    film_id INT NOT NULL REFERENCES films (id),
    genre_id INT NOT NULL REFERENCES genres (id),
    UNIQUE (film_id, genre_id)
);

CREATE TABLE film_genres (
    film_id INT NOT NULL REFERENCES films (id),
    country_id INT NOT NULL REFERENCES countries (id),
    UNIQUE (film_id, country_id)
);

CREATE TABLE rooms (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    UNIQUE (name)
);

CREATE TABLE rooms_places (
    id SERIAL PRIMARY KEY,
    room_id INT NOT NULL REFERENCES rooms (id),
    name VARCHAR(255) NOT NULL,
    row SMALLINT NOT NULL,
    number SMALLINT NOT NULL
);

CREATE INDEX idx_place_room ON rooms_places (room_id);

CREATE TABLE movie_sessions (
    id SERIAL PRIMARY KEY,
    film_id INT NOT NULL REFERENCES films (id),
    room_id INT NOT NULL REFERENCES rooms (id),
    start_at TIMESTAMP NOT NULL,
    duration TIME NOT NULL
);

CREATE INDEX idx_session_film ON movie_sessions (film_id);
CREATE INDEX idx_session_room ON movie_sessions (room_id);

CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,
    session_id INT NOT NULL REFERENCES movie_sessions (id),
    place_id INT NOT NULL REFERENCES rooms_places (id),
    price DECIMAL(6, 2) NOT NULL,
    sold BOOLEAN NOT NULL DEFAULT false
);

CREATE INDEX idx_ticket_session ON tickets (session_id);
CREATE INDEX idx_ticket_place ON tickets (place_id);