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
    id                  INT PRIMARY KEY AUTO_INCREMENT,
    title               VARCHAR(255) NOT NULL,
    duration            INT NOT NULL, -- продолжительность в минутах
    description         VARCHAR(255)
    production_country  VARCHAR(100)
    director            VARCHAR(100)
    release_date        INT
);

-- Таблица жанров фильма
CREATE TABLE IF NOT EXISTS genre
(
    id      INT PRIMARY KEY AUTO_INCREMENT,
    name    VARCHAR(255) NOT NULL
);

-- Связующая таблица, которая связывает фильмы с жанрами
CREATE TABLE movie_genre (
    movie_id INT,
    genre_id INT,
    PRIMARY KEY (movie_id, genre_id),
    FOREIGN KEY (movie_id) REFERENCES movie(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genre(id) ON DELETE CASCADE
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
    id              INT PRIMARY KEY AUTO_INCREMENT,
    hall_id         INT,
    seat_type_id    INT,
    row_number      INT NOT NULL,
    seat_number     INT NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES hall (id)
    FOREIGN KEY (seat_type_id) REFERENCES seat_type (id)
);

-- Таблица типов мест
CREATE TABLE IF NOT EXISTS seat_type
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(50) NOT NULL
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
