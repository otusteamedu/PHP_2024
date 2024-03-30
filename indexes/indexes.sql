-- primary keys уже создал при создании таблиц и связей между ними.


drop index if exists ticket_date;
create index ticket_date on public.ticket (date);
-- индекс уменьшил стоимость запроса в query2 и query4


drop index if exists movie_start_date;
create index movie_start_date on public.movie (start_date);
-- индекс никак не ускорил запросы, можно удалять
