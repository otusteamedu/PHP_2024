-- все индексы для ускорения join'ов по хэшу
create index if not exists attribute_value_movie on attribute_value (movie_id);
create index if not exists attribute_value_attribute on attribute_value (attribute_id);
create index if not exists attribute_attribute_type on attribute (type_id);

explain analyse select v.id,
       m.title as фильм,
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
         join attribute_type as t on a.type_id = t.id;
--
-- drop index if exists attribute_value_movie;
-- drop index if exists attribute_value_attribute;
-- drop index if exists attribute_attribute_type;