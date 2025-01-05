insert into movies (name)
values ('Грань будущего'),
       ('Миссия невыполнима'),
       ('Топ Ган: Мэверик'),
       ('Смерч 2'),
       ('Падение Олимпа'),
       ('Законопослушный гражданин');


insert into attribute_types (name, type)
values ('Рецензии', 'text'),
       ('Премия', 'boolean'),
       ('Важные даты', 'date'),
       ('Служебные даты', 'date');


insert into attributes (type_id, name)
values (1, 'Рецензии критиков'),
       (1, 'Отзыв киноакадемии'),
       (2, 'Оскар'),
       (2, 'Ника'),
       (3, 'Мировая премьера'),
       (3, 'Премьера в РФ'),
       (4, 'Дата начала продажи билетов'),
       (4, 'Запуск рекламы на ТВ');


insert into movie_attribute_values (movie_id, attribute_id, value_text)
values (1, 1, 'Замечательный фильм, жду продолжения');

insert into movie_attribute_values (movie_id, attribute_id, value_boolean)
values (3, 3, true);

insert into movie_attribute_values (movie_id, attribute_id, value_date)
values (6, 6, '2009-11-04');