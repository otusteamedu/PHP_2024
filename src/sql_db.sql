DROP TABLE IF EXISTS `movies`;
DROP TABLE IF EXISTS `attribute_types`;
DROP TABLE IF EXISTS `attributes`;
DROP TABLE IF EXISTS `attribute_values`;


CREATE TABLE IF NOT EXISTS `movies` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `title` varchar(255) NOT NULL,
    `genre` varchar(255),
    `duration` int,
    `release_date` date,
    `description` text,
    PRIMARY KEY (`id`)
    );

CREATE TABLE IF NOT EXISTS `attribute_types` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `type` enum('text','date','time','bool','int','float') NOT NULL DEFAULT 'text',
    PRIMARY KEY (`id`)
    );

CREATE TABLE IF NOT EXISTS `attributes` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `name` varchar(255) NOT NULL,
    `movie_id` int NOT NULL,
    `attribute_type_id` int NOT NULL,
    `is_service` boolean DEFAULT false,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`movie_id`) REFERENCES `movies`(`id`),
    FOREIGN KEY (`attribute_type_id`) REFERENCES `attribute_types`(`id`)
    );

CREATE TABLE IF NOT EXISTS `attribute_values` (
    `id` int AUTO_INCREMENT NOT NULL UNIQUE,
    `attribute_id` int NOT NULL,
    `value_text` text,
    `value_date` date,
    `value_time` time,
    `value_bool` boolean,
    `value_int` int,
    `value_float` float,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`attribute_id`) REFERENCES `attributes`(`id`)
    );
