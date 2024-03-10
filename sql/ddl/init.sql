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

-- фильмы
CREATE TABLE IF NOT EXISTS movies (
    id bigint PRIMARY KEY,
    name          varchar(255) unique
);

-- сеансы
CREATE TABLE IF NOT EXISTS moviesSessions (
    id bigint PRIMARY KEY,
    hall_id bigint REFERENCES halls (id),
    movie_id bigint REFERENCES movies (id),
    scheduled_at timestamp NOT NULL
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
    session_id bigint REFERENCES moviesSessions (id),
    seat_id bigint REFERENCES seats (id),
    amount numeric NOT NULL
);

-- стоимость
CREATE TABLE IF NOT EXISTS tickets_amount (
    id bigint PRIMARY KEY,
    hall_id bigint REFERENCES halls (id),
    amount_time_start time NOT NULL,
    amount_time_end time NOT NULL,
    row_from int NOT NULL,
    row_to int NOT NULL,
    amount numeric NOT NULL
);