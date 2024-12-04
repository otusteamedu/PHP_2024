-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               11.5.2-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных cinema
CREATE DATABASE IF NOT EXISTS `cinema` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `cinema`;

-- Дамп структуры для таблица cinema.cinema_films
CREATE TABLE IF NOT EXISTS `cinema_films` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `num_stars` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `duration` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица cinema.cinema_halls
CREATE TABLE IF NOT EXISTS `cinema_halls` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `num_seats` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица cinema.cinema_prices
CREATE TABLE IF NOT EXISTS `cinema_prices` (
  `id_hall` int(5) unsigned NOT NULL,
  `begin_time` time DEFAULT NULL,
  `begin_num_seat` int(11) DEFAULT 0,
  `price` decimal(20,6) NOT NULL DEFAULT 0.000000,
  UNIQUE KEY `id_hall_begin_time_begin_num_seat` (`id_hall`,`begin_time`,`begin_num_seat`) USING BTREE,
  CONSTRAINT `cinema_prices_id_hall_foreign` FOREIGN KEY (`id_hall`) REFERENCES `cinema_halls` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица cinema.cinema_sessions
CREATE TABLE IF NOT EXISTS `cinema_sessions` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `id_hall` int(5) unsigned NOT NULL,
  `date` date NOT NULL,
  `begintime` time NOT NULL,
  `id_film` int(5) unsigned NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `cinema_sessions_id_hall_foreign` (`id_hall`) USING BTREE,
  KEY `cinema_sessions_id_film_foreign` (`id_film`) USING BTREE,
  CONSTRAINT `cinema_sessions_id_film_foreign` FOREIGN KEY (`id_film`) REFERENCES `cinema_films` (`id`),
  CONSTRAINT `cinema_sessions_id_hall_foreign` FOREIGN KEY (`id_hall`) REFERENCES `cinema_halls` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица cinema.cinema_tickets
CREATE TABLE IF NOT EXISTS `cinema_tickets` (
  `id_session` int(9) unsigned NOT NULL,
  `num_seat` int(11) NOT NULL,
  `price` decimal(20,6) NOT NULL DEFAULT 0.000000,
  UNIQUE KEY `id_session_num_seat` (`id_session`,`num_seat`) USING BTREE,
  CONSTRAINT `cinema_tickets_id_session_foreign` FOREIGN KEY (`id_session`) REFERENCES `cinema_sessions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица cinema.films_and_types
CREATE TABLE IF NOT EXISTS `films_and_types` (
  `id_film` int(5) unsigned NOT NULL,
  `id_type` int(5) unsigned NOT NULL,
  UNIQUE KEY `id_film_id_type` (`id_film`,`id_type`),
  KEY `id_film` (`id_film`),
  KEY `id_type` (`id_type`),
  CONSTRAINT `id_film_cinema_film` FOREIGN KEY (`id_film`) REFERENCES `cinema_films` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_type_film_type` FOREIGN KEY (`id_type`) REFERENCES `films_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица cinema.films_type
CREATE TABLE IF NOT EXISTS `films_type` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
