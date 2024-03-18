CREATE VIEW service_tasks_today_and_20_days_ahead AS
SELECT m.name,
       task.name   AS today_task,
       task20.name AS after_20_days_task
FROM movie m
         LEFT JOIN value vToday
             ON m.id = vToday.movie_id
         JOIN attribute task
                   ON task.id = vToday.attribute_id AND task.system_name = 'service_date'
         JOIN attribute_type typeToday
              ON typeToday.id = task.attribute_type_id
                     AND typeToday.name = 'date'
                     AND vToday.value_date::date = CURRENT_DATE
         LEFT JOIN value v20
             ON m.id = v20.movie_id
        JOIN attribute task20
                   ON task20.id = v20.attribute_id AND task20.system_name = 'service_date'
        JOIN attribute_type type20
              ON type20.id = task20.attribute_type_id
                     AND type20.name = 'date'
                     AND v20.value_date::date = (CURRENT_DATE + '20 days'::interval)
;
