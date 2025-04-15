-- View for service data: films with current tasks and future tasks
CREATE OR REPLACE VIEW film_tasks_view AS
WITH
today_tasks AS (
    SELECT
        f.film_id,
        f.title,
        COUNT(av.value_id) AS today_tasks_count
    FROM
        film f
    LEFT JOIN
        attribute_values av ON f.film_id = av.movie_id
    LEFT JOIN
        attributes a ON av.attribute_id = a.attribute_id
    LEFT JOIN
        attribute_types at ON a.attribute_type_id = at.attribute_type_id
    WHERE
        at.type_name = 'Task'
        AND av.value_date = CURRENT_DATE
    GROUP BY
        f.film_id, f.title
),
future_tasks AS (
    SELECT
        f.film_id,
        f.title,
        COUNT(av.value_id) AS future_tasks_count
    FROM
        film f
    LEFT JOIN
        attribute_values av ON f.film_id = av.movie_id
    LEFT JOIN
        attributes a ON av.attribute_id = a.attribute_id
    LEFT JOIN
        attribute_types at ON a.attribute_type_id = at.attribute_type_id
    WHERE
        at.type_name = 'Task'
        AND av.value_date = CURRENT_DATE + INTERVAL '20 days'
    GROUP BY
        f.film_id, f.title
)
SELECT
    f.film_id,
    f.title AS film,
    COALESCE(tt.today_tasks_count, 0) AS tasks_today,
    COALESCE(ft.future_tasks_count, 0) AS tasks_in_20_days
FROM
    film f
LEFT JOIN
    today_tasks tt ON f.film_id = tt.film_id
LEFT JOIN
    future_tasks ft ON f.film_id = ft.film_id;

-- View for marketing data: films with attribute types, attributes and values
CREATE OR REPLACE VIEW film_marketing_view AS
SELECT
    f.title AS film,
    at.type_name AS attribute_type,
    a.name AS attribute,
    CASE
        WHEN av.value_text IS NOT NULL THEN av.value_text
        WHEN av.value_date IS NOT NULL THEN av.value_date::text
        WHEN av.value_image IS NOT NULL THEN av.value_image
        WHEN av.value_bool IS NOT NULL THEN
            CASE WHEN av.value_bool THEN 'true' ELSE 'false' END
        WHEN av.value_int IS NOT NULL THEN av.value_int::text
        WHEN av.value_float IS NOT NULL THEN av.value_float::text
        ELSE NULL
    END AS value
FROM
    film f
JOIN
    attribute_values av ON f.film_id = av.movie_id
JOIN
    attributes a ON av.attribute_id = a.attribute_id
JOIN
    attribute_types at ON a.attribute_type_id = at.attribute_type_id
ORDER BY
    f.title, at.type_name, a.name;