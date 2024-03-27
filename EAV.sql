CREATE database db_cinema;

DROP TABLE IF EXISTS `films`;

CREATE TABLE `films`
(
    `id`          int          NOT NULL AUTO_INCREMENT,
    `title`       text NOT NULL,
    `description` text,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `type_attr`;

CREATE TABLE `type_attr`
(
    `id`   int         NOT NULL AUTO_INCREMENT,
    `type` varchar(11) NOT NULL,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `name_attrs`;

CREATE TABLE `name_attrs`
(
    `id`                int         NOT NULL AUTO_INCREMENT,
    `name`              text NOT NULL,
    `attr_id` int         NOT NULL,
    PRIMARY KEY (`id`),
    KEY `index_attr_id` (`attr_id`),
    CONSTRAINT `foreign_key_attr_id` FOREIGN KEY (`attr_id`) REFERENCES `type_attr` (`id`)
);

DROP TABLE IF EXISTS `film_attr_values`;

CREATE TABLE `film_attr_values`
(
    `id`           int         NOT NULL AUTO_INCREMENT,
    `value`        text NOT NULL,
    `attr_id` int         NOT NULL,
    `film_id`    int         NOT NULL,
    PRIMARY KEY (`id`),
    KEY `index_film_id` (`film_id`),
    KEY `index_attr_id` (`attr_id`),
    CONSTRAINT `foreign_key_film_id` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`),
    CONSTRAINT `foreign_key_attr_id` FOREIGN KEY (`attr_id`) REFERENCES `type_attr` (`id`)
);