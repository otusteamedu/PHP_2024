CREATE TABLE films (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL
);

CREATE INDEX idx_film_date ON films (date);

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

CREATE TABLE movie_sessions (
    id SERIAL PRIMARY KEY,
    film_id INT NOT NULL REFERENCES films (id),
    room_id INT NOT NULL REFERENCES rooms (id),
    start_at TIMESTAMP NOT NULL,
    duration TIME NOT NULL
);
CREATE INDEX idx_movie_session_start_at ON movie_sessions (start_at);

CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,
    session_id INT NOT NULL REFERENCES movie_sessions (id),
    place_id INT NOT NULL REFERENCES rooms_places (id),
    price DECIMAL(6, 2) NOT NULL,
    sold BOOLEAN NOT NULL DEFAULT false,
    sold_at TIMESTAMP
);

CREATE INDEX idx_ticket_place ON tickets (place_id);
CREATE INDEX idx_ticket_session ON tickets (session_id);
CREATE INDEX idx_ticket_sold ON tickets (sold_at, sold);