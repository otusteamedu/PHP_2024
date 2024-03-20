-- Минимальная и максимальная цена на свободные билеты для каждого сегодняшнего фильма

create index if not exists session_start_time on session (start_time desc); -- для ускорения выборки
create index if not exists session_movie_id on session (movie_id); -- для ускорения join'ов
create index if not exists ticket_bought_session_price on ticket (session_id, price desc); -- для ускорения поиска min max

explain analyse
select m.title, min(d.min), max(d.max)
from session s
         join movie m on s.movie_id = m.id
         join (select session_id, min(price), max(price)
               from ticket
               group by session_id) as d on d.session_id = s.id
where start_time >= 'tomorrow'::TIMESTAMP
  and start_time < 'tomorrow'::TIMESTAMP + interval '1 day'
group by m.title;

-- drop index if exists ticket_bought_session_price;
-- drop index if exists session_movie_id;
-- drop index if exists session_start_time;

