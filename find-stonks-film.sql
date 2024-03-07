select tmp.title, sum(tmp.profit)
from (select m.title, s.ticket_cost, count(t.session_id) * s.ticket_cost as profit
      from ticket t
               join session s on t.session_id = s.id
               join movie m on s.movie = m.id
      group by t.session_id, m.title, s.ticket_cost) as tmp
group by tmp.title
order by sum(tmp.profit) DESC
limit 1;

