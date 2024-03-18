drop view if exists marketing_view;

create view marketing_view as
select m.title as фильм,
       a.title as атрибут,
       t.type_name,
       (case t.type_name
            when 'boolean' then v.bool_value::varchar(255)
            when 'timestamp' then v.timestamp_value::varchar(255)
            when 'text' then v.text_value::varchar(255)
            when 'float' then v.float_value::varchar(255)
           end) as value
from attribute_value as v
         join movie as m on v.movie_id = m.id
         join attribute as a on v.attribute_id = a.id
         join attribute_type as t on a.type_id = t.id
;

select *
from marketing_view;