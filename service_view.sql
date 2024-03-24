create or replace view service_view as

select m.name as movie, a.name as task, v.date_value as date
from public.movie m
inner join public.value v on m.id = v.movie_id
inner join public.attribute a on a.id = v.attribute_id
inner join public.type t on t.id = a.type_id
where a.name in ('ticket sales start date', 'advertising start date')
and v.date_value in (current_date, current_date + 20);

select * from service_view;