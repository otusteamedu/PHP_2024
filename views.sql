CREATE VIEW service_tasks AS
SELECT
    m.name AS movie,
    CASE
        WHEN v.value_date = CURRENT_DATE THEN a.name
        ELSE NULL
    END AS 'Задача на сегодня',
    CASE
        WHEN v.value_date = CURRENT_DATE + INTERVAL '20 days' THEN a.name
        ELSE NULL
    END AS 'Задача через 20 дней'
FROM
    movies m
    JOIN values v ON m.id = v.movie_id
    JOIN attributes a ON v.attributes_id = a.id
    JOIN attribute_types at ON a.attribute_type_id = at.id
WHERE
    at.name = 'Служебная дата';


CREATE VIEW marketing AS
SELECT
    m.name AS movie,
    at.name AS attribute_type,
    a.name AS attribute,
    CASE
        WHEN v.value_text IS NOT NULL THEN v.value_text
        WHEN v.value_boolean IS NOT NULL THEN CASE WHEN v.value_boolean THEN 'Да' ELSE 'Нет' END
        WHEN v.value_date IS NOT NULL THEN TO_CHAR(v.value_date, 'DD-MM-YYYY')
        WHEN v.value_numeric IS NOT NULL THEN TO_CHAR(v.value_numeric, 'FM999999999.00')
        WHEN v.value_float IS NOT NULL THEN TO_CHAR(v.value_float, 'FM999999999.00')
        ELSE 'Нет значения'
    END AS value
FROM
    movies m
    JOIN values v ON m.id = v.movie_id
    JOIN attributes a ON v.attribute_id = a.id
    JOIN attribute_types at ON a.attribute_type_id = at.id
ORDER BY
    m.name, at.name, a.name;