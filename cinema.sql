/* Зал кинотеатра */
CREATE TABLE `halls` (
  `id` integer PRIMARY KEY,
  `title` varchar(255),
  `description` text
);

/* Фильм */
CREATE TABLE `movies` (
  `id` integer PRIMARY KEY,
  `title` varchar(255),
  `description` text
);

/* Сеанс */
CREATE TABLE `sessions` (
  `id` integer PRIMARY KEY,
  `start_datetime` datetime,
  `end_datetime` datetime,
  `base_price` decimal(10,2),
  `movie_id` integer,
  `hall_id` integer
);

/* Место */
CREATE TABLE `seats` (
  `id` integer PRIMARY KEY,
  `row` integer,
  `column` integer
);

/* Места в зале */
CREATE TABLE `hall_seats` (
  `id` integer PRIMARY KEY,
  `hall_id` integer,
  `seat_id` integer,
  `seat_type_id` integer
);

/* Тип места */
CREATE TABLE `seat_types` (
  `id` integer PRIMARY KEY,
  `title` varchar(255),
  `price_multiplier` decimal(10,2)
);

/* Бронирование места */
CREATE TABLE `reservations` (
  `id` integer PRIMARY KEY,
  `session_id` integer,
  `hall_seat_id` integer,
  `is_reserved` tinyint DEFAULT 0
);

CREATE UNIQUE INDEX `unique_seat` ON `seats` (`row`, `column`);

ALTER TABLE `sessions` ADD FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`);

ALTER TABLE `sessions` ADD FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

ALTER TABLE `hall_seats` ADD FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`);

ALTER TABLE `hall_seats` ADD FOREIGN KEY (`seat_type_id`) REFERENCES `seat_types` (`id`);

ALTER TABLE `hall_seats` ADD FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`);

ALTER TABLE `reservations` ADD FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`);

ALTER TABLE `reservations` ADD FOREIGN KEY (`hall_seat_id`) REFERENCES `hall_seats` (`id`);
