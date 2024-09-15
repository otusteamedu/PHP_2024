select films.name, sum(orders.sum) as film_total
from films
         inner join screenings on screenings.film_id = films.id
         inner join orders on orders.screening_id = screenings.id
where screening_date >= date_trunc('week', CURRENT_DATE)::date
  and screening_date <= date_trunc('week', CURRENT_DATE)::date + '7 days'::interval
group by films.id
order by film_total DESC
    limit 3