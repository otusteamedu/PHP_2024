-- 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

select min(s.price) as min, max(s.price) as max
from public.session s
where s.movie_id = (
    select s.movie_id from session s where s.id = 3
)
group by s.movie_id;
