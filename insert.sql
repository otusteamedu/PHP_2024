-- INSERT

insert into movies (id, name)
values (1, 'Ёлки 11'),
       (2, 'Охота на воров 2: Пантера');

insert into attribute_types (id, value_type)
values (1, 'String'),
       (2, 'Text'),
       (3, 'Date'),
       (4, 'Integer'),
       (5, 'Bool'),
       (6, 'Float');

insert into attributes (id, name, attribute_type_id)
values (1, 'Жанр ', 1),
       (2, 'Описание', 2),
       (3, 'Рейтинг', 6),
       (4, 'Цена билета без учета коэффициента места', 4),
       (5, 'Длительность (минуты)', 4),
       (6, 'Оскар Гремми', 5),
       (7, 'Дата начала показа', 3),
       (8, 'Дата начала рекламной кампании', 3),
       (9, 'Дата окончания показа', 3);

insert into values (id, movie_id,
                    attribute_id,
                    value_string,
                    value_text,
                    value_integer,
                    value_float,
                    value_date,
                    value_boolean)
values (1, 1, 1, 'Комедия', null, null, null, null, null),
       (2, 1, 2, null, 'Основные события разворачиваются в Альметьевске накануне Нового года. ' ||
                       'Главной героиней станет молодая девушка, мечтающая встретить своего мужчину ' ||
                       'мечты — турецкого актера Бурака Озчивита. ' ||
                       'В этой новелле также появится злая мачеха и доброжелательный парень по имени Дамир.', null,
        null, null, null),
       (3, 1, 3, null, null, null, 2.0, null, null),
       (4, 1, 4, null, null, 500, null, null, null),
       (5, 1, 5, null, null, 96, null, null, null),
       (6, 1, 6, null, null, null, null, null, false),
       (7, 1, 7, null, null, null, null, '2024-12-19', null),
       (8, 1, 8, null, null, null, null, '2024-12-01', null),
       (9, 1, 9, null, null, null, null, '2025-01-21', null),


       (10, 2, 1, 'Комедия', null, null, null, null, null),
       (11, 2, 2, null, 'Большой Ник возвращается на охоту. В этот раз его цель находится в Европе: ' ||
                        'Донни теперь крутится в коварном и непредсказуемом мире воров драгоценностей и связан со знаменитой ' ||
                        'мафией «Пантера», с которой планирует грандиозное ограбление крупнейшей в мире алмазной биржи.',
        null, null, null, null),
       (12, 2, 3, null, null, null, 3.0, null, null),
       (13, 2, 4, null, null, 600, null, null, null),
       (14, 2, 5, null, null, 130, null, null, null),
       (15, 2, 6, null, null, null, null, null, true),
       (16, 2, 7, null, null, null, null, '2025-01-09', null),
       (17, 2, 8, null, null, null, null, '2025-01-21', null),
       (18, 2, 9, null, null, null, null, '2025-02-05', null);

-- INDEX

CREATE INDEX index_movie_task_date ON values (value_date);
CREATE INDEX index_attribute_types_type ON attribute_types (value_type);