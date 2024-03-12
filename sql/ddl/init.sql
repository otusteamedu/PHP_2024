-- кинотеатры
CREATE TABLE IF NOT EXISTS cinemas (
    id bigint PRIMARY KEY,
    name          varchar(255)
);

-- залы
CREATE TABLE IF NOT EXISTS halls (
    id bigint PRIMARY KEY,
    cinema_id bigint REFERENCES cinemas (id)
);

-- жанры
CREATE TABLE IF NOT EXISTS countries (
    id bigint PRIMARY KEY,
    name varchar(255) unique
);

-- фильмы
CREATE TABLE IF NOT EXISTS movies (
    id bigint PRIMARY KEY,
    name          varchar(255),
    country_id int REFERENCES countries (id),
    year_of_creation int,
    duration interval,
    description text
);

-- жанры
CREATE TABLE IF NOT EXISTS genres (
    id bigint PRIMARY KEY,
    name varchar(255) unique
);

-- жанры кино
CREATE TABLE IF NOT EXISTS movies_genres (
    id int PRIMARY KEY,
    genre_id bigint REFERENCES genres (id),
    movie_id bigint REFERENCES movies (id)
);

-- сеансы
CREATE TABLE IF NOT EXISTS movies_sessions (
    id bigint PRIMARY KEY,
    hall_id bigint REFERENCES halls (id),
    movie_id bigint REFERENCES movies (id),
    scheduled_at timestamp NOT NULL,
    scheduled_to timestamp NOT NULL
);

-- места
CREATE TABLE IF NOT EXISTS seats (
    id bigint PRIMARY KEY,
    hall_id bigint REFERENCES halls (id),
    seat_number int NOT NULL,
    row_number int NOT NULL
);

-- билеты
CREATE TABLE IF NOT EXISTS tickets (
    id bigint PRIMARY KEY,
    session_id bigint REFERENCES movies_sessions (id),
    seat_id bigint REFERENCES seats (id),
    price money NOT NULL
);

-- стоимость
CREATE TABLE IF NOT EXISTS tickets_price (
    id bigint PRIMARY KEY,
    hall_id bigint REFERENCES halls (id),
    price_time_start time NOT NULL,
    price_time_end time NOT NULL,
    row_from int NOT NULL,
    row_to int NOT NULL,
    price money NOT NULL
);