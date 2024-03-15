CREATE VIEW marketing_data_view AS
SELECT
    m.name,
    at.name AS type,
    a.name AS attr_name,
    a.system_name AS attr_system_name,
    v.value
FROM
    movie m
LEFT JOIN value v ON m.id = v.movie_id
JOIN attribute a ON v.attribute_id = a.id
JOIN attribute_type at ON a.attribute_type_id = at.id;
