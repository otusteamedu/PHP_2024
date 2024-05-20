-- Insert data into cinema table
INSERT INTO `cinema` (`title`, `location`, `contacts`) VALUES
('Central Cinema', '123 Main St, Springfield', 'contact@centralcinema.com, 555-1234'),
('Downtown Cinema', '456 Elm St, Metropolis', 'info@downtowncinema.com, 555-5678');

-- Insert data into screen_type table
INSERT INTO `screen_type` (`type`) VALUES
('IMAX'),
('3D'),
('Standard');

-- Insert data into screen table
INSERT INTO `screen` (`cinema_id`, `title`, `capacity`, `type`) VALUES
(1, 'Screen 1', 200, 1),
(1, 'Screen 2', 150, 2),
(2, 'Screen A', 100, 3);

-- Insert data into film table
INSERT INTO `film` (`title`, `genre`, `duration`, `release_date`, `description`) VALUES
('Avengers: Endgame', 'Action', 181, '2019-04-26', 'The Avengers take a final stand against Thanos.'),
('Inception', 'Sci-Fi', 148, '2010-07-16', 'A thief who steals corporate secrets through dream-sharing technology.'),
('The Lion King', 'Animation', 88, '1994-06-24', 'A young lion prince flees his kingdom after the murder of his father.'),
('Titanic', 'Romance', 195, '1997-12-19', 'A young couple’s romance blossoms during the ill-fated maiden voyage of the RMS Titanic.'),
('Jurassic Park', 'Adventure', 127, '1993-06-11', 'During a preview tour, a theme park suffers a major power breakdown that allows its cloned dinosaur exhibits to run amok.');

-- Insert data into showtime table
INSERT INTO `showtime` (`screen_id`, `film_id`, `start`, `end`) VALUES
-- Screen 1 Showtimes
(1, 1, '2024-05-18 14:00:00', '2024-05-18 17:01:00'),
(1, 2, '2024-05-18 18:00:00', '2024-05-18 20:28:00'),
(1, 3, '2024-05-19 12:00:00', '2024-05-19 13:28:00'),
(1, 4, '2024-05-19 14:00:00', '2024-05-19 17:15:00'),
(1, 5, '2024-05-19 18:00:00', '2024-05-19 20:07:00'),

-- Screen 2 Showtimes
(2, 1, '2024-05-18 12:00:00', '2024-05-18 15:01:00'),
(2, 2, '2024-05-18 16:00:00', '2024-05-18 18:28:00'),
(2, 3, '2024-05-19 12:00:00', '2024-05-19 13:28:00'),
(2, 4, '2024-05-19 14:00:00', '2024-05-19 17:15:00'),
(2, 5, '2024-05-19 18:00:00', '2024-05-19 20:07:00'),

-- Screen A Showtimes
(3, 1, '2024-05-18 13:00:00', '2024-05-18 16:01:00'),
(3, 2, '2024-05-18 17:00:00', '2024-05-18 19:28:00'),
(3, 3, '2024-05-19 13:00:00', '2024-05-19 14:28:00'),
(3, 4, '2024-05-19 15:00:00', '2024-05-19 18:15:00'),
(3, 5, '2024-05-19 19:00:00', '2024-05-19 21:07:00');

-- Insert data into seat_type table
INSERT INTO `seat_type` (`type`, `price_factor`) VALUES
('Regular', 1),
('VIP', 1.5),
('Premium', 2);

-- Insert data into seat table
INSERT INTO `seat` (`screen_id`, `block`, `row_number`, `seat_number`, `seat_type`) VALUES
-- Screen 1 Seats
(1, 'A', '1', '1', 1),
(1, 'A', '1', '2', 1),
(1, 'B', '2', '3', 2),
(1, 'B', '2', '4', 2),
(1, 'C', '3', '5', 3),
(1, 'C', '3', '6', 3),

-- Screen 2 Seats
(2, 'A', '1', '1', 1),
(2, 'A', '1', '2', 1),
(2, 'B', '2', '3', 2),
(2, 'B', '2', '4', 2),
(2, 'C', '3', '5', 3),
(2, 'C', '3', '6', 3),

-- Screen A Seats
(3, 'A', '1', '1', 1),
(3, 'A', '1', '2', 1),
(3, 'B', '2', '3', 2),
(3, 'B', '2', '4', 2),
(3, 'C', '3', '5', 3),
(3, 'C', '3', '6', 3);

-- Insert data into user table
INSERT INTO `user` (`name`, `lastname`) VALUES
('John', 'Doe'),
('Jane', 'Smith'),
('Alice', 'Johnson'),
('Bob', 'Brown'),
('Carol', 'White');

-- Insert data into customer table
INSERT INTO `customer` (`user_id`, `bonuses`, `membership_status`) VALUES
(1, 100, 1),
(2, 50, 2),
(3, 75, 1),
(4, 20, 3),
(5, 10, 2);

-- Insert data into employer table
INSERT INTO `employer` (`user_id`, `position_id`, `cinema_id`, `salary`) VALUES
(1, 1, 1, 50000),
(2, 2, 2, 45000),
(3, 3, 1, 40000),
(4, 4, 2, 42000),
(5, 5, 1, 39000);

-- Insert data into purchase table
INSERT INTO `purchase` (`purchase_date`, `price`, `bonuses`, `customer_id`, `employer_id`) VALUES
('2024-05-18 13:00:00', 20, 10, 1, 1),
('2024-05-18 13:30:00', 30, 5, 2, 2),
('2024-05-19 14:00:00', 25, 5, 3, 3),
('2024-05-19 14:30:00', 35, 10, 4, 4),
('2024-05-19 15:00:00', 40, 15, 5, 5),
('2024-05-15 15:30:00', 40, 15, null, 5),
('2024-05-16 14:00:00', 40, 15, 3, 5)
;

DROP PROCEDURE IF EXISTS GenerateTickets;
DELIMITER //
CREATE PROCEDURE GenerateTickets()
BEGIN
    DECLARE showtime_id INT DEFAULT 1;
    DECLARE seat_id INT DEFAULT 1;
    DECLARE total_showtimes INT DEFAULT 15;
    DECLARE total_seats INT DEFAULT 18;

    WHILE showtime_id <= total_showtimes
    DO
        SET seat_id = 1;
        WHILE seat_id <= total_seats
        DO
            INSERT INTO `ticket` (`showtime_id`, `seat_id`, `price`)
            VALUES (showtime_id, seat_id, ROUND(RAND() * 15 + 10, 2));
            SET seat_id = seat_id + 1;
        END WHILE;

        SET showtime_id = showtime_id + 1;
    END WHILE;
END//
CALL GenerateTickets();

DROP PROCEDURE IF EXISTS GenerateTicketPurchases;
DELIMITER //
CREATE PROCEDURE GenerateTicketPurchases()
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE purchase_id INT DEFAULT 1;
    DECLARE max_tickets INT DEFAULT 1;
    DECLARE total_purchases INT DEFAULT 6;

    SET max_tickets = (SELECT COUNT(*) FROM ticket);
    SET total_purchases = (SELECT COUNT(*) FROM purchase);

    WHILE i <= max_tickets DO
        SET purchase_id = (i - 1) % total_purchases + 1;
        INSERT INTO `ticket_purchase` (`purchase_id`, `ticket_id`) 
        VALUES (purchase_id, i);
        SET i = i + 1;
    END WHILE;
END//
CALL GenerateTicketPurchases();
