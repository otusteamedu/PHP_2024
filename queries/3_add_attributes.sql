insert into attribute_type
    (name, type)
values
    ('review', 'varchar'),
    ('award', 'bool'),
    ('main_date', 'timestamp'),
    ('service_date', 'timestamp');

insert into film_attribute
    (name, type_id)
values
    ('IVI', (SELECT id FROM attribute_type WHERE name = 'review')),
    ('OKO', (SELECT id FROM attribute_type WHERE name = 'review')),
    ('Vitaliy', (SELECT id FROM attribute_type WHERE name = 'review')),
    ('Oscar', (SELECT id FROM attribute_type WHERE name = 'award')),
    ('Nika', (SELECT id FROM attribute_type WHERE name = 'award')),
    ('date_premier_russia', (SELECT id FROM attribute_type WHERE name = 'main_date')),
    ('date_premier_world', (SELECT id FROM attribute_type WHERE name = 'main_date')),
    ('date_ticket_sale_start', (SELECT id FROM attribute_type WHERE name = 'service_date')),
    ('date_tv_advertisement_start', (SELECT id FROM attribute_type WHERE name = 'service_date'));
