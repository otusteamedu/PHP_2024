# Создание представлений

## Создание служебного представления

```postgresql
CREATE VIEW sales_view AS
SELECT
    entities.title,
    attrs.label as label,
    values.value_date as value
FROM
    movie_entities as entities
JOIN
    movie_entity_attribute_values as values ON values.entity_id = entities.id
JOIN
    movie_entity_attributes as attrs ON attrs.id = values.attribute_id
WHERE
    attrs.code = 'sales_start_date' AND (values.value_date = CURRENT_DATE OR values.value_date = CURRENT_DATE + INTERVAL '20 days')
;
```

## Создание маркетингового представления

```postgresql
CREATE VIEW marketing_view AS
SELECT
    entities.title,
    attrs.label as attribute_label,
    COALESCE(
        values.value_text,
        values.value_date::date::text,
        values.value_int::int::text,
        values.value_bool::boolean::text,
        values.value_float::float::text
    ) AS attribute_value
FROM
    movie_entities as entities
JOIN
    movie_entity_attribute_values as values ON values.entity_id = entities.id
JOIN
    movie_entity_attributes as attrs ON attrs.id = values.attribute_id
;
```
