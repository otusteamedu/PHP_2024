-- create index if not exists ticket_bought_session_price on ticket (session_id, price);
-- set work_mem = '4GB';

-- Запрос до оптимизации
-- explain analyse select ticket.session_id, count(id)  as tickets_sold, sum(price) as earned
-- from ticket
-- group by (session_id)
-- order by tickets_sold;
--
-- set work_mem = '4MB';
-- drop index if exists ticket_bought_session_price;

-- + Способ оптимизации - написать тригер, который будет вычислять эти 2 поля (tickets_sold и earned)
-- для каждой сессии при insert, update, delete ticket'a

-- Запрос после добавления триггера

create index if not exists session_ticket_count_desc on session (ticket_count desc); -- Для ускорения сортировки

explain analyse select id, session.ticket_count, session.earned_money
from session
order by ticket_count;