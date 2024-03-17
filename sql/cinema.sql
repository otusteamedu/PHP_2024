CREATE TABLE `movie` (
  `movie_id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text,
  `rating` tinyint,
  `running_time` integer
);

CREATE TABLE `movie_genre` (
  `movie_id` integer,
  `genre_id` integer,
  PRIMARY KEY(movie_id, genre_id)
);

CREATE TABLE `genre` (
  `genre_id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

CREATE TABLE `movie_director` (
  `movie_id` integer,
  `director_id` integer,
  PRIMARY KEY(movie_id, director_id)
);

CREATE TABLE `director` (
  `director_id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `surname` varchar(255)
);

CREATE TABLE `cinema_hall` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

CREATE TABLE `seats` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `cinema_hall_id` integer,
  `row_number` integer NOT NULL,
  `seat_number` integer NOT NULL
);

CREATE TABLE `visitor` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(255) UNIQUE
);

CREATE TABLE `session` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `movie_id` integer NOT NULL,
  `cinema_hall_id` integer,
  `date` datetime NOT NULL
);

CREATE TABLE `ticket` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `session_id` integer NOT NULL,
  `seat_id` integer,
  `price` decimal(8,4) NOT NULL,
  `purchase_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `visitor_id` integer
);

ALTER TABLE `movie_genre` ADD FOREIGN KEY (`movie_id`) REFERENCES `movie` (`movie_id`);

ALTER TABLE `movie_genre` ADD FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`);

ALTER TABLE `movie_director` ADD FOREIGN KEY (`director_id`) REFERENCES `director` (`director_id`);

ALTER TABLE `movie_director` ADD FOREIGN KEY (`movie_id`) REFERENCES `movie` (`movie_id`);

ALTER TABLE `session` ADD FOREIGN KEY (`movie_id`) REFERENCES `movie` (`movie_id`);

ALTER TABLE `session` ADD FOREIGN KEY (`cinema_hall_id`) REFERENCES `cinema_hall` (`id`);

ALTER TABLE `ticket` ADD FOREIGN KEY (`visitor_id`) REFERENCES `visitor` (`id`);

ALTER TABLE `ticket` ADD FOREIGN KEY (`session_id`) REFERENCES `session` (`id`);

ALTER TABLE `seats` ADD FOREIGN KEY (`cinema_hall_id`) REFERENCES `cinema_hall` (`id`);

ALTER TABLE `ticket` ADD FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`);
