INSERT INTO movies (name, year, duration) VALUES
                                              ('Головоломка', '2015-06-19', 95),
                                              ('Король Лев', '1994-06-24', 88),
                                              ('Русалочка', '1989-11-17', 83),
                                              ('История игрушек', '1995-11-22', 81);

INSERT INTO attribute_types (type) VALUES
                                       ('text'),
                                       ('boolean'),
                                       ('date'),
                                       ('integer'),
                                       ('float'),
                                       ('string');

INSERT INTO movie_attributes (name, type_id) VALUES
                                           ('рецензии критиков', 1),
                                           ('отзыв неизвестной киноакадемии', 1),
                                           ('оскар', 2),
                                           ('ника', 2),
                                           ('мировая премьера', 3),
                                           ('премьера в РФ', 3),
                                           ('дата начала продажи билетов', 3),
                                           ('когда запускать рекламу на ТВ', 3);

INSERT INTO movie_values (movie_attribute_id, movie_id, value_text) VALUES
                                                            (1, 1, 'Отличный мультфильм с глубоким смыслом'),
                                                            (2, 1, 'Прекрасный фильм для детей и взрослых'),
                                                            (1, 2, 'Классика анимации'),
                                                            (2, 2, 'Великолепная музыка и история'),
                                                            (1, 3, 'Очаровательная история любви'),
                                                            (2, 3, 'Незабываемые персонажи и песни'),
                                                            (1, 4, 'Веселый и трогательный мультфильм'),
                                                            (2, 4, 'Пионер компьютерной анимации');

INSERT INTO movie_values (movie_attribute_id, movie_id, value_boolean) VALUES
                                                               (3, 1, true),
                                                               (4, 1, false),
                                                               (3, 2, true),
                                                               (4, 2, true),
                                                               (3, 3, false),
                                                               (4, 3, true),
                                                               (3, 4, true),
                                                               (4, 4, false);

INSERT INTO movie_values (movie_attribute_id, movie_id, value_date) VALUES
                                                            (5, 1, '2015-06-19'),
                                                            (6, 1, '2015-11-19'),
                                                            (7, 1, '2015-05-01'),
                                                            (8, 1, '2015-04-01'),
                                                            (5, 2, '1994-06-24'),
                                                            (6, 2, '1994-10-07'),
                                                            (7, 2, '1994-05-01'),
                                                            (8, 2, '1994-04-01'),
                                                            (5, 3, '1989-11-17'),
                                                            (6, 3, '1990-03-16'),
                                                            (7, 3, '1989-10-01'),
                                                            (8, 3, '1989-09-01'),
                                                            (5, 4, '1995-11-22'),
                                                            (6, 4, '1996-03-01'),
                                                            (7, 4, CURRENT_DATE),
                                                            (8, 4, CURRENT_DATE + INTERVAL '20 days');