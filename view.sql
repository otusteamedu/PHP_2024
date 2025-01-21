-- VIEW

-- View сборки данных для маркетинга
CREATE OR REPLACE VIEW movie_marketing as
select m.name                               as movie_name,
       a.name                               as attribute_name,
       value_date                           as date,
       CASE
           WHEN at.value_type = 'Date' AND value_date = CURRENT_DATE
               THEN 'Задачи на сегодня'
           WHEN at.value_type = 'Date' AND value_date = (CURRENT_DATE + INTERVAL '20 days')::date
               THEN 'Задачи на 20 дней' END as task
from movies m
         join values v on v.movie_id = m.id
         join attributes a on v.attribute_id = a.id
         join attribute_types at on a.attribute_type_id = at.id
where CASE
          WHEN at.value_type = 'Date'
              THEN value_date = CURRENT_DATE
              OR value_date = (CURRENT_DATE + INTERVAL '20 days')::date
          ELSE false END;

-- View сборки служебных данных
CREATE OR REPLACE VIEW movie_tasks as
select m.name  as movie_name,
       a.name  as attribute_name,
       CASE
           WHEN at.value_type = 'String' THEN value_string
           WHEN at.value_type = 'Text' THEN value_text
           WHEN at.value_type = 'Date' THEN value_date::text
           WHEN at.value_type = 'Integer' THEN value_integer::text
           WHEN at.value_type = 'Bool' THEN value_boolean::text
           WHEN at.value_type = 'Float' THEN value_float::text
           END as value
from movies m
    join values v on v.movie_id = m.id
    join attributes a on v.attribute_id = a.id
    join attribute_types at on a.attribute_type_id = at.id
order by movie_id, attribute_id;