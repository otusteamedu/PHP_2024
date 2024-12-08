DROP TABLE IF EXISTS `cinemas`;
DROP TABLE IF EXISTS `cinema_halls`;
DROP TABLE IF EXISTS `movies`;
DROP TABLE IF EXISTS `shows`;
DROP TABLE IF EXISTS `seats`;
DROP TABLE IF EXISTS `tickets`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `purchases`;
DROP TABLE IF EXISTS `purchase_tickets`;


CREATE TABLE IF NOT EXISTS `cinemas` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `title` varchar(255) NOT NULL,
    `location` text NOT NULL,
    `contacts` text NOT NULL,
    PRIMARY KEY (`id`)
    );

CREATE TABLE IF NOT EXISTS `cinema_halls` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `cinema_id` int NOT NULL,
    `title` varchar(255) NOT NULL,
    `capacity` int NOT NULL,
    `type` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`cinema_id`) REFERENCES `cinemas`(`id`)
    );

CREATE TABLE IF NOT EXISTS `movies` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `title` varchar(255) NOT NULL,
    `genre` varchar(255),
    `duration` int,
    `release_date` date,
    `description` text,
    PRIMARY KEY (`id`)
    );

CREATE TABLE IF NOT EXISTS `shows` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `cinema_hall_id` int NOT NULL,
    `movie_id` int,
    `start` datetime NOT NULL,
    `end` datetime NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`cinema_hall_id`) REFERENCES `cinema_halls`(`id`),
    FOREIGN KEY (`movie_id`) REFERENCES `movies`(`id`)
    );

CREATE TABLE IF NOT EXISTS `seats` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `show_id` int NOT NULL,
    `row` int NOT NULL,
    `seat` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`show_id`) REFERENCES `shows`(`id`),
    UNIQUE (`show_id`, `row`, `seat`)
    );

CREATE TABLE IF NOT EXISTS `customers` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `name` varchar(255) NULL,
    PRIMARY KEY (`id`)
    );

CREATE TABLE IF NOT EXISTS `purchases` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `purchase_date` datetime NOT NULL,
    `customer_id` int NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`)
    );

CREATE TABLE IF NOT EXISTS `tickets` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `show_id` int NOT NULL,
    `seat_id` int NOT NULL,
    `price` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`show_id`) REFERENCES `shows`(`id`),
    FOREIGN KEY (`seat_id`) REFERENCES `seats`(`id`),
    UNIQUE (`show_id`, `seat_id`)
    );

CREATE TABLE IF NOT EXISTS `purchase_tickets` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `purchase_id` int NOT NULL,
    `ticket_id` int NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`purchase_id`) REFERENCES `purchases`(`id`),
    FOREIGN KEY (`ticket_id`) REFERENCES `tickets`(`id`),
    UNIQUE (`purchase_id`, `ticket_id`)
    );
