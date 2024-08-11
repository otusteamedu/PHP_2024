delete
from attribute_value;
delete
from attribute;
delete
from movie;
delete
from attribute_type;

insert into movie (id, title)
values (1, '1+1'),
       (2, 'Интерстеллар'),
       (3, 'Зеленая миля'),
       (4, 'Побег из Шоушенка'),
       (5, 'Бойцовский клуб'),
       (6, 'Законопослушный гражданин');

insert into attribute_type (id, type_name)
values (1, 'timestamp'),
       (2, 'boolean'),
       (3, 'text'),
       (4, 'float');

insert into attribute (id, name, type_id, title)
values (1, 'created_at', 1, 'Дата создания'),
       (2, 'world_release_at', 1, 'День мировой премьеры'),
       (3, 'oscar_nominee', 2, 'Номинирован на оскар'),
       (4, 'emmy_nominee', 2, 'Номинирован на Эмми'),
       (5, 'imdb_review', 3, 'Рецензия на imdb'),
       (6, 'hollywood_reporter_article', 3, 'Рецензия в Hollywood Reporter'),
       (7, 'russia_release_date', 1, 'День премьеры в России'),
       (8, 'first_session', 1, 'День начала показов в кинотеатре'),
       (9, 'last_session', 1, 'День окончания показов в кинотеатре'),
       (10, 'price_review', 1, 'День коррекции цен');

insert into attribute_value(id, attribute_id, movie_id, text_value, bool_value, timestamp_value)
values (1, 1, 1, null, null, '1997-01-12'),
       (2, 1, 2, null, null, '2012-01-12'),
       (3, 1, 3, null, null, '2014-01-12'),
       (4, 1, 4, null, null, '1999-12-23'),
       (5, 1, 5, null, null, '2023-08-04'),
       (6, 1, 6, null, null, '2024-02-28'),

       (7, 2, 1, null, null, '1997-02-12'),
       (8, 2, 2, null, null, '2012-04-23'),
       (9, 2, 4, null, null, '2014-03-17'),
       (10, 2, 6, null, null, '2023-08-04'),

       (11, 3, 1, null, true, null),
       (12, 3, 6, null, true, null),

       (13, 4, 1, null, true, null),
       (14, 4, 4, null, true, null),
       (15, 4, 5, null, true, null),
       (16, 4, 6, null, true, null),

       (17, 5, 1, 'titanic imdb_review', null, null),
       (18, 5, 2, 'batman imdb_review', null, null),
       (19, 5, 4, 'oppenheimer imdb_review', null, null),
       (20, 5, 5, 'Oppenheimer imdb_review', null, null),

       (21, 6, 3, 'iron man hollywood_reporter article', null, null),
       (22, 6, 6, 'dune 2 hollywood_reporter', null, null),

       (23, 7, 5, null, null, '2023-08-21'),
       (24, 7, 6, null, null, '2024-03-30'),

       (25, 8, 4, null, null, '2024-03-30'),
       (26, 8, 6, null, null, '2024-03-23');

insert into attribute_value(id, attribute_id, movie_id, timestamp_value)
values (27, 9, 1, '2024-03-24'),
       (28, 9, 2, '2024-03-12'),
       (29, 9, 3, '2024-03-01'),
       (30, 9, 4, '2024-03-12'),
       (31, 8, 5, '2024-03-01'),

       (32, 10, 1, '2024-03-21'),
       (33, 10, 2, '2024-03-16'),
       (34, 10, 3, '2024-03-18')
