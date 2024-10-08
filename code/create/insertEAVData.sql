insert into attribute_types(id, type) values
                                      (1, 'boolean'),
                                      (2, 'integer'),
                                      (3, 'float'),
                                      (4, 'date'),
                                      (5, 'varchar');

insert into attributes(id, name, type_id) values
                                         (1, 'рецензия критика', 5),
                                         (2, 'отзыв неизвестной киноакадемии', 5),
                                         (3, 'оскар', 1),
                                         (4, 'ника', 1),
                                         (5, 'мировая премьера', 4),
                                         (6, 'премьера в РФ', 4),
                                         (7, 'дата начала продажи билетов', 4),
                                         (8, 'когда запускать рекламу на ТВ', 4);

insert into movie_attributes(movie_id, attribute_id, value_varchar) values
                                                                      (1, 1, 'Пересматривая этот шедевр анимации, понимаешь, насколько он актуален и по сей день...'),
                                                                      (2, 2, 'Это продолжение истории о зеленом великане, который уже успел жениться на принцессе Фионе...');

insert into movie_attributes(movie_id, attribute_id, value_boolean) values
                                                                      (1, 3, true),
                                                                      (2, 4, false);

insert into movie_attributes(movie_id, attribute_id, value_date) values
                                                                   (1, 5, '2001-04-22'),
                                                                   (2, 6, '2004-08-19'),
                                                                   (1, 7, '2024-08-05'),
                                                                   (1, 8, '2024-08-25'),
                                                                   (2, 8, '2024-08-25'),
                                                                   (2, 7, '2024-08-05');
