-- Таблица для кинотеатров
CREATE TABLE cinema (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL
);

-- Таблица для залов
CREATE TABLE hall (
    id INT PRIMARY KEY,
    cinema_id INT,
    name VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    FOREIGN KEY (cinema_id) REFERENCES cinema(id)
);

-- Таблица для фильмов
CREATE TABLE movie (
    id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    duration TIME NOT NULL,
    genre VARCHAR(50),
    release_date DATE
);

-- Таблица для сеансов
CREATE TABLE screening (
    id INT PRIMARY KEY,
    hall_id INT,
    movie_id INT,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES hall(id),
    FOREIGN KEY (movie_id) REFERENCES movie(id)
);

-- Таблица для билетов
CREATE TABLE ticket (
    id INT PRIMARY KEY,
    screening_id INT,
    seat_number VARCHAR(10),
    purchase_time DATETIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (screening_id) REFERENCES screening(id)
);

-- Таблица для клиентов
CREATE TABLE customer (
    id INT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255)
);

-- Таблица для заказов
CREATE TABLE `order` (
    id INT PRIMARY KEY,
    customer_id INT,
    order_time DATETIME NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);

-- Таблица для деталей заказа
CREATE TABLE order_details (
    id INT PRIMARY KEY,
    order_id INT,
    ticket_id INT,
    FOREIGN KEY (order_id) REFERENCES `order`(id),
    FOREIGN KEY (ticket_id) REFERENCES ticket(id)
);