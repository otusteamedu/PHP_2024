create view film_attr_values as
    select f.title film_title, a.title attr_title, t.title attr_type, av.value attr_value
        from attribute_value av
        join attribute a on av.attribute_id = a.id
        join attribute_type t on a.id = t.attribute_id
        join film f on av.film_id = f.id
        order by film_title asc
;