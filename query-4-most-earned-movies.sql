-- Фильмы заработвашие больше всего
-- create index if not exists ticket_bought_session_price on ticket (session_id, price);
--
--
-- explain analyse select m.title, sum(t.earned)
-- from movie m
--          join session as s on s.movie_id = m.id
--          join (select ticket.session_id, sum(ticket.price) as earned
--                from ticket
--                group by ticket.session_id) as t on t.session_id = s.id
-- group by m.title
-- order by sum(t.earned) desc
-- limit 3;

-- drop index if exists ticket_bought_session_price;

-- Способ оптимизации - написать тригер, который будет вычислять эти 2 поля (tickets_sold и earned)
-- для каждой сессии при insert, update, delete ticket'a
-- код триггера в create-trigger.sql

create index if not exists session_movie_earned_money on session (movie_id, earned_money); -- для ускорения join и аггрегации

explain analyse select m.title, sum(s.earned_money)
from session s
join movie m on m.id = s.movie_id
group by m.title
order by sum(s.earned_money) desc
limit 3;

-- drop index if exists session_movie_earned_money;
