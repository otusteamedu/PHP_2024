-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 25, 2019 at 02:14 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineShop`
--

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
  `id` int(255) NOT NULL,
  `name_product` varchar(255) NOT NULL,
  `img_dir` varchar(255) DEFAULT NULL,
  `description_short` varchar(255) NOT NULL,
  `price_product` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`id`, `name_product`, `img_dir`, `description_short`, `price_product`) VALUES
(4, ' snickers      ', 'image5.jpeg', 'Легкие и удобные. Отлично подходят для бега', '345'),
(6, 'black sandales', 'image7.jpg', 'blablablablablablablablablablabbalab', '500'),
(7, 'black high heals shoes', 'image6.jpeg', 'blablablablablablablablablablabbalab', '500'),
(8, 'yellow shoes', 'image8.jpeg', 'blablablablablablablablablablabbalab', '500'),
(10, 'red shoes', 'image2.jpeg', 'Очень элегантные туфли из натуральной замши', '1233'),
(11, 'crazy shoes ', 'image1.jpeg', 'Удивят всех', '344');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(255) NOT NULL DEFAULT '15',
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Создан'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `phone`, `email`, `status`) VALUES
(132, 49, '500 SW 177th Ave', '89818394345', 'stasya0903@mail.ru', 'Создан'),
(133, 56, 'user2', 'user2', 'stasya0903@mail.ru', 'Создан'),
(134, 57, '500 SW 177th Ave', '8888888', 'stasya0903@mail.ru', 'Создан'),
(135, 60, '500 SW 177th Ave', '89818394345', 'stasya0903@mail.ru', 'Создан');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `order_id` int(255) NOT NULL,
  `user_id` int(100) NOT NULL DEFAULT '123',
  `count` int(255) NOT NULL,
  `goods_id` int(155) NOT NULL,
  `price_product` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`order_id`, `user_id`, `count`, `goods_id`, `price_product`) VALUES
(132, 49, 1, 4, 345),
(132, 49, 1, 6, 500),
(132, 49, 1, 7, 500),
(133, 56, 1, 4, 345),
(133, 56, 1, 6, 500),
(133, 56, 1, 7, 500),
(134, 57, 1, 8, 500),
(134, 57, 1, 10, 1233),
(134, 57, 1, 11, 344),
(135, 60, 1, 4, 345),
(135, 60, 1, 6, 500),
(135, 60, 1, 7, 500);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT '123',
  `role` int(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `role`) VALUES
(44, 'Anastasia', 'admin', '$2y$10$mEXMF11iSFE3ha9LYJXpC.UCQVP2CVzDkJ.vgVMLYE7KxqRQqrpS2', 1),
(49, 'Пользователь1', 'user1', '$2y$10$o3mWpLz1oGHOZ08SDr2khO9ACWrgPifozofQ0cOCZUV9UOLAkRfFW', 0),
(56, 'Пользователь2', 'user2', '$2y$10$lgwx6iiFeI8DEObS7IfvmOy9PCx1nE4F.6LnpE1K0VUa0Ky1x4jb.', 0),
(57, 'Пользователь3', 'user3', '$2y$10$fogjNaW4tZIuCcjxBLcLv.w2wNMFlaYd9aQqOBM3fdP3B07BWpJFq', 0),
(60, 'Пользователь4', 'user4', '$2y$10$BUc9BbZ6koikU9yguxESxeUmarpRFJLFw3llFee7/TnI1XlY/Xkia', 0),
(65, 'Пользователь5', 'user5', '$2y$10$ZiwhN2S2.2zrBF9ufAIbzu/uI1EMVWdd2AIecnVEUfuAYm7uxjSAC', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`order_id`,`goods_id`) USING BTREE,
  ADD KEY `FKforGoods` (`goods_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `FKforGoods` FOREIGN KEY (`goods_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
