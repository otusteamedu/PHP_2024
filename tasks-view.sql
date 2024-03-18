drop view if exists tasks_view;

create view tasks_view as
select m.title as movie,
       t.events as todays_events,
       e.events as upcoming_events
from movie as m
         left join (select string_agg(a.title, ', ') as events, v.movie_id
               from attribute_value as v
                        join attribute as a on v.attribute_id = a.id
               where v.timestamp_value >= current_date::timestamp
                 and v.timestamp_value < current_date::timestamp + interval '1 day'
               group by v.movie_id) as t on t.movie_id = m.id
         left join (select string_agg(a.title, ', ') as events, v.movie_id
               from attribute_value as v
                        join attribute as a on v.attribute_id = a.id
               where v.timestamp_value >= current_date::timestamp
                 and v.timestamp_value < current_date::timestamp + interval '20 days'
               group by v.movie_id) as e on e.movie_id = m.id
;

select *
from tasks_view;