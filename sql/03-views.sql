-- View: Служебные задачи
CREATE VIEW service_tasks AS
SELECT m.title      AS movie_title,
       a.name       AS task_name,
       v.value_date AS task_date,
       CASE
           WHEN v.value_date = CURRENT_DATE THEN 'Сегодня'
           WHEN v.value_date = CURRENT_DATE +
INTERVAL '20 days' THEN 'Через 20 дней'
END
AS task_status
FROM
    movies m
JOIN
    attributes a ON m.id = a.movie_id
JOIN
    values v ON a.id = v.attribute_id
WHERE
    a.attribute_type_id = (SELECT id FROM attribute_types WHERE name = 'служебные даты')
    AND (v.value_date = CURRENT_DATE OR v.value_date = CURRENT_DATE + INTERVAL '20 days');

-- View: Маркетинговые данные
CREATE
OR REPLACE VIEW marketing_data AS
SELECT m.title                         AS movie_title,
       at.name                         AS attribute_type,
       a.name                          AS attribute_name,
       COALESCE(v.value_text,
                v.value_boolean ::TEXT,
                v.value_date ::TEXT,
                v.value_number ::TEXT) AS attribute_value
FROM movies m
         JOIN attributes a ON m.id = a.movie_id
         JOIN attribute_types at
ON a.attribute_type_id = at.id
    JOIN
values v
ON a.id = v.attribute_id;

