DROP VIEW IF EXISTS `premier_list`;
CREATE VIEW `premier_list` (`film_name`, `is_actual_today`, `is_actual_after_20_days`)
AS
SELECT `movie`.`title`                                                      AS `film_name`,
       `attr_value`.`value`                                                     AS `day_premier`
       IF((`day_premier` <= curdate()), 'Да', 'Нет')                     AS `is_actual_today`,
       IF((`day_premier` >= (curdate() + INTERVAL 20 DAY)), 'Да', 'Нет') AS `is_actual_after_20_days`,
FROM ((`films` `movie`
    JOIN `film_attr_values` `attr_value` ON ((`movie`.`id` = `attr_value`.`film_id`)))
    JOIN `type_attr` `attr` ON ((`attr_value`.`attr_id` = `attr`.`id`)))
WHERE (`attr`.`name` = 'day_premier');

DROP VIEW IF EXISTS `analytics`;
CREATE VIEW `analytics` (`film_name`, `type`, `name`, `value`)
AS
SELECT `movie`.`title`  AS `film_name`,
       `attr`.`type`  AS `type`,
       `attr_name`.`name`   AS `name`,
       `attr_value`.`value` AS `value`
FROM (((`film_entity` `movie`
    JOIN `film_attr_values` `attr_value` ON ((`movie`.`id` = `attr_value`.`film_id`)))
    JOIN `type_attr` `attr` ON ((`attr_value`.`attr_id` = `attr`.`id`)))
    JOIN `name_attr` `attr_name` ON ((`attr`.`id` = `attr_name`.`attr_id`)));
