USE cinema;

CREATE TABLE IF NOT EXISTS cinema
(
    id       INT PRIMARY KEY AUTO_INCREMENT,
    name     VARCHAR(50)  NOT NULL,
    location VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS hall
(
    id       INT PRIMARY KEY AUTO_INCREMENT,
    cinemaID INT         NOT NULL,
    name     VARCHAR(50) NOT NULL,
    capacity INT         NOT NULL,
    FOREIGN KEY (cinemaID) REFERENCES cinema (id)
);

CREATE TABLE IF NOT EXISTS movie
(
    id       INT PRIMARY KEY AUTO_INCREMENT,
    title    VARCHAR(50) NOT NULL,
    duration INT         NOT NULL,
    genre    VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS showtime
(
    id        INT PRIMARY KEY AUTO_INCREMENT,
    hallID    INT            NOT NULL,
    movieID   INT            NOT NULL,
    startTime DATETIME       NOT NULL,
    price     DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (hallID) REFERENCES hall (id),
    FOREIGN KEY (movieID) REFERENCES movie (id)
);

CREATE TABLE IF NOT EXISTS seat
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    hallID     INT NOT NULL,
    rowNumber  INT NOT NULL,
    seatNumber INT NOT NULL,
    FOREIGN KEY (hallID) REFERENCES hall (id)
);

CREATE TABLE IF NOT EXISTS customer
(
    id    INT PRIMARY KEY AUTO_INCREMENT,
    name  VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(15)
);

CREATE TABLE IF NOT EXISTS ticket
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    customerID INT NOT NULL,
    showtimeID INT NOT NULL,
    seatID     INT NOT NULL,
    FOREIGN KEY (customerID) REFERENCES customer (id),
    FOREIGN KEY (showtimeID) REFERENCES showtime (id),
    FOREIGN KEY (seatID) REFERENCES seat (id)
);

INSERT INTO cinema(name, location)
VALUES ('CinemaHall', 'Warsaw, 03-111'),
       ('Multikino', 'Warsaw, 03-222');

INSERT INTO hall(cinemaID, name, capacity)
VALUES (1, 'first', 100),
       (1, 'second', 200);

INSERT INTO movie(title, duration, genre)
VALUES ('Hellboy', 120, 'Action'),
       ('Harry Potter', 100, 'Fantasy'),
       ('Groundhog', 150, 'Comedy');

INSERT INTO showtime(hallID, movieID, startTime, price)
VALUES (1, 1, '2025-01-05 14:30:00', 10),
       (2, 2, '2025-01-05 14:30:00', 15),
       (1, 3, '2025-01-05 17:00:00', 20),
       (2, 1, '2025-01-05 10:30:00', 5),
       (2, 2, '2025-01-05 14:30:00', 7),
       (1, 3, '2025-01-05 10:00:00', 12);

INSERT INTO seat(hallID, rowNumber, seatNumber)
VALUES (1, 1, 1),
       (1, 2, 1),
       (2, 1, 1),
       (2, 1, 2);

INSERT INTO customer(name, email, phone)
VALUES ('Igor', 'igor@gmail.com', '123456789'),
       ('Max', 'max@gmail.com', '512513525'),
       ('Liza', 'liza@gmail.com', '947329274'),
       ('Matvei', 'matvei@gmail.com', '957636271'),
       ('Alex', 'alex@gmail.com', '395736252'),
       ('Magda', 'magda@gmail.com', '595736352');

INSERT INTO ticket(customerID, showtimeID, seatID)
VALUES (1, 1, 1),
       (2, 2, 2),
       (3, 3, 3),
       (4, 4, 1),
       (5, 5, 2),
       (6, 6, 3);

SELECT m.title,
       SUM(s.price) total_revenue
FROM ticket t
         JOIN showtime s ON t.showtimeID = s.id
         JOIN movie m ON s.movieID = m.id
GROUP BY m.title
ORDER BY total_revenue DESC
LIMIT 1;