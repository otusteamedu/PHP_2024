select movie.title, sum(movie.most_expansive)
from (select m.title, s.basePrice, count(t.session_id) * s.basePrice as most_expansive
      from ticket t
               join session s on t.session_id = s.id
               join movie m on s.movie = m.id
      group by t.session_id, m.title, s.basePrice) as movie
group by movie.title
order by sum(movie.most_expansive) DESC limit 1;
