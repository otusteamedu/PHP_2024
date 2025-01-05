--View сборки служебных данных в форме:
 -- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней

CREATE VIEW service_tasks AS
    WITH tasks_date AS (
        SELECT DISTINCT attribute_id, value_date, value_timestamp
        FROM attributes_values
        WHERE
            (value_date = CURRENT_DATE)
           OR (value_date = CURRENT_DATE + INTERVAL '20 day')
           OR (DATE(value_timestamp) = CURRENT_DATE)
           OR (DATE(value_timestamp) = CURRENT_DATE + INTERVAL '20 day')
    ), tasks AS (
        SELECT *
        FROM attributes
        WHERE attribute_id IN (SELECT attribute_id FROM tasks_date)
    )
    SELECT
        f.title as film_title,
        t.name as task_name,
        COALESCE(td.value_date, td.value_timestamp::DATE) AS task_date
    FROM films f
    JOIN
        tasks t ON f.film_id = t.film_id
    JOIN
        tasks_date td ON t.attribute_id = td.attribute_id
    WHERE f.film_id IN (SELECT film_id FROM tasks)
    GROUP BY f.title, t.name, td.value_date, td.value_timestamp;

--View сборки данных для маркетинга в форме (три колонки):
 -- фильм, тип атрибута, атрибут, значение (значение выводим как текст)

CREATE VIEW marketing_data AS
 SELECT f.title AS film_title,
        a.name  AS attribute_name,
        at.name AS attribute_type,
        COALESCE(
                av.value_boolean::text,
                av.value_integer::text,
                av.value_float::text,
                av.value_decimal::text,
                av.value_date::text,
                av.value_timestamp::text,
                av.value_varchar::text,
                av.value_text::text
            )   AS attribute_value
 FROM films f
          JOIN
      attributes a ON f.film_id = a.film_id
          JOIN
      attribute_types at ON a.type_id = at.type_id
          JOIN
      attributes_values av ON a.attribute_id = av.attribute_id;