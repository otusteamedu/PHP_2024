DROP VIEW IF EXISTS `premier_list`;
CREATE VIEW `premier_list`
AS
SELECT f.title                       as film_title,
       a.name                        as attr_name,
       COALESCE(fav.value_int::TEXT, fav.value_text, fav.value_date::TEXT, fav.value_number::TEXT,
                fav.value_bool::TEXT) as value
FROM films f
         JOIN film_attr_values fav ON m.id = av.movie_id
         JOIN attrs a ON fav.attribute_id = a.id
WHERE a.name = 'task_date'
  AND (fav.value_date = CURRENT_DATE OR fav.value_date = CURRENT_DATE + INTERVAL '20 day');

DROP VIEW IF EXISTS `analytics`;
CREATE VIEW `analytics`
AS
SELECT f.title                       as film_title,
       at.name                       as attr_type,
       a.name                        as attr_name,
       COALESCE(fav.value_int::TEXT, fav.value_text, fav.value_date::TEXT, fav.value_number::TEXT,
                fav.value_bool::TEXT) as value
FROM films f
         JOIN film_attr_values fav ON f.id = fav.movie_id
         JOIN attrs a ON fav.attribute_id = a.id
         JOIN type_attr ta ON a.type_id = ta.id;