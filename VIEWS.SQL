CREATE VIEW service_tasks AS
SELECT 
    m.title AS фильм,
    GROUP_CONCAT(CASE 
        WHEN v.value_date = CURDATE() THEN a.name 
        END SEPARATOR ', ') AS `задачи_актуальные_на_сегодня`,
    GROUP_CONCAT(CASE 
        WHEN v.value_date = CURDATE() + INTERVAL 20 DAY THEN a.name 
        END SEPARATOR ', ') AS `задачи_актуальные_через_20_дней`
FROM 
    Movies m
JOIN 
    values v ON m.movie_id = v.movie_id
JOIN 
    Attributes a ON v.attribute_id = a.attribute_id
JOIN 
    Attribute_types at ON a.attribute_type_id = at.attribute_type_id
WHERE 
    at.name = 'Служебные даты'
GROUP BY 
    m.movie_id, m.title;

CREATE VIEW marketing_data AS
SELECT 
    m.name AS `movie`,
    a.name AS `attribute`,
    CASE 
        WHEN Attribute_types.data_type = 'text' THEN v.value_text
        WHEN Attribute_types.data_type = 'boolean' THEN CASE WHEN v.value_bool THEN 'Да' ELSE 'Нет' END
        WHEN Attribute_types.data_type = 'date' THEN DATE_FORMAT(v.value_date, '%d.%m.%Y')
        ELSE 'Неизвестный тип'
    END AS `значение`
FROM 
    Movies `m`
JOIN 
    Values `v` ON m.movie_id = v.movie_id
JOIN 
    Attributes `a` ON v.attribute_id = a.attribute_id
JOIN 
    Attribute_types `at` ON a.attribute_type_id = at.attribute_type_id;