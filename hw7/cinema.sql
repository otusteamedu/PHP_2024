CREATE TABLE `movies` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `beginDate` timestamp,
  `endDate` timestamp
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
  `created_at` timestamp
);

CREATE TABLE `orders` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `userId` integer,
  `created_at` timestamp,
  `totalAmount` float
);

CREATE TABLE `orderDetails` (
  `id` integer PRIMARY KEY,
  `priceId` integer
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
  `amount` float,
  `rowId` integer
);

ALTER TABLE `orders` ADD FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

ALTER TABLE `orderDetails` ADD FOREIGN KEY (`priceId`) REFERENCES `prices` (`id`);

ALTER TABLE `prices` ADD FOREIGN KEY (`rowId`) REFERENCES `rowsSeats` (`id`);

ALTER TABLE `prices` ADD FOREIGN KEY (`sessionId`) REFERENCES `session` (`id`);

ALTER TABLE `rowsSeats` ADD FOREIGN KEY (`hallId`) REFERENCES `hall` (`id`);

ALTER TABLE `orderDetails` ADD FOREIGN KEY (`id`) REFERENCES `orders` (`id`);

ALTER TABLE `session` ADD FOREIGN KEY (`id`) REFERENCES `movies` (`id`);
