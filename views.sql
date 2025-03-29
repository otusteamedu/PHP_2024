CREATE VIEW marketing_data_view AS
select m.name                     as movie_name,
       attribute_types.value_type as attr_type,
       attribute.name             as attr_name,
       CASE
           attribute_types.value_type
           WHEN 'Text' THEN av.value_text
           WHEN 'Boolean' THEN (av.value_boolean)::text
           WHEN 'Float' THEN (av.value_float)::text
           WHEN 'Int' THEN (av.value_int)::text
           WHEN 'Date' THEN (av.value_date)::text
           ELSE ''::text
           END                    AS value
from movies m
         join attribute_values av on m.id = av.movie_id
         join attribute on av.attribute_id = attribute.id
         join attribute_types on attribute.attribute_type_id = attribute_types.id where attribute_types.code != 'business_date';

CREATE VIEW service_tasks_view AS
select m.name AS movie,
       STRING_AGG(
               CASE
                   WHEN av.value_date = CURRENT_DATE THEN a.name
                   END, ', '
       )      AS tasks_due_today,
       STRING_AGG(
               CASE
                   WHEN av.value_date >= (CURRENT_DATE + INTERVAL '20 days') THEN a.name
                   END, ', '
       )      AS tasks_due_in_20_days
from movies m
         join attribute_values av ON m.id = av.movie_id
         join attribute a ON av.attribute_id = a.id
         join attribute_types at ON a.attribute_type_id = at.id where at.code = 'business_date'
group by m.id;