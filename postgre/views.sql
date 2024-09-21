DROP VIEW IF EXISTS view_marketing;

CREATE VIEW view_marketing AS
SELECT f.name AS film, t.name AS attribute_type, a.name AS attribute,
    CASE
        WHEN t.type = 'text' THEN v.value_text::text
        WHEN t.type = 'boolean' THEN v.value_boolean::text
        WHEN t.type = 'date' THEN v.value_date::text
        WHEN t.type = 'timestamp' THEN v.value_timestamp::text
        ELSE NULL
    END AS value

FROM attribute_values AS v
    LEFT JOIN films AS f ON f.id = v.film_id
    LEFT JOIN attributes AS a ON a.id = v.attribute_id
    LEFT JOIN attribute_types AS t ON t.id = a.attribute_type_id

ORDER BY f.id ASC;


DROP VIEW IF EXISTS view_tasks;

CREATE VIEW view_tasks AS

SELECT f.name AS film,
   CASE WHEN v.value_timestamp::TIMESTAMP::DATE = CURRENT_DATE THEN a.name ELSE NULL END AS tasks_today,
   CASE WHEN v.value_timestamp::TIMESTAMP::DATE != CURRENT_DATE THEN a.name ELSE NULL END AS tasks_in_20_days

FROM attribute_values AS v
         LEFT JOIN films AS f ON f.id = v.film_id
         LEFT JOIN attributes AS a ON a.id = v.attribute_id
         LEFT JOIN attribute_types AS t ON t.id = a.attribute_type_id

WHERE t.id = 4 AND
    (
        (v.value_timestamp >= CURRENT_DATE + TIME '00:00:00'
            AND v.value_timestamp <= CURRENT_DATE + TIME '23:59:59')
        OR
        (v.value_timestamp >= CURRENT_DATE + INTERVAL '20 day' + TIME '00:00:00'
            AND v.value_timestamp <= CURRENT_DATE + INTERVAL '20 day' + TIME '23:59:59')
    );



