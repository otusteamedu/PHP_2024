select SUM(t.price) as best_fees, f.name
from tickets as t
         inner join sessions s on s.id = tickets.session_id
         inner join films f on f.id = s.film_id
group by f.name
order by best_fees desc
limit 1
