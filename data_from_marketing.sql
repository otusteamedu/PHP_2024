CREATE VIEW marketing_data AS
SELECT f.name  AS film_name,
       at.name AS attribute_type,
       a.name  AS attribute_name,
       COALESCE(
               av.value_text,
               TO_CHAR(av.value_date, 'YYYY-MM-DD'),
               CASE WHEN av.value_boolean THEN 'Да' ELSE 'Нет' END
       )       AS attribute_value
FROM attribute_values av
         JOIN
     attributes a ON av.attribute_id = a.id
         JOIN
     attribute_types at ON a.attribute_type_id = at.id
JOIN
    films f ON av.film_id = f.id;
