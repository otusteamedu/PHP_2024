INSERT INTO movies (id, name) VALUES (1, 'movie1'), (2, 'movie2'), (3, 'movie3');
INSERT INTO attribute_types (id, name) VALUES (1, 'integer'), (2, 'text'), (3, 'bool'), (4, 'date'), (5, 'float');
INSERT INTO attributes (id, name, attribute_type) VALUES (1, 'reviews', 2), (2, 'award', 3), (3, 'important_date', 4), (4, 'service_date', 4);
INSERT INTO attribute_values (id, movie_id, attribute_id, int_value, text_value, bool_value, date_value) VALUES (1, 1, 1, NULL, 'Ревью к фильму 1', NULL, NULL),
    (2, 1, 2, NULL, NULL, True, NULL),
    (3, 1, 3, NULL, NULL, NULL, '2024-03-15'),
    (4, 1, 4, NULL, NULL, NULL, '2024-04-04'),
    (5, 2, 1, NULL, 'Ревью к фильму 2', NULL, NULL),
    (6, 2, 2, NULL, NULL, False, NULL),
    (7, 2, 3, NULL, NULL, NULL, '2024-03-15'),
    (8, 2, 4, NULL, NULL, NULL, '2024-01-01'),
    (9, 3, 1, NULL, 'Ревью к фильму 3', NULL, NULL),
    (10, 3, 2, NULL, NULL, True, NULL),
    (11, 3, 3, NULL, NULL, NULL, '2024-02-01'),
    (12, 3, 4, NULL, NULL, NULL, '2024-02-02');
