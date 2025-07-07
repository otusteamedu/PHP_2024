-- -----------------------------------------------------
-- Table `rooms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rooms`
(
    `id`       INT         NOT NULL AUTO_INCREMENT,
    `name`     VARCHAR(45) NOT NULL,
    `capacity` INT         NOT NULL,
    PRIMARY KEY (`id`)
) CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS users
(
    `id`         INT          NOT NULL AUTO_INCREMENT,
    `email`      VARCHAR(100) NOT NULL,
    `phone`      VARCHAR(20)  NOT NULL,
    `last_name`  VARCHAR(100) NOT NULL,
    `first_name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `email_UNIQUE` (`email` ASC),
    UNIQUE INDEX `phone_UNIQUE` (`phone` ASC)
) CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `films`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `films`
(
    `id`           INT          NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(255) NOT NULL,
    `description`  TEXT         NOT NULL,
    `release_date` DATE         NOT NULL,
    `timing`       INT          NOT NULL,
    PRIMARY KEY (`id`)
) CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sessions`
(
    `id`       INT      NOT NULL AUTO_INCREMENT,
    `datetime` DATETIME NOT NULL,
    `price`    INT      NOT NULL,
    `film_id`  INT      NOT NULL,
    `room_id`  INT      NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `film_if_idx` (`film_id` ASC),
    INDEX `room_id_idx` (`room_id` ASC),
    CONSTRAINT `fk_sessions_film_id`
        FOREIGN KEY (`film_id`)
            REFERENCES `films` (`id`)
            ON DELETE CASCADE,
    CONSTRAINT `fk_sessions_room_id`
        FOREIGN KEY (`room_id`)
            REFERENCES `rooms` (`id`)
            ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `seats`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seats`
(
    `id`      INT NOT NULL AUTO_INCREMENT,
    `room_id` INT NOT NULL,
    `row`     INT NOT NULL,
    `number`  INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `room_id_idx` (`room_id` ASC),
    CONSTRAINT `fk_seats_room_id`
        FOREIGN KEY (`room_id`)
            REFERENCES `rooms` (`id`)
            ON DELETE CASCADE
);

ALTER TABLE `seats`
    ADD CONSTRAINT `seat_UNIQUE` UNIQUE (`room_id`, `row`, `number`);

-- -----------------------------------------------------
-- Table `orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders`
(
    `id`         INT NOT NULL AUTO_INCREMENT,
    `user_id`    INT NOT NULL,
    `session_id` INT NOT NULL,
    `seat_id`    INT NOT NULL,
    `price`      INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_id_idx` (`user_id` ASC),
    INDEX `seat_id_idx` (`seat_id` ASC),
    INDEX `session_id_idx` (`session_id` ASC),
    CONSTRAINT `fk_orders_user_id`
        FOREIGN KEY (`user_id`)
            REFERENCES `users` (`id`)
            ON DELETE CASCADE,
    CONSTRAINT `fk_orders_seat_id`
        FOREIGN KEY (`seat_id`)
            REFERENCES `seats` (`id`),
    CONSTRAINT `fk_orders_session_id`
        FOREIGN KEY (`session_id`)
            REFERENCES `sessions` (`id`),
    CONSTRAINT `order_UNIQUE` UNIQUE (`session_id`, `seat_id`)
);
