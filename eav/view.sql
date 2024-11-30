drop view if exists service_view;

create view service_view as
select m.name        as movie,
       at.name       as task,
       av.value_date as task_date,
       av.created_at as task_datetime
from movies m
         join movie_attribute_values av on m.id = av.movie_id
         join attributes a on av.attribute_id = a.id
         join attribute_types at on a.type_id = at.id
where (av.value_date = current_date or av.value_date = current_date + interval '20 days')
   or (
    av.created_at >= current_date + time '00:00:00' and
    av.created_at <= current_date + time '23:59:59'
    )
   or (
    av.created_at >= current_date + interval '20 days' + time '00:00:00' and
    av.created_at <= current_date + interval '20 days' + time '23:59:59'
    );


drop view if exists marketing_view;

create view marketing_view as
select m.name  as movie_name,
       at.name as attribute_type,
       a.name  as attribute_name,
       coalesce(
               av.value_text::text,
               av.value_boolean::text,
               av.value_date::text,
               av.value_float::text
       )       as attribute_value
from movies m
         join movie_attribute_values av on m.id = av.movie_id
         join attributes a on av.attribute_id = a.id
         join attribute_types at on a.type_id = at.id
order by m.name, at.name;
