select m.name as movie_name, sum(t.price) as total_price
from movies m
         join sessions s on s.movie_id = m.id
         join tickets t on t.session_id = s.id
group by m.name
order by total_price desc
limit 1;