create view movies_tasks as
select
  movies.name as movie,
  case
    when movie_attributes.value_date = CURRENT_DATE
    then attributes.name
    else null
    end
  as "today",
  case
    when movie_attributes.value_date = CURRENT_DATE + INTERVAL '20 days'
    then attributes.name
    else null
    end
  as "in 20 days"
from movies
join movie_attributes
  on movie_attributes.movieId = movies.id
  and movie_attributes.attributeId in (7, 8)
join attributes
  on (attributes.id = movie_attributes.attributeId)
where movie_attributes.value_date
  in (CURRENT_DATE, CURRENT_DATE + INTERVAL '20 days')
order by movie_attributes.value_date;

create view movies_marketing as
select
  movies.name as movie,
  attribute_types.type,
  attributes.name,
  COALESCE(
    movie_attributes.value_boolean::text,
    movie_attributes.value_integer::text,
    movie_attributes.value_float::text,
    movie_attributes.value_date::text,
    movie_attributes.value_varchar
  ) AS value
from movies 
join movie_attributes
  on movie_attributes.movieId = movies.id
  and movie_attributes.attributeId not in (7, 8)
join attributes
  on (attributes.id = movie_attributes.attributeId)
join attribute_types
  on (attribute_types.id = attributes.typeId);