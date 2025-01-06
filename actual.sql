CREATE VIEW service_tasks AS
SELECT f.name        AS film_name,
       a.name        AS task_name,
       av.value_date AS task_date,
       CASE
           WHEN av.value_date = CURRENT_DATE THEN 'Актуально на сегодня'
           WHEN av.value_date = CURRENT_DATE +
        INTERVAL '20 days' THEN 'Актуально через 20 дней'
        ELSE NULL
END
AS relevance
FROM
    attribute_values av
JOIN
    attributes a ON av.attribute_id = a.id
JOIN
    films f ON av.film_id = f.id
WHERE
    a.attribute_type_id = 4
    AND (av.value_date = CURRENT_DATE OR av.value_date = CURRENT_DATE + INTERVAL '20 days');
