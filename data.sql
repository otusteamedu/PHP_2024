INSERT INTO film (title, "date") values
     ('фильм 1', '2024-12-25'),
     ('фильм 2', '2024-12-30')
;

INSERT INTO attribute (title) values
      ('рецензия'),
      ('премия'),
      ('важные даты'),
      ('служебные даты'),
      ('оценка')
;

INSERT INTO attribute_type (title, data_type, attribute_id) values
    ('text', 'text', (select id from attribute where title='рецензия')),
    ('string', 'string', (select id from attribute where title='премия')),
    ('datetime', 'datetime', (select id from attribute where title='важные даты')),
    ('datetime', 'datetime',  (select id from attribute where title='служебные даты')),
    ('float', 'float', (select id from attribute where title='оценка'))
;

INSERT INTO attribute_value (value_date, film_id, attribute_id ) values
     ('2024-12-10', (select id from film where title='фильм 1'), (select id from attribute where title='важные даты')),
     ('2024-12-11', (select id from film where title='фильм 1'), (select id from attribute where title='важные даты')),
     ('2024-12-12', (select id from film where title='фильм 2'), (select id from attribute where title='важные даты')),
     ('2024-12-13', (select id from film where title='фильм 2'), (select id from attribute where title='важные даты')),
     ('2024-12-17', (select id from film where title='фильм 2'), (select id from attribute where title='служебные даты')),
     ('2024-12-29', (select id from film where title='фильм 1'), (select id from attribute where title='служебные даты'))
;

INSERT INTO attribute_value (value_text, film_id, attribute_id ) values
    ('Интересное кино и сидения удобные!', (select id from film where title='фильм 1'), (select id from attribute where title='рецензия')),
    ('Не смотрел, но описание на 3', (select id from film where title='фильм 2'), (select id from attribute where title='рецензия'))
;

INSERT INTO attribute_value (value_string, film_id, attribute_id ) values
    ('имени В.И. Ленина', (select id from film where title='фильм 1'), (select id from attribute where title='премия')),
    ('имени В.И. Пушкина', (select id from film where title='фильм 2'), (select id from attribute where title='премия'))
;

INSERT INTO attribute_value (value_float, film_id, attribute_id ) values
    (4.5, (select id from film where title='фильм 1'), (select id from attribute where title='оценка')),
    (4.6, (select id from film where title='фильм 2'), (select id from attribute where title='оценка'))
;