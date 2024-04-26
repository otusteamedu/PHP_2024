CREATE OR REPLACE VIEW eav.marketing AS
SELECT
    m.title AS movie_title,
    at.name AS attribute_type,
    a.name AS attribute,
    CASE at.value_type
        WHEN 'integer' THEN v.integer_value::text
        WHEN 'float' THEN v.float_value::text
        WHEN 'boolean' THEN v.boolean_value::text
        WHEN 'text' THEN v.text_value
        WHEN 'date' THEN v.date_value::date::text
        ELSE 'Unexpected attribute type!'::text
END AS value
FROM
    eav.values v INNER JOIN
    eav.movies m ON v.movie_id = m.id INNER JOIN
    eav.attributes a ON v.attribute_id = a.id INNER JOIN
    eav.attribute_types at ON a.attribute_type_id = at.id
ORDER BY m.id, a.id;

CREATE OR REPLACE VIEW eav.tasks AS
SELECT
    m.title AS movie_title,
    today_tasks.task AS today_task,
    twenty_days_tasks.task AS twenty_days_task
FROM
    eav.movies m LEFT JOIN
    (
        SELECT m.id AS movie_id, string_agg(a.name, ', ') AS task
        FROM
            eav.values v INNER JOIN
            eav.movies m ON v.movie_id =  m.id INNER JOIN
            eav.attributes a ON v.attribute_id = a.id INNER JOIN
            eav.attribute_types at ON a.attribute_type_id = at.id AND
                at.id = 4 AND
                v.date_value >= CURRENT_DATE::timestamptz AND
                v.date_value < CURRENT_DATE::timestamptz + '1 day'::interval
        GROUP BY m.id
    ) today_tasks ON m.id = today_tasks.movie_id LEFT JOIN
    (
        SELECT m.id AS movie_id, string_agg(a.name, ', ') AS task
        FROM
          eav.values v INNER JOIN
          eav.movies m ON v.movie_id =  m.id INNER JOIN
          eav.attributes a ON v.attribute_id = a.id INNER JOIN
          eav.attribute_types at ON a.attribute_type_id = at.id AND
              at.id = 4 AND
              v.date_value >= CURRENT_DATE::timestamptz + '20 days'::interval AND
              v.date_value < CURRENT_DATE::timestamptz + '21 days'::interval
        GROUP BY m.id
    ) twenty_days_tasks ON m.id = twenty_days_tasks.movie_id
WHERE
    today_tasks.task IS NOT NULL OR
    twenty_days_tasks.task IS NOT NULL
ORDER BY m.id;