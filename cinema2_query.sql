select movie, SUM(subtotal) as total
from (
    select COUNT(t.session_id) * s.price as subtotal, m.name as movie
        from ticket t
            inner join session s on t.session_id = s.id
            inner join movie m on s.movie_id = m.id
        group by t.session_id
    ) as subquery
group by movie
order by total DESC
limit 1

