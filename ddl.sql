DROP TABLE IF EXISTS `first_name`;
CREATE TABLE `first_name` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `name` VARCHAR(255),
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `second_name`;
CREATE TABLE `second_name` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `name` VARCHAR(255),
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `gender` ENUM('none', 'male', 'female') DEFAULT 'none',
    `first_name_id` INT,
    `second_name_id` INT,
    `phone` VARCHAR(30),
    `email` VARCHAR(100),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`first_name_id`) REFERENCES `first_name` (`id`),
    FOREIGN KEY (`second_name_id`) REFERENCES `second_name` (`id`)
);

DROP TABLE IF EXISTS `films`;
CREATE TABLE `films` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `name` VARCHAR(255),
    `type` VARCHAR(50),
    `price` DECIMAL(10, 2),
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `halls`;
CREATE TABLE `halls` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `name` VARCHAR(50),
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `hall_rows`;
CREATE TABLE `hall_rows` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `row` INT,
    `places` INT,
    `hall_id` INT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`)
);

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `hall_id` INT,
    `film_id` INT,
    `start_time` DATETIME,
    `end_time` DATETIME,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`),
    FOREIGN KEY (`film_id`) REFERENCES `films` (`id`)
);

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `session_id` INT,
    `client_id` INT,
    `place` INT,
    `row` INT,
    `status` ENUM('not_paid', 'paid', 'canceled') DEFAULT 'not_paid',
    `final_price` DECIMAL(10,2),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`),
    FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
);