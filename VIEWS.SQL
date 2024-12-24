CREATE VIEW service_tasks AS
SELECT 
    m.name AS`movie`,
    at.name AS `attribute_type`,
    a.name AS `attribute`,
    CASE 
        WHEN v.value_timestamp = CURDATE() THEN a.name 
    END AS `Задачи_актуальные_на_сегодня`,
    CASE 
        WHEN v.value_timestamp = CURDATE() + INTERVAL 20 DAY THEN a.name 
    END AS `Задачи_актуальные_через_20_дней`
FROM 
    `Movies` m
JOIN 
    `Values` v ON m.id = v.movie_id
JOIN 
    `Attributes` a ON v.attribute_id = a.id
JOIN 
    `Attribute_types` `at` ON a.attribute_type_id = at.id
WHERE 
    a.name = 'служебные даты';


CREATE VIEW marketing_data AS
SELECT 
    m.name AS `movie`,
    at.name AS `attribute_type`,
    a.name AS `attribute`,
    CASE 
        WHEN at.name = 'text' THEN v.value_text
        WHEN at.name = 'boolean' THEN v.value_boolean
        WHEN at.name = 'date' THEN DATE_FORMAT(v.value_date, '%d.%m.%Y')
        WHEN at.name = 'timestamp' THEN DATE_FORMAT(v.value_timestamp, '%d.%m.%Y %H:%i:%s')
        WHEN at.name = 'float' THEN v.value_float
        ELSE 'Unkwoun Name'
    END AS `value`
FROM 
    `Movies` AS m
JOIN 
    `Values` AS v ON m.id = v.movie_id
JOIN 
    `Attributes` AS a ON v.attribute_id = a.id
JOIN 
    `Attribute_types` AS `at` ON a.attribute_type_id = at.id;