INSERT INTO movies (name)
VALUES ('Film_1'),
       ('Film_2');

INSERT INTO attributes (name)
VALUES ('critic_review'),
       ('film_academy_review'),
       ('nika'),
       ('oscar'),
       ('world_premiere_date'),
       ('russia_premiere_date'),
       ('sales_start_date'),
       ('advertising_start_date'),
       ('rating');

INSERT INTO attribute_types (name)
VALUES ('text'),
       ('boolean'),
       ('int'),
       ('num'),
       ('date');

INSERT INTO attribute_values (movie_id, attribute_id, attribute_type_id, value_text, value_boolean, value_int, value_num, value_date)
VALUES (1, 1, 1, 'Film 1 critic review ', null, null, null, null),
       (1, 2, 1, 'Film 1 academy review', null, null, null, null),
       (1, 4, 2, null, true, null, null, null),
       (1, 5, 5, null, null, null, null, CURRENT_DATE),
       (1, 6, 5, null, null, null, null, '2025-01-02'),
       (1, 8, 5, null, null, null, null, '2025-01-03'),
       (1, 7, 5, null, null, null, null, '2025-01-04'),
       (2, 1, 1, 'Film 2 critic review ', null, null, null, null),
       (2, 2, 1, 'Film 2 academy review', null, null, null, null),
       (2, 3, 2, null, true, null, null, null),
       (2, 4, 2, null, true, null, null, null),
       (2, 5, 5, null, null, null, null, '2025-02-05'),
       (2, 6, 5, null, null, null, null, '2025-02-06'),
       (2, 8, 5, null, null, null, null, '2025-02-07'),
       (2, 7, 5, null, null, null, null, '2025-02-08'),
       (1, 9, 4, null, null, null, 4.8, null),
       (2, 9, 4, null, null, null, 4.99, null);