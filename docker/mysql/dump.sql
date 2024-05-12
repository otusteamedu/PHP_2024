-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 11 2024 г., 18:28
-- Версия сервера: 8.0.36-0ubuntu0.22.04.1
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb3 */;

--
-- База данных: `organization`
--
CREATE DATABASE IF NOT EXISTS `organization` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `organization`;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `age` int NOT NULL,
  `job` varchar(255) NOT NULL,
  `department_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Очистить таблицу перед добавлением данных `users`
--

TRUNCATE TABLE `users`;
--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `age`, `job`, `department_id`) VALUES
(1, 'Иван', 24, 'Водитель', 1),
(2, 'Петр', 55, 'Кладовщик', 2),
(3, 'Сергей', 34, 'Директор', 1),
(4, 'Илья', 44, 'Бухгалтер', 1),
(5, 'Елена', 33, 'Менеджер', 3),
(6, 'Семен', 45, 'Повар', 2);



--
-- Структура таблицы `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
                                            `id` int NOT NULL AUTO_INCREMENT,
                                            `name` varchar(255) NOT NULL,
                                            PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Очистить таблицу перед добавлением данных `department`
--

TRUNCATE TABLE `department`;
--
-- Дамп данных таблицы `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
                                            (1, 'главный офис'),
                                            (2, 'бек-офис'),
                                            (3, 'фронт-офис');

-- --------------------------------------------------------
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=utf8 */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
