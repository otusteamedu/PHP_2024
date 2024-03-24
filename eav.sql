DROP TABLE IF EXISTS `film_attributes_type`;

CREATE TABLE `film_attributes_type`
(
    `id`   int         NOT NULL AUTO_INCREMENT,
    `type` varchar(45) NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `film_attributes_type` (`id`, `type`)
VALUES (1, 'bool'),
       (2, 'int'),
       (3, 'date'),
       (4, 'string'),
       (5, 'money'),
       (6, 'numeric'),
       (7, 'text');

DROP TABLE IF EXISTS `film_attributes`;

CREATE TABLE `film_attributes`
(
    `id`                int         NOT NULL AUTO_INCREMENT,
    `name`              varchar(45) NOT NULL,
    `attribute_type_id` int         NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_attribute_type_id_idx` (`attribute_type_id`),
    CONSTRAINT `fk_attribute_type_id` FOREIGN KEY (`attribute_type_id`) REFERENCES `film_attributes_type` (`id`)
);

INSERT INTO `film_attributes` (`id`, `name`, `attribute_type_id`)
VALUES (1, 'Рецензии критиков', 7),
       (2, 'Оскар', 1),
       (3, 'Мировая премьера', 3),
       (4, 'Ника', 1),
       (5, 'Дата начала продажи билетов', 3);

DROP TABLE IF EXISTS `film_entity`;

CREATE TABLE `film_entity`
(
    `id`          int          NOT NULL AUTO_INCREMENT,
    `title`       varchar(150) NOT NULL,
    `description` text COLLATE utf8mb4_unicode_ci,
    PRIMARY KEY (`id`)
);

INSERT INTO `film_entity` (`id`, `title`, `description`)
VALUES (1, 'Аватар', 'Аватар'),
       (2, 'Один дома 1', 'Один дома 1'),
       (3, 'Один дома 2', 'Один дома 2');

DROP TABLE IF EXISTS `film_attribute_values`;

CREATE TABLE `film_attribute_values`
(
    `id`           int         NOT NULL AUTO_INCREMENT,
    `value`        varchar(45) NOT NULL,
    `entity_id`    int         NOT NULL,
    `attribute_id` int         NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_entity_id_idx` (`entity_id`),
    KEY `fk_attribute_id_idx` (`attribute_id`),
    CONSTRAINT `fk_attribute_id` FOREIGN KEY (`attribute_id`) REFERENCES `film_attributes` (`id`),
    CONSTRAINT `fk_entity_id` FOREIGN KEY (`entity_id`) REFERENCES `film_entity` (`id`)
);

INSERT INTO `film_attribute_values` (`id`, `value`, `entity_id`, `attribute_id`)
VALUES (1, 'Фильм огонь', 1, 1),
       (2, 'Фильм не очень', 2, 1),
       (3, 'Фильм на один раз посмотреть', 3, 1),
       (4, 'true', 1, 2),
       (5, 'false', 2, 2),
       (6, 'false', 3, 2),
       (7, '2024-02-28', 1, 5),
       (8, '2024-03-28', 2, 5),
       (9, '2024-04-28', 3, 5);


DROP VIEW IF EXISTS `films_analytic`;
CREATE TABLE `films_analytic`
(
    `title` varchar(150),
    `type`  varchar(45),
    `name`  varchar(45),
    `value` varchar(45)
);


DROP VIEW IF EXISTS `films_premiere`;
CREATE TABLE `films_premiere`
(
    `movie`         varchar(150),
    `actual_today`  varchar(3),
    `actual_later`  varchar(3),
    `date_premiere` varchar(45)
);


DROP TABLE IF EXISTS `films_analytic`;
CREATE VIEW `films_analytic` (`title`, `type`, `name`, `value`)
AS
select `fe`.`title`  AS `title`,
       `fat`.`type`  AS `type`,
       `fa`.`name`   AS `name`,
       `fav`.`value` AS `value`
from (((`film_entity` `fe`
    join `film_attribute_values` `fav` on ((`fe`.`id` = `fav`.`entity_id`)))
    join `film_attributes` `fa` on ((`fav`.`attribute_id` = `fa`.`id`)))
    join `film_attributes_type` `fat` on ((`fat`.`id` = `fa`.`attribute_type_id`)));

DROP TABLE IF EXISTS `films_premiere`;
CREATE VIEW `films_premiere` (`movie`, `actual_today`, `actual_later`, `date_premiere`)
AS
select `fe`.`title`                                                      AS `title`,
       if((`fav`.`value` <= curdate()), 'Да', 'Нет')                     AS `actual_today`,
       if((`fav`.`value` >= (curdate() + interval 20 day)), 'Да', 'Нет') AS `actual_later`,
       `fav`.`value`                                                     AS `value`
from ((`film_entity` `fe`
    join `film_attribute_values` `fav` on ((`fe`.`id` = `fav`.`entity_id`)))
    join `film_attributes` `fa` on ((`fav`.`attribute_id` = `fa`.`id`)))
where (`fa`.`id` = 5);

SELECT *
FROM films_premiere;

SELECT *
FROM films_analytic;
