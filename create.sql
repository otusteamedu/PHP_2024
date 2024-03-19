-- -----------------------------------------------------
-- Schema cinema
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cinema` DEFAULT CHARACTER SET utf8;
USE
`cinema` ;

-- -----------------------------------------------------
-- Table `cinema`.`halls`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cinema`.`halls`
(
    `id`
    INT
    NOT
    NULL
    AUTO_INCREMENT,
    `hall_name`
    VARCHAR
(
    45
) NOT NULL,
    `number_of_seats` INT NOT NULL,
    `is_premium` TINYINT NULL DEFAULT 0,
    PRIMARY KEY
(
    `id`
));


-- -----------------------------------------------------
-- Table `cinema`.`movies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cinema`.`movies`
(
    `id`
    INT
    NOT
    NULL
    AUTO_INCREMENT,
    `title`
    VARCHAR
(
    150
) NOT NULL,
    `description` TEXT NULL,
    `age_limit` VARCHAR
(
    45
) NULL,
    `language` VARCHAR
(
    45
) NULL,
    `genre` VARCHAR
(
    45
) NULL,
    `country` VARCHAR
(
    45
) NULL,
    `premiere_date` DATE NULL,
    `movie_duration` INT NULL,
    PRIMARY KEY
(
    `id`
));


-- -----------------------------------------------------
-- Table `cinema`.`seats`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cinema`.`seats`
(
    `id`
    INT
    NOT
    NULL
    AUTO_INCREMENT,
    `row`
    INT
    NOT
    NULL,
    `col`
    INT
    NOT
    NULL,
    `hall_id`
    INT
    NOT
    NULL,
    PRIMARY
    KEY
(
    `id`
),
    CONSTRAINT `fk_halls_seats`
    FOREIGN KEY
(
    `hall_id`
)
    REFERENCES `cinema`.`halls`
(
    `id`
));


-- -----------------------------------------------------
-- Table `cinema`.`movies_sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cinema`.`movies_sessions`
(
    `id`
    INT
    NOT
    NULL
    AUTO_INCREMENT,
    `halls_id`
    INT
    NOT
    NULL,
    `movie_id`
    INT
    NULL,
    `start_time`
    DATETIME
    NULL,
    `end_time`
    DATETIME
    NULL,
    PRIMARY
    KEY
(
    `id`
),
    INDEX `fk_halls_session_idx`
(
    `halls_id` ASC
) VISIBLE,
    INDEX `fk_movies_session_idx`
(
    `movie_id` ASC
) VISIBLE,
    UNIQUE INDEX `unq_session`
(
    `halls_id`
    ASC,
    `movie_id`
    ASC,
    `start_time`
    ASC
) VISIBLE,
    CONSTRAINT `fk_halls_session`
    FOREIGN KEY
(
    `halls_id`
)
    REFERENCES `cinema`.`halls`
(
    `id`
),
    CONSTRAINT `fk_movies_session`
    FOREIGN KEY
(
    `movie_id`
)
    REFERENCES `cinema`.`movies`
(
    `id`
));

-- -----------------------------------------------------
-- Table `cinema`.`price_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cinema`.`price_category`
(
    `id`
    INT
    NOT
    NULL
    AUTO_INCREMENT,
    `price`
    DECIMAL
(
    6,
    2
) NOT NULL,
    `status` TINYINT NOT NULL DEFAULT 1,
    PRIMARY KEY
(
    `id`
));


-- -----------------------------------------------------
-- Table `cinema`.`tickets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cinema`.`tickets`
(
    `id`
    INT
    NOT
    NULL
    AUTO_INCREMENT,
    `number`
    VARCHAR
(
    50
) NOT NULL,
    `seat_id` INT NOT NULL,
    `session_id` INT NOT NULL,
    `price` DECIMAL
(
    6,
    2
) NOT NULL
    `status` TINYINT NOT NULL DEFAULT 0,
    `date_of_purchase` DATETIME NULL,
    PRIMARY KEY
(
    `id`
),
    INDEX `fk_tickets_session_idx`
(
    `session_id` ASC
) VISIBLE,
    INDEX `fk_tickets_price_category_idx`
(
    `price_category_id` ASC
) VISIBLE,
    INDEX `fk_tickets_seats_idx`
(
    `seat_id` ASC
) VISIBLE,
    CONSTRAINT `fk_tickets_session`
    FOREIGN KEY
(
    `session_id`
)
    REFERENCES `cinema`.`movies_sessions`
(
    `id`
),
    CONSTRAINT `fk_tickets_price_category`
    FOREIGN KEY
(
    `price_category_id`
)
    REFERENCES `cinema`.`price_category`
(
    `id`
),
    CONSTRAINT `fk_tickets_seats`
    FOREIGN KEY
(
    `seat_id`
)
    REFERENCES `cinema`.`seats`
(
    `id`
));
