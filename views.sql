#View сборки служебных данных в форме:
#- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
CREATE VIEW service_tasks_view AS
SELECT m.title AS movie,
       STRING_AGG(
               CASE
                   WHEN av.value::DATE <= CURRENT_DATE THEN a.name
            ELSE NULL
        END, ', '
       )       AS tasks_due_today,
       STRING_AGG(
               CASE
                   WHEN av.value::DATE <= (CURRENT_DATE + INTERVAL '20 days') THEN a.name
            ELSE NULL
        END, ', '
       )       AS tasks_due_in_20_days
FROM movie m
         JOIN
     attribute_value av ON m.id = av.movie_id
         JOIN
     attribute a ON av.attribute_id = a.id
         JOIN
     attribute_type at ON a.attribute_type_id = at.id AND at.code = 'service_dates'
GROUP BY
    m.id;

#View сборки данных для маркетинга в форме (три колонки):
#- фильм, тип атрибута, атрибут, значение (значение выводим как текст)
CREATE VIEW marketing_data_view AS
SELECT m.title AS movie,
       at.type AS attribute_type,
       a.name  AS attribute,
       av.value AS value
FROM
    movie m
JOIN
    attribute_value av ON m.id = av.movie_id
JOIN
    attribute a ON av.attribute_id = a.id
JOIN
    attribute_type at ON a.attribute_type_id = at.id AND at.code IN ('reviews', 'awards', 'important_dates');
