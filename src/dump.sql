INSERT INTO `cinemas` (`title`, `location`, `contacts`)
VALUES ('Movie Theater 1', 'Location 1', 'Contacts 1'),
       ('Movie Theater 2', 'Location 2', 'Contacts 2');

INSERT INTO `cinema_halls` (`cinema_id`, `title`, `capacity`, `type`)
VALUES (1, 'Movie Theater Hall 1.1', 100, 1),
       (1, 'Movie Theater Hall 1.2', 150, 2),
       (2, 'Movie Theater Hall 2.1', 200, 1);

INSERT INTO `movies` (`title`, `genre`, `duration`, `release_date`, `description`)
VALUES ('Oppenheimer', 'Genre 1', 120, '2020-01-01', 'Description 1'),
       ('Killers of the Flower Moon', 'Genre 2', 150, '2021-02-02', 'Description 2');

INSERT INTO `shows` (`cinema_hall_id`, `movie_id`, `start`, `end`)
VALUES (1, 1, '2023-04-01 10:00:00', '2023-04-01 12:30:00'),
       (2, 2, '2023-04-01 15:00:00', '2023-04-01 17:30:00'),
       (3, 1, '2023-04-01 14:00:00', '2023-04-01 16:30:00');

INSERT INTO `seats` (`show_id`, `row`, `seat`)
VALUES (1, 1, 1),
       (1, 1, 2),
       (1, 2, 1),
       (1, 2, 2),
       (2, 1, 1),
       (2, 1, 2),
       (2, 2, 1),
       (2, 2, 2);

INSERT INTO `tickets` (`show_id`, `seat_id`, `price`)
VALUES (1, 1, 300),
       (1, 2, 400),
       (1, 3, 500),
       (1, 4, 600),
       (2, 1, 700),
       (2, 2, 900),
       (2, 3, 1000),
       (2, 4, 1500),
       (3, 1, 400),
       (3, 2, 500),
       (3, 3, 700);


INSERT INTO `customers` (`name`)
VALUES ('Customer 1'),
       ('Customer 2');

INSERT INTO `purchases` (`purchase_date`, `customer_id`)
VALUES ('2023-04-01 10:00:00', 1),
       ('2023-04-01 15:00:00', 2);

INSERT INTO `purchase_tickets` (`purchase_id`, `ticket_id`)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4),
       (2, 5),
       (2, 6),
       (2, 7),
       (2, 8);