-- 4. Поиск 3 самых прибыльных фильмов за неделю

select movie, SUM(subtotal) as total
from (
    select (count(t.*) * s.price) as subtotal, m.name as movie
    from public.ticket t
    inner join public.session s on t.session_id = s.id
    inner join public.movie m on s.movie_id = m.id
    where t.date <= current_date and t.date >= (current_date - 6)
    group by t.session_id, s.price, m.name
) as subquery
group by movie
order by total DESC
limit 3;
