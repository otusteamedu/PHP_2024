-- Drop tables if they exist
DROP TABLE IF EXISTS `ticket_purchase`;
DROP TABLE IF EXISTS `purchase`;
DROP TABLE IF EXISTS `ticket`;
DROP TABLE IF EXISTS `seat`;
DROP TABLE IF EXISTS `seat_type`;
DROP TABLE IF EXISTS `showtime`;
DROP TABLE IF EXISTS `film`;
DROP TABLE IF EXISTS `screen`;
DROP TABLE IF EXISTS `screen_type`;
DROP TABLE IF EXISTS `employer`;
DROP TABLE IF EXISTS `customer`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `cinema`;


CREATE TABLE IF NOT EXISTS `cinema` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`title` varchar(255) NOT NULL,
	`location` text NOT NULL,
	`contacts` text NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `screen_type` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`type` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `screen` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`cinema_id` int NOT NULL,
	`title` varchar(255) NOT NULL,
	`capacity` int NOT NULL,
	`type` int NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`cinema_id`) REFERENCES `cinema`(`id`),
    FOREIGN KEY (`type`) REFERENCES `screen_type`(`id`)
);

CREATE TABLE IF NOT EXISTS `film` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`title` varchar(255) NOT NULL,
	`genre` varchar(255),
	`duration` int,
	`release_date` date,
	`description` text,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `showtime` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`screen_id` int NOT NULL,
	`film_id` int,
	`start` datetime NOT NULL,
	`end` datetime NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`screen_id`) REFERENCES `screen`(`id`),
    FOREIGN KEY (`film_id`) REFERENCES `film`(`id`)
);

CREATE TABLE IF NOT EXISTS `seat_type` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`type` text NOT NULL,
	`price_factor` decimal(10,0) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `seat` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`screen_id` int NOT NULL,
	`block` varchar(255) NULL,
	`row_number` varchar(255) NOT NULL,
	`seat_number` varchar(255) NOT NULL,
	`seat_type` int NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`screen_id`) REFERENCES `screen`(`id`),
    FOREIGN KEY (`seat_type`) REFERENCES `seat_type`(`id`),
    UNIQUE (`screen_id`, `block`, `row_number`, `seat_number`)
);

CREATE TABLE IF NOT EXISTS `ticket` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`showtime_id` int NOT NULL,
	`seat_id` int NOT NULL,
	`price` decimal(10,0) NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`showtime_id`) REFERENCES `showtime`(`id`),
    FOREIGN KEY (`seat_id`) REFERENCES `seat`(`id`),
    UNIQUE (`showtime_id`, `seat_id`)
);

CREATE TABLE IF NOT EXISTS `user` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`name` varchar(255) NOT NULL,
	`lastname` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `customer` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`user_id` int NOT NULL UNIQUE,
	`bonuses` decimal(10,0) NOT NULL,
	`membership_status` int NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
);

CREATE TABLE IF NOT EXISTS `employer` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`user_id` int NOT NULL,
	`position_id` int NOT NULL,
	`cinema_id` int NOT NULL,
	`salary` decimal(10,0) NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`),
    FOREIGN KEY (`cinema_id`) REFERENCES `cinema`(`id`),
    UNIQUE (`user_id`, `position_id`, `cinema_id`)
);

CREATE TABLE IF NOT EXISTS `purchase` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`purchase_date` datetime NOT NULL,
	`price` decimal(10,0) NOT NULL,
	`bonuses` decimal(10,0) NOT NULL,
	`customer_id` int NULL,
	`employer_id` int NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`customer_id`) REFERENCES `customer`(`id`),
    FOREIGN KEY (`employer_id`) REFERENCES `employer`(`id`)
);

CREATE TABLE IF NOT EXISTS `ticket_purchase` (
	`purchase_id` int NOT NULL,
	`ticket_id` int NOT NULL,
	PRIMARY KEY (`purchase_id`, `ticket_id`),
    FOREIGN KEY (`purchase_id`) REFERENCES `purchase`(`id`),
    FOREIGN KEY (`ticket_id`) REFERENCES `ticket`(`id`)
);

