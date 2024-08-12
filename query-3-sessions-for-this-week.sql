-- Сеансы на ближайшую неделю
create index if not exists session_start_time on session (start_time); -- для ускорения выборки по start_time

explain analyse
select m.title, s.start_time
from session as s
         join movie as m on m.id = s.movie_id
where start_time >= 'tomorrow'::TIMESTAMP
  and start_time < 'tomorrow'::TIMESTAMP + interval '1 week'
order by start_time;

-- drop index if exists session_start_time;
