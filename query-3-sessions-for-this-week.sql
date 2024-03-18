-- Сеансы на ближайшую неделю

select  m.title, s.start_time
from session as s
join movie as m on m.id = s.movie_id
where start_time >= 'tomorrow'::TIMESTAMP
and start_time < 'tomorrow'::TIMESTAMP + interval '1 week'
order by start_time;