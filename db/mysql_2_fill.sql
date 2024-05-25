-- Insert data into cinema table
INSERT INTO `cinema` (`title`, `location`, `contacts`) VALUES
('Central Cinema', '123 Main St, Springfield', 'contact@centralcinema.com, 555-1234'),
('Downtown Cinema', '456 Elm St, Metropolis', 'info@downtowncinema.com, 555-5678');

-- Insert data into screen_type table
INSERT INTO `screen_type` (`type`, `price_factor`) VALUES
('IMAX', 1.6),
('3D', 1.5),
('Standard', 1);

-- Insert data into screen table
INSERT INTO `screen` (`cinema_id`, `title`, `capacity`, `type`) VALUES
(1, 'Screen 1', 200, 1),
(1, 'Screen 2', 150, 2),
(2, 'Screen A', 100, 3);

-- Insert data into film table
INSERT INTO `film` (`title`, `genre`, `duration`, `release_date`, `description`, `price`) VALUES
('Avengers: Endgame', 'Action', 181, '2019-04-26', 'The Avengers take a final stand against Thanos.', 15),
('Inception', 'Sci-Fi', 148, '2010-07-16', 'A thief who steals corporate secrets through dream-sharing technology.', 15),
('The Lion King', 'Animation', 88, '1994-06-24', 'A young lion prince flees his kingdom after the murder of his father.', 17),
('Titanic', 'Romance', 195, '1997-12-19', 'A young couple’s romance blossoms during the ill-fated maiden voyage of the RMS Titanic.', 20),
('Jurassic Park', 'Adventure', 127, '1993-06-11', 'During a preview tour, a theme park suffers a major power breakdown that allows its cloned dinosaur exhibits to run amok.', 10);

-- Insert data into showtime table
INSERT INTO `showtime` (`screen_id`, `film_id`, `start`, `end`, `price_factor`) VALUES
-- Screen 1 Showtimes
(1, 1, '2024-05-18 14:00:00', '2024-05-18 17:01:00', 1),
(1, 2, '2024-05-18 18:00:00', '2024-05-18 20:28:00', 1.2),
(1, 3, '2024-05-19 12:00:00', '2024-05-19 13:28:00', 0.9),
(1, 4, '2024-05-19 14:00:00', '2024-05-19 17:15:00', 1),
(1, 5, '2024-05-19 18:00:00', '2024-05-19 20:07:00', 1.2),

-- Screen 2 Showtimes
(2, 1, '2024-05-18 12:00:00', '2024-05-18 15:01:00', 1),
(2, 2, '2024-05-18 16:00:00', '2024-05-18 18:28:00', 1),
(2, 3, '2024-05-19 12:00:00', '2024-05-19 13:28:00', 0.9),
(2, 4, '2024-05-19 14:00:00', '2024-05-19 17:15:00', 1),
(2, 5, '2024-05-19 18:00:00', '2024-05-19 20:07:00', 1.2),

-- Screen A Showtimes
(3, 1, '2024-05-18 13:00:00', '2024-05-18 16:01:00', 1),
(3, 2, '2024-05-18 17:00:00', '2024-05-18 19:28:00', 1),
(3, 3, '2024-05-19 13:00:00', '2024-05-19 14:28:00', 1),
(3, 4, '2024-05-19 15:00:00', '2024-05-19 18:15:00', 1),
(3, 5, '2024-05-19 19:00:00', '2024-05-19 21:07:00', 1.2);

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

-- Insert data into ticket table
-- DELETE FROM ticket;
DROP PROCEDURE IF EXISTS GenerateTicketPurchases;

CREATE PROCEDURE GenerateTicketPurchases()
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE purchase_id INT DEFAULT 1;
    DECLARE total_purchases INT DEFAULT 6;

    DECLARE showtime_id INT DEFAULT 1;
    DECLARE total_showtimes INT DEFAULT 15;
    DECLARE BOUGHT BOOL DEFAULT true;

    DECLARE seat_id INT DEFAULT 1;
    DECLARE
        film_price,
        screen_price_factor,
        showtime_price_factor,
        seat_price_factor DECIMAL DEFAULT 1
    ;
    DECLARE done INT DEFAULT FALSE;

    SET total_purchases = (SELECT COUNT(*) FROM purchase);
    SET total_showtimes = (SELECT COUNT(*) FROM showtime);

    WHILE showtime_id <= total_showtimes DO
        SEAT_BLOCK: BEGIN
            DECLARE cur1 CURSOR FOR
                SELECT seat.id,
                       film.price,
                       screen_type.price_factor,
                       showtime.price_factor,
                       seat_type.price_factor
                FROM seat
                     INNER JOIN screen ON screen.id = seat.screen_id
                     INNER JOIN showtime ON showtime.screen_id = seat.screen_id
                     INNER JOIN film ON film.id = showtime.film_id
                     LEFT JOIN seat_type ON seat_type.id = seat.seat_type
                     LEFT JOIN screen_type ON screen.type = screen_type.id
                WHERE showtime.id = showtime_id
                ORDER BY seat.id
            ;
            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = true;

            OPEN cur1;
            REPEAT
                FETCH cur1 INTO seat_id, film_price, screen_price_factor, showtime_price_factor, seat_price_factor;
                SET BOUGHT = RAND() * 3 > 1;

                IF BOUGHT AND NOT done THEN
                    SET purchase_id = (i - 1) % total_purchases + 1;
                    SET i = i + 1;
                    INSERT INTO `ticket` (`purchase_id`, `showtime_id`, `seat_id`, `price`)
                    VALUES (
                            purchase_id,
                            showtime_id,
                            seat_id,
                            ROUND(
                                film_price
                                    * screen_price_factor
                                    * showtime_price_factor
                                    * seat_price_factor
                                ,
                                2
                            )
                        )
                    ;
                END IF;
            UNTIL done END REPEAT;
            CLOSE cur1;
        END SEAT_BLOCK;
        SET showtime_id = showtime_id + 1;
        SET done = FALSE;
    END WHILE;
END;

CALL GenerateTicketPurchases();
