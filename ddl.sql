CREATE TABLE cinemas
(
    id      INT PRIMARY KEY AUTO_INCREMENT,
    name    VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL
);

CREATE TABLE halls
(
    id        INT PRIMARY KEY AUTO_INCREMENT,
    cinema_id INT          NOT NULL,
    name      VARCHAR(255) NOT NULL,
    capacity  INT          NOT NULL,
    FOREIGN KEY (cinema_id) REFERENCES cinemas (id)
);

CREATE TABLE customers
(
    id    INT PRIMARY KEY AUTO_INCREMENT,
    name  VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE genres
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE movies
(
    id           INT PRIMARY KEY AUTO_INCREMENT,
    title        VARCHAR(255) NOT NULL,
    duration     INT          NOT NULL,
    rating       VARCHAR(10)  NOT NULL,
    genre_id     INT          NOT NULL,
    release_date DATE         NOT NULL,
    description  TEXT,
    FOREIGN KEY (genre_id) REFERENCES genres (id),
);

CREATE TABLE sessions
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    hall_id    INT      NOT NULL,
    start_time DATETIME NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id),
);

CREATE TABLE movie_sessions
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    session_id INT            NOT NULL,
    movie_id   INT            NOT NULL,
    price      DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (session_id) REFERENCES sessions (id),
    FOREIGN KEY (movie_id) REFERENCES movies (id),
);

CREATE TABLE tickets
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT         NOT NULL,
    session_id  INT         NOT NULL,
    seat        VARCHAR(10) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers (id),
    FOREIGN KEY (session_id) REFERENCES sessions (id),
);
