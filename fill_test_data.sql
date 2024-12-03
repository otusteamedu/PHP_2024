INSERT INTO `halls` (`id`, `name`)
VALUES (1, 'Зал1'),
       (2, 'Зал2');

INSERT INTO `movies` (`id`, `title`, `year`)
VALUES (1, 'Терминатор 2', 1991),
       (2, 'Титаник', 1997),
       (3, 'Аватар', 2009);

INSERT INTO `places` (`id`, `row`, `seat`)
VALUES (1, 1, 1),
       (2, 1, 2),
       (3, 1, 3),
       (4, 2, 1),
       (5, 2, 2),
       (6, 2, 3),
       (7, 3, 1),
       (8, 3, 2),
       (9, 3, 3);

INSERT INTO `sessions` (`id`, `start_time`, `hall_id`, `movie_id`)
VALUES (1, '2024-12-02 10:00:00', 1, 1),
       (2, '2024-12-02 12:00:00', 2, 2),
       (3, '2024-12-02 14:00:00', 1, 3);

INSERT INTO `tickets` (`id`, `session_id`, `place_id`, `price`)
VALUES (1, 1, 1, 100.00),
       (2, 1, 2, 200.00),
       (3, 1, 3, 200.00),
       (4, 1, 4, 200.00),
       (5, 2, 4, 200.00),
       (6, 2, 1, 200.00),
       (7, 2, 2, 200.00),
       (8, 2, 3, 200.00),
       (9, 3, 1, 200.00),
       (10, 3, 2, 200.00),
       (11, 3, 3, 200.00),
       (12, 3, 4, 200.00);

INSERT INTO `clients` (`id`, `name`, `phone`)
VALUES (1, 'Иванов Петр Иванович', '79111111111');

INSERT INTO `orders` (`id`, `client_id`, `total`)
VALUES (1, 1, 1000.00);

INSERT INTO `order_tickets` (`id`, `order_id`, `ticket_id`, `price`)
VALUES (1, 1, 1, 200),
       (2, 1, 2, 200),
       (3, 1, 3, 200),
       (4, 1, 3, 200),
       (5, 1, 11, 200);

