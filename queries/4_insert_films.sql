insert into film
    (name)
values
    ('Матрица'),
    ('Пятница'),
    ('Солнцестояние');

-- Матрица
insert into film_value
    (film_id, film_attribute_id, value_varchar, value_bool, value_float, value_integer, value_timestamp)
values
    (
        (SELECT id FROM film WHERE name='Матрица'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='Vitaliy' AND attribute_type.type='varchar'),
        'Сомнительный отзыв на Матрицу от эксперта Виталика',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM film WHERE name='Матрица'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='IVI' AND attribute_type.type='varchar'),
        '4/10 по оценке редакции',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM film WHERE name='Матрица'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='Oscar' AND attribute_type.type='bool'),
        null,
        true,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM film WHERE name='Матрица'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='Nika' AND attribute_type.type='bool'),
        null,
        true,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM film WHERE name='Матрица'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='date_premier_russia' AND attribute_type.type='timestamp'),
        null,
        null,
        null,
        null,
        '2024-04-04 10:30:00'
    ),
    (
        (SELECT id FROM film WHERE name='Матрица'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='date_premier_world' AND attribute_type.type='timestamp'),
        null,
        null,
        null,
        null,
        '2024-04-03 10:35:00'
    ),
    (
        (SELECT id FROM film WHERE name='Матрица'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='date_ticket_sale_start' AND attribute_type.type='timestamp'),
        null,
        null,
        null,
        null,
        '2024-01-01 05:25:00'
    ),
    (
        (SELECT id FROM film WHERE name='Матрица'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='date_tv_advertisement_start' AND attribute_type.type='timestamp'),
        null,
        null,
        null,
        null,
        '2024-04-07 05:25:00'
    );

-- Пятница (не полное заполнение)
insert into film_value
    (film_id, film_attribute_id, value_varchar, value_bool, value_float, value_integer, value_timestamp)
values
    (
        (SELECT id FROM film WHERE name='Пятница'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='Oscar' AND attribute_type.type='bool'),
        null,
        false,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM film WHERE name='Пятница'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='date_premier_russia' AND attribute_type.type='timestamp'),
        null,
        null,
        null,
        null,
        '2024-04-09 10:30:00'
    ),
    (
        (SELECT id FROM film WHERE name='Пятница'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='date_ticket_sale_start' AND attribute_type.type='timestamp'),
        null,
        null,
        null,
        null,
        '2024-04-08 05:25:00'
    ),
    (
        (SELECT id FROM film WHERE name='Пятница'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='date_tv_advertisement_start' AND attribute_type.type='timestamp'),
        null,
        null,
        null,
        null,
        '2024-04-08 03:25:00'
    );


-- Солнцестояние (не полное заполнение)
insert into film_value
    (film_id, film_attribute_id, value_varchar, value_bool, value_float, value_integer, value_timestamp)
values
    (
        (SELECT id FROM film WHERE name='Солнцестояние'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='OKO' AND attribute_type.type='varchar'),
        'Надо смотреть 99 из 9',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM film WHERE name='Солнцестояние'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='date_tv_advertisement_start' AND attribute_type.type='timestamp'),
        null,
        null,
        null,
        null,
        '2024-04-20 16:20:00'
    ),
    (
        (SELECT id FROM film WHERE name='Солнцестояние'),
        (SELECT film_attribute.id FROM film_attribute INNER JOIN attribute_type ON film_attribute.type_id = attribute_type.id WHERE film_attribute.name='date_premier_world' AND attribute_type.type='timestamp'),
        null,
        null,
        null,
        null,
        '2028-01-11 10:22:00'
    );