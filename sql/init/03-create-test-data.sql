-- Inserting data into attribute_types
INSERT INTO attribute_types (type_name) VALUES
('Task'),
('Genre'),
('Actor'),
('Director'),
('Rating'),
('Award');

-- Inserting data into attributes
INSERT INTO attributes (name, attribute_type_id) VALUES
('Planning meeting', 1),
('Marketing approval', 1),
('Final edit', 1),
('Sci-Fi', 2),
('Comedy', 2),
('Drama', 2),
('Action', 2),
('Lead actor', 3),
('Supporting actor', 3),
('Director name', 4),
('IMDB rating', 5),
('Oscar nomination', 6);

-- Inserting data into film
INSERT INTO film (title, duration, genre, rating, release_date) VALUES
('Interstellar', 169, 'Sci-Fi', 8.6, '2014-11-07'),
('The Shawshank Redemption', 142, 'Drama', 9.3, '1994-10-14'),
('The Dark Knight', 152, 'Action', 9.0, '2008-07-18'),
('Pulp Fiction', 154, 'Crime', 8.9, '1994-10-14'),
('Inception', 148, 'Sci-Fi', 8.8, '2010-07-16');

-- Inserting data into attribute_values with various value types
INSERT INTO attribute_values (movie_id, attribute_id, value_text, value_date, value_image, value_bool, value_int, value_float) VALUES
-- Tasks for today and 20 days in future
(1, 1, 'Plan marketing campaign', CURRENT_DATE, NULL, NULL, NULL, NULL),
(1, 2, 'Approve trailer', CURRENT_DATE + INTERVAL '20 days', NULL, NULL, NULL, NULL),
(2, 3, 'Final cut review', CURRENT_DATE, NULL, NULL, NULL, NULL),
(3, 1, 'Schedule press conference', CURRENT_DATE, NULL, NULL, NULL, NULL),
(3, 2, 'Media kit preparation', CURRENT_DATE + INTERVAL '20 days', NULL, NULL, NULL, NULL),
(4, 3, 'Sound editing', CURRENT_DATE + INTERVAL '20 days', NULL, NULL, NULL, NULL),
-- Genre attributes
(1, 4, 'Space exploration theme', NULL, NULL, NULL, NULL, NULL),
(2, 6, 'Prison drama', NULL, NULL, NULL, NULL, NULL),
(3, 7, 'Superhero thriller', NULL, NULL, NULL, NULL, NULL),
(4, 5, 'Dark comedy elements', NULL, NULL, NULL, NULL, NULL),
(5, 4, 'Dream concepts', NULL, NULL, NULL, NULL, NULL),
-- Actor attributes
(1, 8, 'Matthew McConaughey', NULL, NULL, NULL, NULL, NULL),
(2, 8, 'Tim Robbins', NULL, NULL, NULL, NULL, NULL),
(3, 8, 'Christian Bale', NULL, NULL, NULL, NULL, NULL),
(4, 8, 'John Travolta', NULL, NULL, NULL, NULL, NULL),
(5, 8, 'Leonardo DiCaprio', NULL, NULL, NULL, NULL, NULL),
-- Director attributes
(1, 10, 'Christopher Nolan', NULL, NULL, NULL, NULL, NULL),
(2, 10, 'Frank Darabont', NULL, NULL, NULL, NULL, NULL),
(3, 10, 'Christopher Nolan', NULL, NULL, NULL, NULL, NULL),
(4, 10, 'Quentin Tarantino', NULL, NULL, NULL, NULL, NULL),
(5, 10, 'Christopher Nolan', NULL, NULL, NULL, NULL, NULL),
-- Ratings
(1, 11, NULL, NULL, NULL, NULL, NULL, 8.6),
(2, 11, NULL, NULL, NULL, NULL, NULL, 9.3),
(3, 11, NULL, NULL, NULL, NULL, NULL, 9.0),
(4, 11, NULL, NULL, NULL, NULL, NULL, 8.9),
(5, 11, NULL, NULL, NULL, NULL, NULL, 8.8),
-- Awards
(1, 12, NULL, NULL, NULL, TRUE, NULL, NULL),
(2, 12, NULL, NULL, NULL, TRUE, NULL, NULL),
(3, 12, NULL, NULL, NULL, TRUE, NULL, NULL);

-- Inserting data into cinema
INSERT INTO cinema (name, location) VALUES
('Cineplex', 'Downtown'),
('Starlight Cinema', 'West End'),
('Movie Paradise', 'Suburb');

-- Inserting data into hall
INSERT INTO hall (cinema_id, hall_number, capacity) VALUES
(1, 1, 120),
(1, 2, 80),
(2, 1, 150),
(3, 1, 100),
(3, 2, 90);

-- Inserting data into zone
INSERT INTO zone (hall_id, zone_name, price) VALUES
(1, 'VIP', 15.00),
(1, 'Standard', 10.00),
(2, 'Standard', 10.00),
(3, 'VIP', 18.00),
(3, 'Standard', 12.00),
(4, 'Standard', 9.00),
(5, 'Standard', 9.00);

-- Inserting data into session
INSERT INTO session (hall_id, film_id, start_time) VALUES
(1, 1, '2023-07-01 18:00:00'),
(1, 2, '2023-07-01 21:00:00'),
(2, 3, '2023-07-01 19:00:00'),
(3, 4, '2023-07-01 20:00:00'),
(4, 5, '2023-07-01 17:30:00'),
(5, 1, '2023-07-01 18:30:00');

-- Inserting data into customer
INSERT INTO customer (name, email) VALUES
('John Smith', 'john@example.com'),
('Anna Johnson', 'anna@example.com'),
('Robert Williams', 'robert@example.com'),
('Emily Davis', 'emily@example.com'),
('Michael Brown', 'michael@example.com');

-- Inserting data into ticket
INSERT INTO ticket (session_id, zone_id, row, seat_number, customer_id, price, purchase_time) VALUES
(1, 1, 1, 'A1', 1, 15.00, '2023-06-25 10:15:00'),
(1, 1, 1, 'A2', 1, 15.00, '2023-06-25 10:15:00'),
(2, 2, 3, 'C5', 2, 10.00, '2023-06-26 14:20:00'),
(3, 3, 5, 'E8', 3, 10.00, '2023-06-27 16:45:00'),
(4, 4, 2, 'B3', 4, 18.00, '2023-06-28 09:30:00'),
(5, 6, 7, 'G10', 5, 9.00, '2023-06-29 20:10:00'),
(6, 7, 4, 'D6', 5, 9.00, '2023-06-29 20:15:00');