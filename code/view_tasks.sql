-- Проверка существует ли представление tasks и её удаление
DROP VIEW IF EXISTS tasks;

-- Создание представления tasks
CREATE VIEW tasks AS
SELECT m.name AS movies,
       STRING_AGG(CASE
                      WHEN (v.date_value = CURRENT_DATE)
                          THEN a.name END,
                  ', ') AS tasks_today,
       STRING_AGG(CASE
                      WHEN (v.date_value >= (CURRENT_DATE + INTERVAL '20 days'))
                          THEN a.name || ' ' || v.date_value END,
                  ', ') AS tasks_in_20_days

FROM values AS v
         LEFT JOIN movies AS m ON m.id = v.movie_id
         LEFT JOIN attributes AS a ON a.id = v.attribute_id
         LEFT JOIN attribute_types AS at ON at.id = a.attribute_type_id

WHERE at.id = 4

GROUP BY m.id;