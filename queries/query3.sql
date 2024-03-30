-- 3. Формирование афиши (фильмы, которые показывают сегодня)

select m.name as movie, c.name as country, m.duration, m.description, string_agg(g.name, ', ')
from public.movie m
inner join public.country c on c.id = m.country_id
left join public.movie_genre mg on m.id = mg.movie_id
left join public.genre g on g.id = mg.genre_id
where m.start_date <= current_date and m.last_date is null
group by m.name, c.name, m.duration, m.description
order by m.name;