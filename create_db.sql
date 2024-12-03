CREATE DATABASE IF NOT EXISTS `cinema`;
USE `cinema`;


CREATE TABLE IF NOT EXISTS `halls`
(
    `id`   int          NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci
  COMMENT ='Залы';


CREATE TABLE IF NOT EXISTS `movies`
(
    `id`    int          NOT NULL AUTO_INCREMENT,
    `title` varchar(100) NOT NULL DEFAULT '' COMMENT 'Название',
    `year`  smallint     NOT NULL DEFAULT (0) COMMENT 'Год выхода',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci
  COMMENT ='Фильмы';


CREATE TABLE IF NOT EXISTS `places`
(
    `id`   int NOT NULL AUTO_INCREMENT,
    `row`  int NOT NULL DEFAULT '0' COMMENT 'ряд',
    `seat` int NOT NULL DEFAULT '0' COMMENT 'место',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci
  COMMENT ='Места в зале';


CREATE TABLE IF NOT EXISTS `sessions`
(
    `id`         int      NOT NULL AUTO_INCREMENT,
    `start_time` datetime NOT NULL COMMENT 'начало сеанса',
    `hall_id`    int      NOT NULL DEFAULT (0),
    `movie_id`   int      NOT NULL DEFAULT (0),
    PRIMARY KEY (`id`),
    KEY `FK_sessions_halls` (`hall_id`),
    KEY `FK_sessions_movies` (`movie_id`),
    CONSTRAINT `FK_sessions_halls` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`),
    CONSTRAINT `FK_sessions_movies` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci
  COMMENT ='Сеансы';


CREATE TABLE IF NOT EXISTS `tickets`
(
    `id`         int            NOT NULL AUTO_INCREMENT,
    `session_id` int            NOT NULL COMMENT 'Сеанс',
    `place_id`   int            NOT NULL COMMENT 'Место',
    `price`      decimal(10, 2) NOT NULL DEFAULT (0) COMMENT 'Цена',
    PRIMARY KEY (`id`),
    KEY `FK_tickets_sessions` (`session_id`),
    KEY `FK_tickets_places` (`place_id`),
    CONSTRAINT `FK_tickets_places` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`),
    CONSTRAINT `FK_tickets_sessions` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci
  COMMENT ='Цены на сеансы';


CREATE TABLE IF NOT EXISTS `clients`
(
    `id`    int          NOT NULL AUTO_INCREMENT,
    `name`  varchar(100) NOT NULL DEFAULT '' COMMENT 'Имя',
    `phone` varchar(20)  NOT NULL DEFAULT '' COMMENT 'Телефон',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Клиенты';


CREATE TABLE IF NOT EXISTS `orders`
(
    `id`        int            NOT NULL AUTO_INCREMENT,
    `client_id` int            NOT NULL COMMENT 'Клиент',
    `total`     decimal(10, 2) NOT NULL DEFAULT '0.00' COMMENT 'Сумма продажи',
    PRIMARY KEY (`id`),
    KEY `FK_orders_clients` (`client_id`),
    CONSTRAINT `FK_orders_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci
  COMMENT ='Заказы билетов';


CREATE TABLE IF NOT EXISTS `order_tickets`
(
    `id`        int            NOT NULL AUTO_INCREMENT,
    `order_id`  int            NOT NULL COMMENT 'Номер заказа',
    `ticket_id` int            NOT NULL COMMENT 'Билет',
    `price`     decimal(10, 0) NOT NULL DEFAULT (0) COMMENT 'Цена',
    PRIMARY KEY (`id`),
    KEY `FK_order_tickets_orders` (`order_id`),
    KEY `FK_order_tickets_tickets` (`ticket_id`),
    CONSTRAINT `FK_order_tickets_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
    CONSTRAINT `FK_order_tickets_tickets` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci
  COMMENT ='Билеты в заказах';

