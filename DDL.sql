-- CREATE

create table if not exists movies
(
    id   serial primary key,
    name varchar(255)
);

create table if not exists attribute_types
(
    id         serial primary key,
    value_type varchar(64)
);

create table if not exists attributes
(
    id                serial primary key,
    name              varchar(255),
    attribute_type_id integer
        references attributes (id)
);


create table if not exists values
(
    id           serial primary key,
    movie_id     integer
        references movies (id),
    attribute_id integer
        references attributes (id),
    value        text
);

-- INSERT

insert into movies (id, name)
values (1, 'Ёлки 11'),
       (2, 'Охота на воров 2: Пантера');

insert into attribute_types (id, value_type)
values (1, 'String'),
       (2, 'Text'),
       (3, 'Date'),
       (4, 'Number'),
       (5, 'Bool');

insert into attributes (id, name, attribute_type_id)
values (1, 'Жанр ', 1),
       (2, 'Описание', 2),
       (3, 'Рейтинг', 4),
       (4, 'Цена билета без учета коэффициента места', 4),
       (5, 'Длительность (минуты)', 4),
       (6, 'Оскар Гремми', 5),
       (7, 'Дата начала показа', 3),
       (8, 'Дата начала рекламной кампании', 3),
       (9, 'Дата окончания показа', 3);

insert into values (id, movie_id, attribute_id, value)
values (1, 1, 1, 'Комедия'),
       (2, 1, 2,
        'Основные события разворачиваются в Альметьевске накануне Нового года. ' ||
        'Главной героиней станет молодая девушка, мечтающая встретить своего мужчину ' ||
        'мечты — турецкого актера Бурака Озчивита. ' ||
        'В этой новелле также появится злая мачеха и доброжелательный парень по имени Дамир.'),
       (3, 1, 3, '2.0'),
       (4, 1, 4, '500'),
       (5, 1, 5, '96'),
       (6, 1, 6, 'False'),
       (7, 1, 7, '2024-12-19'),
       (8, 1, 8, '2024-12-01'),
       (9, 1, 9, '2025-01-16');

insert into values (id, movie_id, attribute_id, value)
values (10, 2, 1, 'Комедия'),
       (11, 2, 2,
        'Большой Ник возвращается на охоту. В этот раз его цель находится в Европе: ' ||
        'Донни теперь крутится в коварном и непредсказуемом мире воров драгоценностей и связан со знаменитой ' ||
        'мафией «Пантера», с которой планирует грандиозное ограбление крупнейшей в мире алмазной биржи.'),
       (12, 2, 3, '3.0'),
       (13, 2, 4, '600'),
       (14, 2, 5, '130'),
       (15, 2, 6, 'True'),
       (16, 2, 7, '2025-01-09'),
       (17, 2, 8, '2025-01-01'),
       (18, 2, 9, '2025-02-05');

-- INDEX

CREATE INDEX index_movie_task_date ON values(value);
CREATE INDEX index_attribute_types_type ON attribute_types(value_type);

-- VIEW

-- View сборки данных для маркетинга
CREATE OR REPLACE VIEW movie_marketing as
select m.name                               as movie_name,
       a.name                               as attribute_name,
       v.value                              as value,
       CASE
           WHEN TO_DATE(v.value, 'YYYY-MM-DD') = CURRENT_DATE
               THEN 'Задачи на сегодня'
           WHEN TO_DATE(v.value, 'YYYY-MM-DD') = (CURRENT_DATE + INTERVAL '20 days')::date
               THEN 'Задачи на 20 дней' END as task
from movies m
         join values v on v.movie_id = m.id
         join attributes a on v.attribute_id = a.id
         join attribute_types at on a.attribute_type_id = at.id
where CASE
          WHEN at.value_type = 'Date'
              THEN TO_DATE(v.value, 'YYYY-MM-DD') = CURRENT_DATE
              OR TO_DATE(v.value, 'YYYY-MM-DD') = (CURRENT_DATE + INTERVAL '20 days')::date
          ELSE false END;

-- View сборки служебных данных
CREATE OR REPLACE VIEW movie_tasks as
select m.name as movie_name, a.name as attribute_name, v.value as value
from movies m
         join values v on v.movie_id = m.id
         join attributes a on v.attribute_id = a.id;
