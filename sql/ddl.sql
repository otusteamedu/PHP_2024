CREATE TABLE `countries`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
CREATE TABLE `order_tickets`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ticket_id` BIGINT UNSIGNED NOT NULL,
    `order_id` BIGINT UNSIGNED NOT NULL,
    `price` DECIMAL(8, 2) NOT NULL,
    `discount` DECIMAL(8, 2) NOT NULL DEFAULT '0'
);
CREATE TABLE `films`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `duration` INT NOT NULL,
    `age_limit` INT UNSIGNED NOT NULL,
    `description` TEXT NOT NULL,
    `year_id` INT UNSIGNED NOT NULL
);
CREATE TABLE `age_limits`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
CREATE TABLE `tickets`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `seat_id` BIGINT UNSIGNED NOT NULL,
    `price` DECIMAL(8, 2) NOT NULL,
    `cinema_show_id` BIGINT UNSIGNED NOT NULL
);
CREATE TABLE `halls`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `capacity` INT NOT NULL
);
CREATE TABLE `seats`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `hall_id` BIGINT UNSIGNED NOT NULL,
    `row` INT NOT NULL,
    `place` INT NOT NULL,
    `seat_type` INT UNSIGNED NOT NULL
);
CREATE TABLE `years`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` INT NOT NULL
);
CREATE TABLE `users`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `login` VARCHAR(255) NOT NULL
);
CREATE TABLE `films_contries`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `film_id` BIGINT UNSIGNED NOT NULL,
    `country_id` INT UNSIGNED NOT NULL
);
CREATE TABLE `cinema_shows`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `hall_id` BIGINT UNSIGNED NOT NULL,
    `film_id` BIGINT UNSIGNED NOT NULL,
    `date` DATE NOT NULL,
    `start` TIME NOT NULL,
    `end` TIME NOT NULL
);
CREATE TABLE `orders`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `date_created` DATETIME NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL
);
CREATE TABLE `seats_type`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
CREATE TABLE `genres`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
CREATE TABLE `films_genres`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `film_id` BIGINT UNSIGNED NOT NULL,
    `genre_id` INT UNSIGNED NOT NULL
);
ALTER TABLE
    `cinema_shows` ADD CONSTRAINT `cinema_shows_film_id_foreign` FOREIGN KEY(`film_id`) REFERENCES `films`(`id`);
ALTER TABLE
    `films_genres` ADD CONSTRAINT `films_genres_genre_id_foreign` FOREIGN KEY(`genre_id`) REFERENCES `genres`(`id`);
ALTER TABLE
    `seats` ADD CONSTRAINT `seats_hall_id_foreign` FOREIGN KEY(`hall_id`) REFERENCES `halls`(`id`);
ALTER TABLE
    `order_tickets` ADD CONSTRAINT `order_tickets_order_id_foreign` FOREIGN KEY(`order_id`) REFERENCES `orders`(`id`);
ALTER TABLE
    `tickets` ADD CONSTRAINT `tickets_seat_id_foreign` FOREIGN KEY(`seat_id`) REFERENCES `seats`(`id`);
ALTER TABLE
    `order_tickets` ADD CONSTRAINT `order_tickets_ticket_id_foreign` FOREIGN KEY(`ticket_id`) REFERENCES `tickets`(`id`);
ALTER TABLE
    `films_contries` ADD CONSTRAINT `films_contries_country_id_foreign` FOREIGN KEY(`country_id`) REFERENCES `countries`(`id`);
ALTER TABLE
    `cinema_shows` ADD CONSTRAINT `cinema_shows_hall_id_foreign` FOREIGN KEY(`hall_id`) REFERENCES `halls`(`id`);
ALTER TABLE
    `films` ADD CONSTRAINT `films_age_limit_foreign` FOREIGN KEY(`age_limit`) REFERENCES `age_limits`(`id`);
ALTER TABLE
    `seats` ADD CONSTRAINT `seats_seat_type_foreign` FOREIGN KEY(`seat_type`) REFERENCES `seats_type`(`id`);
ALTER TABLE
    `films` ADD CONSTRAINT `films_year_id_foreign` FOREIGN KEY(`year_id`) REFERENCES `years`(`id`);
ALTER TABLE
    `films_contries` ADD CONSTRAINT `films_contries_film_id_foreign` FOREIGN KEY(`film_id`) REFERENCES `films`(`id`);
ALTER TABLE
    `tickets` ADD CONSTRAINT `tickets_cinema_show_id_foreign` FOREIGN KEY(`cinema_show_id`) REFERENCES `cinema_shows`(`id`);
ALTER TABLE
    `orders` ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`);
ALTER TABLE
    `films_genres` ADD CONSTRAINT `films_genres_film_id_foreign` FOREIGN KEY(`film_id`) REFERENCES `films`(`id`);