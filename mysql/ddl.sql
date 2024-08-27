CREATE TABLE `halls` (
     `id` INT(10) NOT NULL AUTO_INCREMENT,
     `name` VARCHAR(128) NOT NULL DEFAULT '' COLLATE 'utf8mb4_0900_ai_ci',
     PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `films` (
     `id` INT(10) NOT NULL AUTO_INCREMENT,
     `name` VARCHAR(128) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
     `duration` INT(10) NOT NULL DEFAULT '0',
     PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `sessions_films` (
      `id` INT(10) NOT NULL AUTO_INCREMENT,
      `hall_id` INT(10) NULL DEFAULT NULL,
      `film_id` INT(10) NULL DEFAULT NULL,
      `date_start` DATETIME NULL DEFAULT NULL,
      PRIMARY KEY (`id`) USING BTREE,
      INDEX `FK__halls` (`hall_id`) USING BTREE,
      INDEX `FK__films` (`film_id`) USING BTREE,
      CONSTRAINT `FK__films` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
      CONSTRAINT `FK__halls` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `hall_seats` (
      `id` INT(10) NOT NULL AUTO_INCREMENT,
      `hall_id` INT(10) NOT NULL DEFAULT '0',
      `row` INT(10) NOT NULL DEFAULT '0',
      `col` INT(10) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`) USING BTREE,
      INDEX `FK__halls_seats` (`hall_id`) USING BTREE,
      CONSTRAINT `FK__halls_seats` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `users` (
     `id` INT(10) NOT NULL AUTO_INCREMENT,
     `name` VARCHAR(128) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
     PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `prices` (
      `id` INT(10) NOT NULL AUTO_INCREMENT,
      `seat_id` INT(10) NOT NULL,
      `session_id` INT(10) NOT NULL,
      `price` INT(10) NOT NULL,
      PRIMARY KEY (`id`) USING BTREE,
      INDEX `FK__hall_seats` (`seat_id`) USING BTREE,
      INDEX `FK__hall_session` (`session_id`) USING BTREE,
      CONSTRAINT `FK__hall_seats` FOREIGN KEY (`seat_id`) REFERENCES `hall_seats` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
      CONSTRAINT `FK__hall_session` FOREIGN KEY (`session_id`) REFERENCES `sessions_films` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `tickets` (
       `id` INT(10) NOT NULL AUTO_INCREMENT,
       `price_id` INT(10) NULL DEFAULT NULL,
       `user_id` INT(10) NULL DEFAULT NULL,
       PRIMARY KEY (`id`) USING BTREE,
       INDEX `FK__price` (`price_id`) USING BTREE,
       INDEX `FK__users` (`user_id`) USING BTREE,
       CONSTRAINT `FK__price` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
       CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;





