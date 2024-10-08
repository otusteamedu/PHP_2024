-- 1. Выбор всех фильмов на сегодня
explain analyze
select movies.title as movies_today
from movies
         join sessions on movies.id = sessions.movie_id
where sessions.start_time::date = now()::date
group by movies.title;

-- 2. Подсчёт проданных билетов за неделю
explain analyze
select count(*) as weekly_sales_count
from tickets
where tickets.purchased_at <= now()
  and tickets.purchased_at > now() - interval '7 days';

-- 3. Формирование афиши (фильмы, которые показывают сегодня)
explain analyze
select movies.title as sessions_today, sessions.start_time, halls.name as hall
from movies
         join sessions on movies.id = sessions.movie_id
         join halls on sessions.hall_id = halls.id
where sessions.start_time::date = now()::date
order by sessions.start_time;

-- 4. Поиск 3 самых прибыльных фильмов за неделю
explain analyze
with RecentTickets as (select session_id, t.price
                       from tickets t
                                join public.ticket_prices tp on tp.id = t.ticket_price_id
                       where t.purchased_at <= now()
                         and t.purchased_at > now() - interval '7 days'),
     AggregatedRevenue as (select s.movie_id, sum(rt.price)
                           from RecentTickets rt
                                    join sessions s on s.id = rt.session_id
                           group by s.movie_id)
select m.title as top_profitable_movies, sum(ar.sum) as sum
from AggregatedRevenue ar
         join movies m on m.id = ar.movie_id
group by m.title
order by sum desc
limit 3;


-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
create extension if not exists tablefunc;
explain analyze
select *
from crosstab(
             $$
         select seats.row_number                                     as row_number,
                seats.seat_number                                    as seat_number,
                (case when t.purchased_at is not null then 'x' end)  as value
         from seats
             join ticket_prices tp on seats.id = tp.seat_id
             left join tickets t on tp.id = t.ticket_price_id
             join sessions on tp.session_id = sessions.id
         where sessions.id = 190796
         order by row_number, seat_number
     $$, $$
         select distinct seats.seat_number
         from seats
             join ticket_prices tp on seats.id = tp.seat_id
             left join tickets t on tp.id = t.ticket_price_id
             join sessions on tp.session_id = sessions.id
         where sessions.id = 190796
         order by seats.seat_number
     $$
     ) as ct(
             row int,
             "1" text, "2" text, "3" text, "4" text, "5" text,
             "6" text, "7" text, "8" text, "9" text, "10" text,
             "11" text, "12" text, "13" text, "14" text, "15" text,
             "16" text, "17" text, "18" text, "19" text, "20" text,
             "21" text, "22" text, "23" text, "24" text, "25" text
    );

-- 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
explain analyze
select min(price) || ' - ' || max(price) as price_range_42
from ticket_prices tp
where session_id = 176053
group by tp.session_id;
