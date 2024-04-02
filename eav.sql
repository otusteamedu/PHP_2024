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

CREATE TABLE `film_attribute_values`
(
    `id`           int NOT NULL AUTO_INCREMENT,
    `entity_id`    int NOT NULL,
    `attribute_id` int NOT NULL,
    `v_int`        int            DEFAULT NULL,
    `v_date`       date           DEFAULT NULL,
    `v_text`       text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `v_numeric`    decimal(10, 0) DEFAULT NULL,
    `v_bool`       enum('true','false') DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY            `fk_entity_id_idx` (`entity_id`),
    KEY            `fk_attribute_id_idx` (`attribute_id`),
    CONSTRAINT `fk_attribute_id` FOREIGN KEY (`attribute_id`) REFERENCES `film_attributes` (`id`),
    CONSTRAINT `fk_entity_id` FOREIGN KEY (`entity_id`) REFERENCES `film_entity` (`id`)
);

INSERT INTO `film_attribute_values` (`id`, `entity_id`, `attribute_id`, `v_int`, `v_date`, `v_text`, `v_numeric`,
                                     `v_bool`)
VALUES (1, 1, 1, NULL, NULL, 'Фильм огонь', NULL, NULL),
       (2, 2, 1, NULL, NULL, 'Фильм не очень', NULL, NULL),
       (3, 3, 1, NULL, NULL, 'Фильм на один раз посмотреть', NULL, NULL),
       (4, 1, 2, NULL, NULL, NULL, NULL, 'true'),
       (5, 2, 2, NULL, NULL, NULL, NULL, 'false'),
       (6, 3, 2, NULL, NULL, NULL, NULL, 'false'),
       (7, 1, 5, NULL, '2024-02-28', NULL, NULL, NULL),
       (8, 2, 5, NULL, '2024-03-28', NULL, NULL, NULL),
       (9, 3, 5, NULL, '2024-04-28', NULL, NULL, NULL);

CREATE VIEW `films_analytic` (`title`, `type`, `name`, `value`)
AS
select `fe`.`title` AS `title`,
       `fat`.`type` AS `type`,
       `fa`.`name`  AS `name`,
       COALESCE(fav.v_int, fav.v_text, fav.v_date, fav.v_numeric,
                fav.v_bool) as value
from (((`film_entity` `fe`
    join `film_attribute_values` `fav` on ((`fe`.`id` = `fav`.`entity_id`)))
    join `film_attributes` `fa` on ((`fav`.`attribute_id` = `fa`.`id`)))
    join `film_attributes_type` `fat` on ((`fat`.`id` = `fa`.`attribute_type_id`)));


CREATE VIEW `films_premiere` (`movie`, `actual_today`, `actual_later`)
AS
select `fe`.`title`                                                       AS `title`,
       if((`fav`.`v_date` <= curdate()), 'Да', 'Нет')                     AS `actual_today`,
       if((`fav`.`v_date` >= (curdate() + interval 20 day)), 'Да', 'Нет') AS `actual_later`
from ((`film_entity` `fe`
    join `film_attribute_values` `fav` on ((`fe`.`id` = `fav`.`entity_id`)))
    join `film_attributes` `fa` on ((`fav`.`attribute_id` = `fa`.`id`)))
where (`fav`.`v_date` IS NOT NULL);

SELECT *
FROM films_premiere;

SELECT *
FROM films_analytic;
