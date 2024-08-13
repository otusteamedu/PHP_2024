CREATE TABLE cinema (
                        id SERIAL PRIMARY KEY,
                        name VARCHAR(100) NOT NULL,
                        location VARCHAR(255),
                        number_of_halls INT
);

CREATE TABLE halls (
                       id SERIAL PRIMARY KEY,
                       cinema_id INT,
                       name VARCHAR(50),
                       capacity INT,
                       layout JSON,
                       FOREIGN KEY (cinema_id) REFERENCES cinema(id)
);

CREATE TABLE movies (
                        id SERIAL PRIMARY KEY,
                        title VARCHAR(150) NOT NULL,
                        genre VARCHAR(50),
                        duration INT,
                        rating DECIMAL(2, 1)
);

CREATE TABLE sessions (
                          id SERIAL PRIMARY KEY,
                          hall_id INT,
                          movie_id INT,
                          start_time TIMESTAMP,
                          end_time TIMESTAMP,
                          price DECIMAL(10, 2),
                          available_seats INT,
                          FOREIGN KEY (hall_id) REFERENCES halls(id),
                          FOREIGN KEY (movie_id) REFERENCES movies(id)
);

CREATE TABLE customers (
                           id SERIAL PRIMARY KEY,
                           name VARCHAR(100),
                           email VARCHAR(100),
                           phone_number VARCHAR(20)
);

CREATE TABLE seats (
                       id SERIAL PRIMARY KEY,
                       hall_id INT,
                       row_number INT,
                       seat_number INT,
                       seat_type VARCHAR(50),
                       FOREIGN KEY (hall_id) REFERENCES halls(id)
);

CREATE TABLE tickets (
                         id SERIAL PRIMARY KEY,
                         session_id INT,
                         seat_id INT,
                         price DECIMAL(10, 2),
                         purchase_time TIMESTAMP,
                         customer_id INT,
                         FOREIGN KEY (session_id) REFERENCES sessions(id),
                         FOREIGN KEY (seat_id) REFERENCES seats(id),
                         FOREIGN KEY (customer_id) REFERENCES customers(id)
);