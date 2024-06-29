DROP VIEW IF EXISTS `task_list`;
CREATE VIEW `task_list`
AS
    SELECT
        f.title AS film_name,
        fa.name AS attribut_name,
        fv.value_date AS value
    FROM films f
    LEFT JOIN films_values fv ON fv.film_id = f.id
    LEFT JOIN films_attributes fa ON fa.id = fv.attribute_id
    WHERE
        fa.code = 'task_date'
        AND (fv.value_date = CURRENT_DATE OR fv.value_date = CURRENT_DATE + INTERVAL '20 days');

DROP VIEW IF EXISTS `analytics_list`;
CREATE VIEW `analytics_list`
AS
    SELECT
        f.title AS film_name,
        fa.name AS attribut_name,
        fat.type AS attribut_type
        COALESCE(fv.value_varchar, fv.value_text, fv.value_date, fv.value_int, fv.value_bool, fv.value_numeric) AS attribut_value
    FROM films f
    LEFT JOIN films_values fv ON fv.film_id = f.id
    LEFT JOIN films_attributes fa ON fa.id = fv.attribute_id
    LEFT JOIN films_attribute_types fat  ON fat.id  = fa.type_id;