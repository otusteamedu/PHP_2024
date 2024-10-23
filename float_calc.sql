SELECT SUM(value_float) AS total_rating
FROM attribute_values
WHERE film_id = 1 AND attribute_id = 4;
