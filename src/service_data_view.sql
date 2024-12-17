CREATE VIEW service_data AS
SELECT
    m.`title` AS `movie_title`,
    a.`name` AS `attr_name`,
    atype.`type` AS `attr_type`,
    aval.`value` AS `attr_value`
FROM
    `movies` m
        JOIN attributes a ON m.id = a.movie_id
        JOIN attribute_types atype ON a.attribute_type_id = atype.id
        JOIN attribute_values aval ON a.id = aval.attribute_id
WHERE
    a.`name` LIKE 'старт%'
  AND aval.`value` BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL +20 DAY)
ORDER BY a.name;