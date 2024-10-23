-- View для получения актуальных задач для фильмов
CREATE VIEW film_tasks_today AS
SELECT f.title, a.attribute_name, av.value_date
FROM films f
JOIN attribute_values av ON f.film_id = av.film_id
JOIN attributes a ON av.attribute_id = a.attribute_id
WHERE av.value_date = CURRENT_DATE;


-- View для маркетинга
CREATE OR REPLACE VIEW film_marketing_data AS
SELECT f.title, at.type_name, a.attribute_name, 
       COALESCE(av.value_text, 
                av.value_date::text, 
                av.value_boolean::text, 
                av.value_float::text, 
                av.value_int::text) AS value
FROM films f
JOIN attribute_values av ON f.film_id = av.film_id
JOIN attributes a ON av.attribute_id = a.attribute_id
JOIN attribute_types at ON a.type_id = at.type_id;
