-- выбор всех фильмов на сегодня
explain analyse
select m.name as movie_name, s.start_time, s.end_time
from movies m
         join sessions s on m.id = s.movie_id
where s.start_time::date = current_date;

-- подсчёт проданных билетов за неделю
explain analyse
select count(t.id) as sold_tickets
from tickets t
         join sessions s on t.session_id = s.id
where t.purchase_time >= current_date - interval '7 days';

-- формирование афиши
explain analyse
select m.name as movie_name, s.start_time, s.end_time
from movies m
         join sessions s on m.id = s.movie_id
where s.start_time::date = current_date;

-- 3 самых прибыльных фильмов за неделю
explain analyse
select m.name as movie_name, sum(t.price) as total_revenue
from tickets t
         join sessions s on t.session_id = s.id
         join movies m on s.movie_id = m.id
where t.purchase_time >= current_date - interval '7 days'
group by m.id
order by total_revenue desc
limit 3;

-- схема зала
explain analyse
select s.seat_number, s.row_number,
       case
           when t.id is not null then 'занято'
           else 'свободно'
           end as seat_status
from seats s
         left join tickets t on s.id = t.seat_id
where s.hall_id = 1 and t.session_id = 1;

-- диапазон минимальной и максимальной цены за билет на конкретный сеанс
explain analyse
select min(t.price) as min_price, max(t.price) as max_price
from tickets t
where t.session_id = 1;

