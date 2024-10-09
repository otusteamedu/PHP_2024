-- Insert random data into the Cinemas table
INSERT INTO Cinemas (name, location)
VALUES ('Cinema City', '123 Main St'),
       ('Grand Cinema', '456 Broadway Ave'),
       ('Movie Palace', '789 Oak St');

-- Insert random data into the Halls table
INSERT INTO Halls (cinema_id, name, seat_count)
VALUES (1, 'Hall 1', 150),
       (1, 'Hall 2', 200),
       (2, 'Grand Hall', 250),
       (3, 'Oak Hall', 180);

-- Insert random data into the Movies table
INSERT INTO Movies (title, duration, genre, release_date)
VALUES ('The Adventure', '02:15:00', 'Action', '2023-06-12'),
       ('Romantic Journey', '01:45:00', 'Romance', '2022-11-20'),
       ('Mystery Island', '02:05:00', 'Thriller', '2023-02-10');

-- Insert random data into the Sessions table
INSERT INTO Sessions (hall_id, movie_id, start_time, price)
VALUES (1, 1, '2024-10-09 15:00:00', 10.50),
       (2, 2, '2024-10-09 17:30:00', 12.00),
       (3, 3, '2024-10-09 20:00:00', 9.75);

-- Insert random data into the Seats table
INSERT INTO Seats (hall_id, row, seat_number)
VALUES (1, 1, 1),
       (1, 1, 2),
       (1, 1, 3),
       (2, 1, 1),
       (2, 1, 2),
       (2, 1, 3),
       (3, 1, 1),
       (3, 1, 2),
       (3, 1, 3);

-- Insert random data into the Tickets table
INSERT INTO Tickets (session_id, seat_id, customer_name, price)
VALUES (1, 1, 'John Doe', 10.50),
       (2, 2, 'Jane Smith', 12.00),
       (3, 3, 'Mike Johnson', 9.75);

-- Insert random data into the TicketSales table
INSERT INTO TicketSales (ticket_id, sale_time, total_amount)
VALUES (1, '2024-10-08 10:00:00', 10.50),
       (2, '2024-10-08 11:30:00', 12.00),
       (3, '2024-10-08 13:45:00', 9.75);
