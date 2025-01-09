-- Вставка данных в таблицу залов
INSERT INTO halls (name, capacity) VALUES
('Main Hall', 200),
('VIP Hall', 50),
('Standard Hall 1', 100),
('Standard Hall 2', 100),
('Standard Hall 3', 100);

-- Вставка данных в таблицу мест
INSERT INTO seats (hall_id, seat_number, row_number) VALUES
(1, 1, 1), (1, 2, 1), (1, 3, 1), (1, 4, 1), (1, 5, 1),
(2, 1, 1), (2, 2, 1), (2, 3, 1), (2, 4, 1), (2, 5, 1),
(3, 1, 1), (3, 2, 1), (3, 3, 1), (3, 4, 1), (3, 5, 1),
(4, 1, 1), (4, 2, 1), (4, 3, 1), (4, 4, 1), (4, 5, 1),
(5, 1, 1), (5, 2, 1), (5, 3, 1), (5, 4, 1), (5, 5, 1);

-- Вставка данных в таблицу фильмов
INSERT INTO movies (title, genre, duration, release_date) VALUES
('The Matrix', 'Sci-Fi', 136, '1999-03-31'),
('Pulp Fiction', 'Crime', 154, '1994-10-14'),
('Forrest Gump', 'Drama', 142, '1994-07-06'),
('The Shawshank Redemption', 'Drama', 142, '1994-09-23'),
('The Lord of the Rings: The Fellowship of the Ring', 'Fantasy', 178, '2001-12-19');

-- Вставка данных в таблицу сеансов
INSERT INTO sessions (movie_id, hall_id, start_time) VALUES
(1, 1, '2023-01-08 18:00:00'),
(2, 2, '2023-01-08 19:00:00'),
(3, 3, '2023-01-08 20:00:00'),
(4, 4, '2023-01-08 21:00:00'),
(5, 5, '2023-01-08 22:00:00'),
(1, 1, '2025-01-08 18:00:00'),
(2, 2, '2025-01-08 19:00:00'),
(3, 3, '2025-01-08 20:00:00'),
(4, 4, '2025-01-08 21:00:00'),
(5, 5, '2025-01-08 22:00:00');

-- Вставка данных в таблицу клиентов
INSERT INTO customers (first_name, last_name, email, phone) VALUES
('John', 'Doe', 'john.doe@example.com', '123-456-7890'),
('Jane', 'Smith', 'jane.smith@example.com', '098-765-4321'),
('Alice', 'Johnson', 'alice.johnson@example.com', '234-567-8901'),
('Bob', 'Brown', 'bob.brown@example.com', '345-678-9012'),
('Charlie', 'Davis', 'charlie.davis@example.com', '456-789-0123'),
('Diana', 'Miller', 'diana.miller@example.com', '567-890-1234'),
('Eve', 'Wilson', 'eve.wilson@example.com', '678-901-2345'),
('Frank', 'Moore', 'frank.moore@example.com', '789-012-3456'),
('Grace', 'Taylor', 'grace.taylor@example.com', '890-123-4567'),
('Hank', 'Anderson', 'hank.anderson@example.com', '901-234-5678');

-- Функция для генерации билетов
DO $$
DECLARE
    ticket_count INT := 1000; -- нужное количество билетов
    i INT;
BEGIN
    FOR i IN 1..ticket_count LOOP
        INSERT INTO tickets (session_id, seat_id, price)
        VALUES (
            (SELECT session_id FROM sessions ORDER BY RANDOM() LIMIT 1),
            (SELECT seat_id FROM seats ORDER BY RANDOM() LIMIT 1),
            ROUND(RANDOM() * 20 + 5, 2)
        );
    END LOOP;
END $$;