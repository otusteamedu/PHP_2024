CREATE VIEW view1 (movie, attribute, today, in_20_days) AS
    SELECT movies.name AS movie, attributes.name AS attribute,
           CASE WHEN attribute_values.date_value = CURRENT_DATE THEN attribute_values.date_value ELSE NULL END today_event,
        CASE WHEN attribute_values.date_value = CURRENT_DATE + INTERVAL '20 days' THEN attribute_values.date_value ELSE NULL END in_20_days_event
    FROM movies
             JOIN attribute_values ON movies.id =  attribute_values.movie_id
JOIN attributes ON attributes.id = attribute_values.attribute_id
WHERE attributes.attribute_type = 4;

CREATE VIEW view2 (movie, attribute_type, attribute, value) AS
    SELECT movies.name AS movie, attribute_types.name AS attribute_type, attributes.name AS attribute,
           CASE WHEN attribute_values.int_value IS NOT NULL THEN attribute_values.int_value::TEXT
                WHEN attribute_values.text_value IS NOT NULL THEN attribute_values.text_value
                WHEN attribute_values.bool_value IS NOT NULL THEN attribute_values.bool_value::TEXT
                WHEN attribute_values.date_value IS NOT NULL THEN attribute_values.date_value::TEXT
                ELSE attribute_values.float_value::TEXT END value
    FROM movies
             JOIN attribute_values ON movies.id =  attribute_values.movie_id
JOIN attributes ON attributes.id = attribute_values.attribute_id
            JOIN attribute_types ON attribute_types.id = attributes.attribute_type;

