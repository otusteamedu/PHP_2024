CREATE VIEW vw_tasks AS
SELECT movies.name                                                                                  AS "Фильм",
       CASE
           WHEN attributes_values.value_date = CURRENT_DATE THEN attributes_names.name
           ELSE '' END                                                                              AS "Задачи актуальные на сегодня",
       CASE
           WHEN attributes_values.value_date >= CURRENT_DATE + INTERVAL '20 days' THEN attributes_names.name
        ELSE '' END                                                                              AS "Задачи актуальные через 20 дней"
FROM movies
         INNER JOIN attributes_values ON movies.id = attributes_values.movies_id
         INNER JOIN attributes_names ON attributes_values.attributes_names_id = attributes_names.id
         INNER JOIN attributes_types ON attributes_names.attributes_types_id = attributes_types.id
WHERE attributes_types.name = 'Служебные даты';

CREATE VIEW vw_marketing AS
SELECT movies.name           AS "Фильм",
       attributes_types.name AS "Тип атрибута",
       attributes_names.name AS "Атрибут",
       COALESCE(
               attributes_values.value_text,
               attributes_values.value_bool::text,
               attributes_values.value_int::text,
               attributes_values.value_numeric::text,
               attributes_values.value_date::text
           )                     AS "Значение"
FROM movies
         JOIN attributes_values ON movies.id = attributes_values.movies_id
         JOIN attributes_names ON attributes_values.attributes_names_id = attributes_names.id
         JOIN attributes_types ON attributes_names.attributes_types_id = attributes_types.id;