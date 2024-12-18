CREATE VIEW marketing_data AS
SELECT
    m.`title` AS `movie_title`,
    a.`name` AS `attr_name`,
    atype.`type` AS `attr_type`,
    COALESCE(aval.value_text, aval.value_date, aval.value_time, aval.value_bool, aval.value_int, aval.value_float) AS attr_value
FROM
    `movies` m
        JOIN attributes a ON m.id = a.movie_id
        JOIN attribute_types atype ON a.attribute_type_id = atype.id
        JOIN attribute_values aval ON a.id = aval.attribute_id
WHERE a.`is_service` = false
ORDER BY a.name;