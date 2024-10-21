-- View сборки служебных данных в форме:
--   фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
create view movies_tasks as
select
    movies.title as movie,
    case
        when movie_attributes.value_date = CURRENT_DATE
            then attributes.name
        end
                as "today",
    case
        when movie_attributes.value_date = CURRENT_DATE + INTERVAL '20 days'
            then attributes.name
        end
                as "in 20 days"
from movies
         join movie_attributes
              on movie_attributes.movie_id = movies.id
                  and movie_attributes.attribute_id in (3, 4)
         join attributes
              on (attributes.id = movie_attributes.attribute_id)
where movie_attributes.value_date
          in (CURRENT_DATE, CURRENT_DATE + INTERVAL '20 days')
order by movie_attributes.value_date;

-- View сборки данных для маркетинга в форме (три колонки):
--   фильм, тип атрибута, атрибут, значение (значение выводим как текст)
create view movies_marketing as
select
    movies.title as movie,
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
              on movie_attributes.movie_id = movies.id
                  and movie_attributes.attribute_id not in (3, 4)
         join attributes
              on (attributes.id = movie_attributes.attribute_id)
         join attribute_types
              on (attribute_types.id = attributes.type_id);
