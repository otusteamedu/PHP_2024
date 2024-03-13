INSERT INTO films (id, name, date) VALUES (1, 'film1', '2024-01-01'), (2, 'film2', '2024-01-01'), (3, 'film3', '2024-01-01');
INSERT INTO attribute_types (id, name) VALUES (1, 'string'), (2, 'int'), (3, 'text'), (4, 'bool'), (5, 'date'), (6, 'float');
INSERT INTO attributes (id, name, type_id) VALUES
    (1, 'premiere', 5), (2, 'description', 3), (3, 'genre', 1), (4, 'ticket_sale_start', 5), (5, 'tv_ad_start', 5);
INSERT INTO attribute_values
(attribute_id, film_id, int_value, float_value, bool_value, string_value, text_value, date_value)
VALUES
    (1, 1, NULL, NULL, NULL, NULL, NULL, '2024-01-01'),
    (2, 1, NULL, NULL, NULL, NULL, 'film1 description', NULL),
    (3, 1, NULL, NULL, NULL, 'horror', NULL, NULL),
    (4, 1, NULL, NULL, NULL, NULL, NULL, '2024-04-01'),
    (5, 1, NULL, NULL, NULL, NULL, NULL, '2024-04-02'),
    (1, 2, NULL, NULL, NULL, NULL, NULL, '2024-02-01'),
    (2, 2, NULL, NULL, NULL, NULL, 'film2 description', NULL),
    (3, 2, NULL, NULL, NULL, 'drama', NULL, NULL),
    (4, 2, NULL, NULL, NULL,NULL, NULL, '2024-05-01'),
    (5, 2, NULL, NULL, NULL,NULL, NULL, '2024-05-02'),
    (1, 3, NULL, NULL, NULL, NULL, NULL, '2024-02-01'),
    (2, 3, NULL, NULL, NULL, NULL, 'film3 description', NULL),
    (3, 3, NULL, NULL, NULL, 'comedy', NULL, NULL),
    (4, 3, NULL, NULL, NULL, NULL, NULL, '2024-06-01'),
    (5, 3, NULL, NULL, NULL, NULL, NULL, '2024-06-02');


CREATE VIEW view1 (film_id, attribute, today, in20days)
AS SELECT films.id AS film_id, attributes.name AS attribute,
          CASE WHEN attribute_values.date_value::date = CURRENT_DATE THEN attribute_values.date_value ELSE NULL END today,
    CASE WHEN attribute_values.date_value::date = (CURRENT_DATE + '20 days'::interval) THEN attribute_values.date_value ELSE NULL END in20days
    FROM films
    JOIN attribute_values ON attribute_values.film_id = films.id
    LEFT JOIN attributes ON attributes.id = attribute_values.attribute_id
    WHERE attribute_values.attribute_id = 1;

CREATE VIEW view2 (film, attribute, type, value) AS
    SELECT films.name, attributes.name, attribute_types.name,
           CASE WHEN attribute_values.int_value IS NOT NULL THEN attribute_values.int_value::TEXT
                WHEN attribute_values.float_value IS NOT NULL THEN attribute_values.float_value::TEXT
                WHEN attribute_values.bool_value IS NOT NULL THEN attribute_values.bool_value::TEXT
                WHEN attribute_values.string_value IS NOT NULL THEN attribute_values.string_value::TEXT
                WHEN attribute_values.date_value IS NOT NULL THEN attribute_values.date_value::TEXT
                ELSE attribute_values.text_value END value
    FROM films, attributes
    LEFT JOIN attribute_types ON attribute_types.id = attributes.type_id
    JOIN attribute_values ON attribute_values.attribute_id = attributes.id
    WHERE attribute_values.film_id = films.id