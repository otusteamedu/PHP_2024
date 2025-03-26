-- 1. Таблица для кинотеатров
CREATE TABLE cinema
(
    id   SERIAL PRIMARY KEY,   -- Уникальный идентификатор кинотеатра
    name VARCHAR(255) NOT NULL -- Название кинотеатра
);

-- 2. Таблица для залов
CREATE TABLE hall
(
    id        SERIAL PRIMARY KEY,                         -- Уникальный идентификатор зала
    cinema_id INT          NOT NULL,                      -- Внешний ключ на кинотеатр
    name      VARCHAR(100) NOT NULL,                      -- Название зала
    capacity  INT          NOT NULL CHECK (capacity > 0), -- Вместимость зала
    CONSTRAINT fk_hall_cinema FOREIGN KEY (cinema_id) REFERENCES cinema (id) ON DELETE CASCADE
);

-- 3. Таблица для мест
CREATE TABLE seat
(
    id          SERIAL PRIMARY KEY,           -- Уникальный идентификатор места
    hall_id     INT NOT NULL,                 -- Внешний ключ на зал
    row_number  INT NOT NULL,                 -- Номер ряда
    seat_number INT NOT NULL,                 -- Номер места в ряду
    CONSTRAINT fk_seat_hall FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE,
    UNIQUE (hall_id, row_number, seat_number) -- Уникальность мест в рамках одного зала
);

-- 4. Таблица для фильмов
CREATE TABLE movie
(
    id           SERIAL PRIMARY KEY,                         -- Уникальный идентификатор фильма
    title        VARCHAR(255) NOT NULL,                      -- Название фильма
    duration     INT          NOT NULL CHECK (duration > 0), -- Длительность (в минутах)
    release_date DATE         NOT NULL                       -- Дата выхода фильма
);

-- 5. Таблица для расписания (сеансов)
CREATE TABLE schedule
(
    id        SERIAL PRIMARY KEY, -- Уникальный идентификатор сеанса
    hall_id   INT       NOT NULL, -- Внешний ключ на зал
    movie_id  INT       NOT NULL, -- Внешний ключ на фильм
    show_time TIMESTAMP NOT NULL, -- Время начала сеанса
    CONSTRAINT fk_schedule_hall FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE,
    CONSTRAINT fk_schedule_movie FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE
);

-- 6. Таблица для клиентов
CREATE TABLE customer
(
    id    SERIAL PRIMARY KEY,           -- Уникальный идентификатор клиента
    name  VARCHAR(255)        NOT NULL, -- Имя клиента
    email VARCHAR(255) UNIQUE NOT NULL, -- Уникальный email
    phone VARCHAR(20)                   -- Телефон клиента
);

-- 7. Таблица для цен на сеанс
CREATE TABLE price_list
(
    id          SERIAL PRIMARY KEY,                         -- Уникальный идентификатор цены
    seat_id     INT            NOT NULL,
    schedule_id INT            NOT NULL,
    price       NUMERIC(10, 2) NOT NULL CHECK (price >= 0), -- Стоимость билета
    CONSTRAINT fk_ticket_schedule FOREIGN KEY (schedule_id) REFERENCES schedule (id) ON DELETE CASCADE,
    CONSTRAINT fk_ticket_seat FOREIGN KEY (seat_id) REFERENCES seat (id) ON DELETE CASCADE,
    UNIQUE (schedule_id, seat_id)                           -- У каждого место/сеанса может быть только одна цена
);

-- 8. Таблица для билетов
CREATE TABLE ticket
(
    id            SERIAL PRIMARY KEY,                  -- Уникальный идентификатор билета
    price_list_id INT NOT NULL,
    customer_id   INT NOT NULL,                        -- Внешний ключ на клиента
    purchased_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Дата и время покупки
    CONSTRAINT fk_ticket_price_list FOREIGN KEY (price_list_id) REFERENCES price_list (id),
    CONSTRAINT fk_ticket_customer FOREIGN KEY (customer_id) REFERENCES customer (id),
    UNIQUE (price_list_id, customer_id)                      -- У билета может быть один владелец
);

INSERT INTO cinema (name)
VALUES ('Кинотеатр Анапа');

INSERT INTO hall (cinema_id, name, capacity)
VALUES (1, 'Зал 1', 100),
       (1, 'IMAX Зал', 200);

INSERT INTO movie (title, duration, release_date)
VALUES ('Фильм 1', 120, '2025-03-03'),
       ('Фильм 2', 95, '2025-03-03');

INSERT INTO schedule (hall_id, movie_id, show_time)
VALUES (1, 1, '2025-03-03 15:00:00'),
       (1, 2, '2025-03-03 18:00:00');

INSERT INTO seat (hall_id, row_number, seat_number)
VALUES (1, 1, 1),
       (1, 1, 2),
       (1, 1, 3),
       (1, 2, 1),
       (1, 2, 2),
       (1, 2, 3);

INSERT INTO price_list (seat_id, schedule_id, price)
VALUES (1, 1, 510),
       (1, 2, 600),
       (2, 1, 720),
       (2, 2, 600);

INSERT INTO customer (name, email, phone)
VALUES ('Иван Иванов', 'ivanov@example.com', '+79001234567');

INSERT INTO ticket (customer_id, price_list_id)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4);

SELECT m.id          AS movie_id,
       m.title       AS movie_title,
       SUM(pl.price) AS total_revenue
FROM ticket t
         JOIN
     price_list pl on t.price_list_id = pl.id
         JOIN
     schedule s ON pl.schedule_id = s.id
         JOIN
     movie m ON s.movie_id = m.id
GROUP BY m.id, m.title
ORDER BY total_revenue DESC
LIMIT 1;