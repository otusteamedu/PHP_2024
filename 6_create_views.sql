CREATE VIEW service_tasks AS
SELECT
    m.name AS фильм,
    array_agg(a.name ORDER BY v.value_date) FILTER (WHERE v.value_date = CURRENT_DATE) AS задачи_актуальные_на_сегодня,
    array_agg(a.name ORDER BY v.value_date) FILTER (WHERE v.value_date = CURRENT_DATE + INTERVAL '20 days') AS задачи_актуальные_через_20_дней
FROM
    movies m
        JOIN movie_values v ON m.id = v.movie_id
        JOIN movie_attributes a ON v.movie_attribute_id = a.id
WHERE
    a.name IN ('дата начала продажи билетов', 'когда запускать рекламу на ТВ')
GROUP BY
    m.name
HAVING
            COUNT(*) FILTER (WHERE v.value_date = CURRENT_DATE) > 0
    OR COUNT(*) FILTER (WHERE v.value_date = CURRENT_DATE + INTERVAL '20 days') > 0;

CREATE VIEW marketing_data AS
SELECT
    m.name AS фильм,
    at.type AS тип_атрибута,
    ma.name AS атрибут,
    COALESCE(mv.value_text, mv.value_boolean::text, mv.value_date::text, mv.value_integer::text, mv.value_float::text, mv.value_string) AS значение
FROM
    movies m
        JOIN
    movie_values mv ON m.id = mv.movie_id
        JOIN
    movie_attributes ma ON mv.movie_attribute_id = ma.id
        JOIN
    attribute_types at ON ma.type_id = at.id;