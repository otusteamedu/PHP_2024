CREATE TABLE `movies` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `showBeginDate` timestamp,
  `showEndDate` timestamp,
  `description` text,
  `countryId` integer,
  `creationDate` datetime
);

CREATE TABLE `movieGenre` (
  `movieId` integer,
  `genreId` integer
);

CREATE TABLE `Genres` (
  `id` integer PRIMARY KEY,
  `name` varchar(255)
);

CREATE TABLE `session` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `movieId` integer,
  `time` datetime
);

CREATE TABLE `users` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `firstName` varchar(255),
  `lastName` varchar(255),
  `createdAt` timestamp
);

CREATE TABLE `orders` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `userId` integer,
  `created_at` timestamp,
  `totalAmount` decimal(15,2)
);

CREATE TABLE `orderDetails` (
  `id` integer PRIMARY KEY,
  `priceId` integer,
  `movieId` integer,
  `amount` decimal(15,2)
);

CREATE TABLE `hall` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `rowsAmount` integer
);

CREATE TABLE `rowsSeats` (
  `id` integer PRIMARY KEY,
  `hallId` integer,
  `rowNumber` integer,
  `seatsAmount` integer
);

CREATE TABLE `prices` (
  `id` integer PRIMARY KEY,
  `sessionId` integer,
  `amount` decimal(15,2),
  `rowId` integer,
  `seatId` integer
);

ALTER TABLE `movieGenre` ADD FOREIGN KEY (`genreId`) REFERENCES `Genres` (`id`);

ALTER TABLE `orders` ADD FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

ALTER TABLE `movieGenre` ADD FOREIGN KEY (`movieId`) REFERENCES `movies` (`id`);

ALTER TABLE `orderDetails` ADD FOREIGN KEY (`priceId`) REFERENCES `prices` (`id`);

ALTER TABLE `orderDetails` ADD FOREIGN KEY (`movieId`) REFERENCES `movies` (`id`);

ALTER TABLE `prices` ADD FOREIGN KEY (`rowId`) REFERENCES `rowsSeats` (`rowNumber`);

ALTER TABLE `prices` ADD FOREIGN KEY (`sessionId`) REFERENCES `session` (`id`);

ALTER TABLE `rowsSeats` ADD FOREIGN KEY (`hallId`) REFERENCES `hall` (`id`);

ALTER TABLE `orderDetails` ADD FOREIGN KEY (`id`) REFERENCES `orders` (`id`);

ALTER TABLE `session` ADD FOREIGN KEY (`id`) REFERENCES `movies` (`id`);
