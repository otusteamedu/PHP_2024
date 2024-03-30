-- 1. Выбор всех фильмов на сегодня

select m.name
from public.movie m
where m.start_date <= current_date and m.last_date is null;