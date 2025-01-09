-- Таблица для фильмов
CREATE TABLE movies (
    movie_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(100),
    duration INT,
    release_date DATE
);

-- Таблица для залов
CREATE TABLE halls (
    hall_id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    capacity INT NOT NULL
);

-- Таблица для сеансов
CREATE TABLE sessions (
    session_id SERIAL PRIMARY KEY,
    movie_id INT REFERENCES movies(movie_id),
    hall_id INT REFERENCES halls(hall_id),
    start_time TIMESTAMP NOT NULL
);

-- Таблица для мест в зале
CREATE TABLE seats (
    seat_id SERIAL PRIMARY KEY,
    hall_id INT REFERENCES halls(hall_id),
    seat_number INT NOT NULL,
    row_number INT NOT NULL
);

-- Таблица для клиентов
CREATE TABLE customers (
    customer_id SERIAL PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20)
);

-- Таблица для билетов
CREATE TABLE tickets (
    ticket_id SERIAL PRIMARY KEY,
    session_id INT REFERENCES sessions(session_id),
    seat_id INT REFERENCES seats(seat_id),
    customer_id INT REFERENCES customers(customer_id),
    price DECIMAL(10, 2) NOT NULL
);