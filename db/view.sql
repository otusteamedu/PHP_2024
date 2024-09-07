DROP VIEW IF EXISTS view_service_data;

CREATE VIEW view_service_data AS
    SELECT f.name AS film,
        atr.name AS task,
        atrv.value_date AS task_date,
        atrv.value_timestamp AS task_datetime
    FROM films f
        JOIN attribute_value atrv ON f.id = atrv.film_id
        JOIN attribute atr ON atrv.attribute_id = atr.id
    WHERE (atrv.value_date = CURRENT_DATE OR atrv.value_date = CURRENT_DATE + INTERVAL '20 days')
    OR
    (
        atrv.value_timestamp >= CURRENT_DATE + TIME '00:00:00'  AND 
        atrv.value_timestamp <= CURRENT_DATE + TIME '23:59:59')  
    OR
    (
        atrv.value_timestamp >= CURRENT_DATE + INTERVAL '20 days' + TIME '00:00:00'  AND 
        atrv.value_timestamp <= CURRENT_DATE + INTERVAL '20 days' + TIME '23:59:59'
    );  

--- фильм, тип атрибута, атрибут, значение (значение выводим как текст)
DROP VIEW IF EXISTS view_marketing_form;

CREATE VIEW view_marketing_form AS
    SELECT f.name AS film,
        atrtype.name as attribute_type,
        atr.name as attribute,
        COALESCE(
            atrval.value_text::text, 
            atrval.value_boolean::text, 
            atrval.value_date::text,
            atrval.value_timestamp::text,
            atrval.value_int::text,
            atrval.value_float::text
        ) AS value 
    FROM films f
        JOIN attribute_value atrval ON f.id = atrval.film_id
        JOIN attribute atr ON atrval.attribute_id = atr.id
        JOIN attribute_type atrtype ON atr.attribute_type_id = atrtype.id
    ORDER by f.name ASC, atrtype ASC