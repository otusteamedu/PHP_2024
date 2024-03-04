-- MySQL Script generated by MySQL Workbench
-- Пн 04 мар 2024 08:56:57
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Rental_companies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Rental_companies` (
  `company_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE INDEX `company_id_UNIQUE` (`company_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Films`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Films` (
  `film_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `duration` VARCHAR(45) NULL,
  `genre` VARCHAR(45) NULL,
  `manufacturer` VARCHAR(45) NOT NULL,
  `director` VARCHAR(45) NULL,
  `description` VARCHAR(255) NULL,
  `rental_company` INT NOT NULL,
  `age_limits` INT NOT NULL,
  `actors` VARCHAR(255) NULL,
  `film_links` TEXT(4096) NULL,
  `start_rental_at` DATETIME NULL,
  `end_rental_at` DATETIME NULL,
  PRIMARY KEY (`film_id`),
  INDEX `fk_Films_1_idx` (`rental_company` ASC) VISIBLE,
  CONSTRAINT `fk_Films_1`
    FOREIGN KEY (`rental_company`)
    REFERENCES `mydb`.`Rental_companies` (`company_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Cinema_halls`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Cinema_halls` (
  `hall_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `effects` VARCHAR(45) NULL,
  `seats_count` INT NOT NULL,
  PRIMARY KEY (`hall_id`),
  UNIQUE INDEX `hall_id_UNIQUE` (`hall_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Scheme_halls`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Scheme_halls` (
  `scheme_id` INT NOT NULL AUTO_INCREMENT,
  `hall_id` INT NOT NULL,
  `series` INT NOT NULL,
  `seat` INT NOT NULL,
  `status` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`scheme_id`),
  UNIQUE INDEX `scheme_id_UNIQUE` (`scheme_id` ASC) VISIBLE,
  INDEX `hall_id_index` USING BTREE (`hall_id`) VISIBLE,
  CONSTRAINT `fk_Scheme_halls_1`
    FOREIGN KEY (`hall_id`)
    REFERENCES `mydb`.`Cinema_halls` (`hall_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Cinema_sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Cinema_sessions` (
  `session_id` INT NOT NULL AUTO_INCREMENT,
  `session_start_at` DATETIME NULL,
  `session_end_at` DATETIME NULL,
  `film_id` INT NOT NULL,
  `cinema_hall_id` INT NOT NULL,
  PRIMARY KEY (`session_id`),
  UNIQUE INDEX `session_id_UNIQUE` (`session_id` ASC) VISIBLE,
  INDEX `hall_id_index` USING BTREE (`cinema_hall_id`) VISIBLE,
  INDEX `film_id_index` (`film_id` ASC) VISIBLE,
  CONSTRAINT `fk_Cinema_sessions_1`
    FOREIGN KEY (`film_id`)
    REFERENCES `mydb`.`Films` (`film_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Cinema_sessions_2`
    FOREIGN KEY (`cinema_hall_id`)
    REFERENCES `mydb`.`Cinema_halls` (`hall_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Prices`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Prices` (
  `price_id` INT NOT NULL AUTO_INCREMENT,
  `film_id` INT NOT NULL,
  `base_price` DECIMAL(6,2) NOT NULL,
  `night_price` DECIMAL(6,2) NULL,
  `day_price` DECIMAL(6,2) NULL,
  PRIMARY KEY (`price_id`),
  UNIQUE INDEX `price_id_UNIQUE` (`price_id` ASC) VISIBLE,
  INDEX `fk_Prices_1_idx` (`film_id` ASC) VISIBLE,
  CONSTRAINT `fk_Prices_1`
    FOREIGN KEY (`film_id`)
    REFERENCES `mydb`.`Films` (`film_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Tikets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Tikets` (
  `tiket_id` INT NOT NULL AUTO_INCREMENT,
  `session_id` INT NOT NULL,
  `price` DECIMAL(6,2) NULL,
  PRIMARY KEY (`tiket_id`),
  UNIQUE INDEX `tiket_id_UNIQUE` (`tiket_id` ASC) VISIBLE,
  INDEX `fk_Tikets_1_idx` (`session_id` ASC) VISIBLE,
  CONSTRAINT `fk_Tikets_1`
    FOREIGN KEY (`session_id`)
    REFERENCES `mydb`.`Cinema_sessions` (`session_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
