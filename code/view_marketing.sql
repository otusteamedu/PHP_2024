-- Проверка существует ли представление marketing и её удаление
DROP VIEW IF EXISTS marketing;

-- Создание представления marketing
CREATE VIEW marketing AS
SELECT m.name  AS movies,
       at.name AS attribute_type,
       a.name  AS attribute,
       CASE
           WHEN at.type = 'text' THEN v.text_value::text
           WHEN at.type = 'boolean' THEN v.boolean_value::text
           WHEN at.type = 'date' THEN v.date_value::text
           WHEN at.type = 'integer' THEN v.integer_value::text
           WHEN at.type = 'decimal' THEN v.decimal_value::text
           ELSE NULL
           END AS value

FROM values AS v
         LEFT JOIN movies AS m ON m.id = v.movie_id
         LEFT JOIN attributes AS a ON a.id = v.attribute_id
         LEFT JOIN attribute_types AS at ON at.id = a.attribute_type_id

ORDER BY m.id ASC;