-- Получить билеты для сеанса
create index if not exists ticket_session on ticket (session_id); -- для ускорения фильтрации where session_id

explain analyse select raw, col from ticket
where session_id = 1;

-- drop index if exists ticket_session;