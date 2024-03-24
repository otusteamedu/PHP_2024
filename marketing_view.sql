create or replace view marketing_view as

select m.name as movie, a.name as attribute, t.name as type,
    case
        when v.text_value is not null then v.text_value::text
        when v.int_value is not null then v.int_value::text
        when v.date_value is not null then v.date_value::text
        when v.time_value is not null then v.time_value::text
        when v.bool_value is not null then v.bool_value::text
        when v.float_value is not null then v.float_value::text
    end as value
from public.value v
inner join public.movie m on m.id = v.movie_id
inner join public.attribute a on a.id = v.attribute_id
inner join public.type t on t.id = a.type_id
order by m.name;

select * from marketing_view;
