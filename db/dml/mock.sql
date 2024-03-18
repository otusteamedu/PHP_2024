insert into movies (name) values ('movie1'), ('movie2'), ('movie3'), ('movie4'), ('movie5'), ('movie6');

insert into movies_attributes_types (name, type) values
('рецензия', 'text'),
('премия', 'boolean'),
('важная дата', 'date'),
('служебная дата', 'date');

insert into movies_attributes (type_id, name) values
(1, 'Рецензия критиков'),
(1, 'Отзыв неизвестной киноакадемии'),
(2, 'Оскар'),
(2, 'Ника'),
(3, 'Мировая премьераика'),
(3, 'Премьера в РФ'),
(4, 'дата начала продажи билетов'),
(4, 'когда запускать рекламу на ТВ');

insert into movies_attributes_values (movie_id, attribute_id, boolean_value) values
(1, 3, true),
(1, 4, true),
(5, 3, true),
(5, 4, true);

insert into movies_attributes_values (movie_id, attribute_id, text_value) values
(3, 1, 'лучшее, что я когда-либо видел в своей жизни'),
(6, 2, 'фильм на любителя'),
(4, 1, 'не стоит потраченного времени');

insert into movies_attributes_values (movie_id, attribute_id, date_value) values
(1, 7, '2024-03-25'),
(2, 8, '2024-04-10'),
(3, 8, '2024-04-20');