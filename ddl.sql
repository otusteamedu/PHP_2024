-- Таблица кинотеатров
CREATE TABLE IF NOT EXISTS cinema
(
    id       INT PRIMARY KEY AUTO_INCREMENT,
    name     VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL
);

-- Таблица залов
CREATE TABLE IF NOT EXISTS hall
(
    id        INT PRIMARY KEY AUTO_INCREMENT,
    cinema_id INT,
    name      VARCHAR(100) NOT NULL,
    capacity  INT          NOT NULL,
    FOREIGN KEY (cinema_id) REFERENCES cinema (id)
);

-- Таблица фильмов
CREATE TABLE IF NOT EXISTS movie
(
    id       INT PRIMARY KEY AUTO_INCREMENT,
    title    VARCHAR(255) NOT NULL,
    duration INT          NOT NULL, -- продолжительность в минутах
    genre    VARCHAR(100)
);

-- Таблица сеансов
CREATE TABLE IF NOT EXISTS showtime
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    hall_id    INT,
    movie_id   INT,
    start_time DATETIME       NOT NULL,
    end_time   DATETIME       NOT NULL,
    base_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES hall (id),
    FOREIGN KEY (movie_id) REFERENCES movie (id)
);

-- Таблица мест
CREATE TABLE IF NOT EXISTS seat
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    hall_id     INT,
    row_number  INT NOT NULL,
    seat_number INT NOT NULL,
    seat_type   VARCHAR(50),
    FOREIGN KEY (hall_id) REFERENCES hall (id)
);

-- Таблица билетов
CREATE TABLE IF NOT EXISTS ticket
(
    id                 INT PRIMARY KEY AUTO_INCREMENT,
    showtime_id        INT,
    seat_id            INT,
    price              DECIMAL(10, 2) NOT NULL,
    purchase_date_time DATETIME       NOT NULL,
    customer_name      VARCHAR(255),
    FOREIGN KEY (showtime_id) REFERENCES showtime (id),
    FOREIGN KEY (seat_id) REFERENCES seat (id)
);
