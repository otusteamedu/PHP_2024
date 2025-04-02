CREATE DATABASE IF NOT EXISTS `pattern_data_mapper`;
USE `pattern_data_mapper`;


CREATE TABLE IF NOT EXISTS `cars`
(
    `id`         int          NOT NULL AUTO_INCREMENT,
    `mark`       varchar(100) NOT NULL,
    `model`      varchar(100) NOT NULL,
    `vin`        VARCHAR(30)  NOT NULL,
    `pts_number` VARCHAR(30)  NOT NULL,
    `pts_date`   DATE         NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci
    COMMENT ='Автомобили';


CREATE TABLE `drivers`
(
    `id`             INT(10)      NOT NULL AUTO_INCREMENT,
    `car_id`         INT(10)      NOT NULL,
    `name`           VARCHAR(100) NOT NULL,
    `birth_date`     DATE         NOT NULL,
    `license_number` VARCHAR(10)  NOT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `FK_drivers_cars` (`car_id`) USING BTREE,
    CONSTRAINT `FK_drivers_cars` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
    COMMENT ='Водители'
    COLLATE = 'utf8mb4_0900_ai_ci'
    ENGINE = InnoDB
