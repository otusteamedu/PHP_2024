--View для сборки служебных данных:

CREATE VIEW service_tasks AS
SELECT m.title AS movie,
     a.attribute_name AS task,
     av.value_date AS date
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
JOIN attributes a ON av.attribute_id = a.attribute_id
WHERE a.type_id = 4 AND av.value_date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL '20 days';


--View для сборки данных для маркетинга:

CREATE VIEW marketing_data AS
SELECT m.title AS movie,
     at.type_name AS attribute_type,
     a.attribute_name AS attribute,
     COALESCE(
         av.value_text,
         av.value_boolean::TEXT,
         av.value_date::TEXT,
         av.value_integer::TEXT,
         av.value_float::TEXT
     ) AS value
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
JOIN attributes a ON av.attribute_id = a.attribute_id
JOIN attribute_types at ON a.type_id = at.type_id;