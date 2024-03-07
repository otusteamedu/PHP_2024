select a.title, sum(a.sum_cost) as sum_cost_per_movie
from (select s.movie as title, count(t.session_id) * s.ticket_cost as sum_cost
      from session s
               join ticket t on t.session_id = s.id
      group by s.movie, s.ticket_cost
      order by sum_cost desc) as a
group by title
order by sum_cost_per_movie DESC
limit 1;