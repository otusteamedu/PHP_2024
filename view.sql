create view film_attr_values as select f.title film_title, a.title attr_title, t.title attr_type,
        (case
            when t.data_type = 'string' then cast(av.value_string as varchar)
            when t.data_type = 'datetime' then cast(av.value_date as varchar)
            when t.data_type = 'float' then cast(av.value_float as varchar)
            when t.data_type = 'int' then cast(av.value_int as varchar)
            when t.data_type = 'text' then cast(av.value_text as varchar)
        end) as attr_value

from attribute_value av
         join attribute a on av.attribute_id = a.id
         join attribute_type t on a.id = t.attribute_id
         join film f on av.film_id = f.id
order by film_title asc
;