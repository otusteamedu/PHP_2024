-- События актуальные на сегодня (служебные даты - сегодня)
SELECT
    film.id as film_id,
    film.name as film_name,
    film_attribute.name as film_attribute_name,
    film_value.value_timestamp as value
FROM film
    LEFT JOIN film_value
        ON film.id = film_value.film_id
    INNER JOIN film_attribute
        ON film_value.film_attribute_id = film_attribute.id
    INNER JOIN attribute_type
        ON film_attribute.type_id = attribute_type.id
WHERE
    attribute_type.name = 'service_date' AND
    attribute_type.type = 'timestamp' AND
    film_value.value_timestamp::date = current_date
ORDER BY
    film_value.value_timestamp ASC;

-- События актуальные на ближайшие 20 дней (служебные даты - от сегодня до +20 дней)
SELECT
    film.id as film_id,
    film.name as film_name,
    film_attribute.name as film_attribute_name,
    film_value.value_timestamp as value
FROM film
    LEFT JOIN film_value
        ON film.id = film_value.film_id
    INNER JOIN film_attribute
        ON film_value.film_attribute_id = film_attribute.id
    INNER JOIN attribute_type
        ON film_attribute.type_id = attribute_type.id
WHERE
    attribute_type.name = 'service_date' AND
    attribute_type.type = 'timestamp' AND
    film_value.value_timestamp::date >= current_date AND
    film_value.value_timestamp::date <= (current_date + interval '20 day')
ORDER BY
    film_value.value_timestamp ASC;

-- Информация по всем фильмам по всем атрибутам
SELECT
    film.name as film_name,
    attribute_type.type as film_attribute_type,
    film_attribute.name as film_attribute_name,
    coalesce(film_value.value_timestamp::varchar, '') ||
    coalesce(film_value.value_varchar::varchar, '') ||
    coalesce(film_value.value_bool::varchar, '') ||
    coalesce(film_value.value_float::varchar, '') ||
    coalesce(film_value.value_integer::varchar, '')
        as value
FROM film
    LEFT JOIN film_value
        ON film.id = film_value.film_id
    INNER JOIN film_attribute
        ON film_value.film_attribute_id = film_attribute.id
    INNER JOIN attribute_type
        ON film_attribute.type_id = attribute_type.id
ORDER BY film.id;