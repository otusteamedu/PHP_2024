select films.name
from films
inner join screenings on
    screenings.film_id = films.id and screenings.week_day = extract(isodow from current_date)