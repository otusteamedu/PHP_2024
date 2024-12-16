-- Таблица кинотеатров
CREATE TABLE Theaters (
                          theater_id SERIAL PRIMARY KEY,
                          name VARCHAR(100) NOT NULL,
                          location VARCHAR(255)
);

-- Таблица залов
CREATE TABLE Halls (
                       hall_id SERIAL PRIMARY KEY,
                       theater_id INT NOT NULL,
                       name VARCHAR(50) NOT NULL,
                       total_seats INT NOT NULL,
                       FOREIGN KEY (theater_id) REFERENCES Theaters(theater_id)
);

-- Таблица фильмов
CREATE TABLE Movies (
                        movie_id SERIAL PRIMARY KEY,
                        title VARCHAR(100) NOT NULL,
                        duration_minutes INT NOT NULL,
                        genre VARCHAR(50),
                        release_date DATE
);

-- Таблица сеансов
CREATE TABLE Sessions (
                          session_id SERIAL PRIMARY KEY,
                          hall_id INT NOT NULL,
                          movie_id INT NOT NULL,
                          start_time TIMESTAMP NOT NULL,
                          price_base DECIMAL(10, 2) NOT NULL,
                          FOREIGN KEY (hall_id) REFERENCES Halls(hall_id),
                          FOREIGN KEY (movie_id) REFERENCES Movies(movie_id)
);

-- Таблица мест
CREATE TABLE Seats (
                       seat_id SERIAL PRIMARY KEY,
                       hall_id INT NOT NULL,
                       row_number INT NOT NULL,
                       seat_number INT NOT NULL,
                       FOREIGN KEY (hall_id) REFERENCES Halls(hall_id)
);

-- Таблица клиентов
CREATE TABLE Clients (
                         client_id SERIAL PRIMARY KEY,
                         name VARCHAR(100),
                         email VARCHAR(100)
);

-- Таблица билетов
CREATE TABLE Tickets (
                         ticket_id SERIAL PRIMARY KEY,
                         session_id INT NOT NULL,
                         seat_id INT NOT NULL,
                         client_id INT,
                         price DECIMAL(10, 2) NOT NULL,
                         FOREIGN KEY (session_id) REFERENCES Sessions(session_id),
                         FOREIGN KEY (seat_id) REFERENCES Seats(seat_id),
                         FOREIGN KEY (client_id) REFERENCES Clients(client_id)
);
