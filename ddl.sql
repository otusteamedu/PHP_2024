DROP DATABASE IF EXISTS `cinema_db`;

CREATE SCHEMA IF NOT EXISTS `cinema_db` DEFAULT CHARACTER SET utf8;
USE `cinema_db`;

CREATE TABLE IF NOT EXISTS `cinema_db`.`halls`
(
    `id`         INT         NOT NULL AUTO_INCREMENT,
    `title`      VARCHAR(45) NULL,
    `seat_count` INT         NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cinema_db`.`films`
(
    `id`          INT         NOT NULL AUTO_INCREMENT,
    `title`       VARCHAR(45) NULL,
    `rental_cost` FLOAT       NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cinema_db`.`sessions`
(
    `id`         INT  NOT NULL AUTO_INCREMENT,
    `start_time` TIME NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cinema_db`.`pivot_with_prices`
(
    `id`         INT   NOT NULL AUTO_INCREMENT,
    `hall_id`    INT   NULL,
    `film_id`    INT   NULL,
    `session_id` INT   NULL,
    `price`      FLOAT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (hall_id, film_id, session_id),
    INDEX `fk_pivot_films_idx` (`film_id` ASC) VISIBLE,
    INDEX `fk_pivot_halls_idx` (`hall_id` ASC) VISIBLE,
    INDEX `fk_session_idx` (`session_id` ASC) VISIBLE,
    CONSTRAINT `fk_pivot_films`
        FOREIGN KEY (`film_id`)
            REFERENCES `cinema_db`.`films` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
    CONSTRAINT `fk_pivot_halls`
        FOREIGN KEY (`hall_id`)
            REFERENCES `cinema_db`.`halls` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
    CONSTRAINT `fk_session`
        FOREIGN KEY (`session_id`)
            REFERENCES `cinema_db`.`sessions` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cinema_db`.`tickets`
(
    `id_pivot_with_prices` INT,
    `seat`                 INT,
    `session_date`         DATE,
    PRIMARY KEY (`id_pivot_with_prices`, `seat`, `session_date`),
    CONSTRAINT `fk_pivot_with_prices`
        FOREIGN KEY (`id_pivot_with_prices`)
            REFERENCES `cinema_db`.`pivot_with_prices` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB;