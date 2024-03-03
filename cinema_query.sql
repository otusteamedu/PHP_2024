select m.name as movie, SUM(o.quantity * t.price) as total
from `order` o
         inner join ticket t on t.id = o.ticket_id
         inner join session s on t.session_id = s.id
         inner join movie m on s.movie_id = m.id
group by m.name
order by total DESC
limit 1