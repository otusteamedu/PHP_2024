-- View для служебных данных
CREATE OR REPLACE VIEW service_tasks AS
SELECT
    m.title AS фильм,
    STRING_AGG(
            CASE WHEN date_value = CURRENT_DATE THEN a.name || ': ' || date_value::text END,
            '; '
    ) AS задачи_сегодня,
    STRING_AGG(
            CASE WHEN date_value = CURRENT_DATE + 20 THEN a.name || ': ' || date_value::text END,
            '; '
    ) AS задачи_через_20_дней
FROM
    movies m
        JOIN values v ON m.id = v.movie_id
        JOIN attributes a ON v.attribute_id = a.id
        JOIN attribute_types t ON a.type_id = t.id
WHERE
    t.name = 'service_date'
GROUP BY
    m.title;



-- View для маркетинговых данных
CREATE OR REPLACE VIEW marketing_data AS
SELECT
    m.title AS фильм,
    t.name AS тип_атрибута,
    a.name AS атрибут,
    COALESCE(
            v.text_value,
            v.boolean_value::text,
            v.date_value::text,
            v.float_value::text,
            v.int_value::text
    ) AS значение
FROM
    movies m
        JOIN values v ON m.id = v.movie_id
        JOIN attributes a ON v.attribute_id = a.id
        JOIN attribute_types t ON t.id = a.type_id
ORDER BY m.title, t."name"

