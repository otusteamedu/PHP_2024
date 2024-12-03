INSERT INTO film (title, "date") values
('фильм 1', '2024-12-25'),
('фильм 2', '2024-12-30')
;

INSERT INTO attribute (title) values
('рецензия'),
('премия'),
('важные даты'),
('служебные даты')
;

INSERT INTO attribute_type (title, attribute_id) values
('string', (select id from attribute where title='рецензия')),
('string', (select id from attribute where title='премия')),
('date',(select id from attribute where title='важные даты')),
('date', (select id from attribute where title='служебные даты'))
;

INSERT INTO attribute_value ("value", film_id, attribute_id ) values
('Интересное кино и сидения удобные!', (select id from film where title='фильм 1'), (select id from attribute where title='рецензия')),
('имени В.И. Ленина', (select id from film where title='фильм 1'), (select id from attribute where title='премия')),
('2024-12-10', (select id from film where title='фильм 1'), (select id from attribute where title='важные даты')),
('2024-12-11', (select id from film where title='фильм 1'), (select id from attribute where title='важные даты')),
('2024-12-29', (select id from film where title='фильм 1'), (select id from attribute where title='служебные даты')),
('Не смотрел, но описание на 3', (select id from film where title='фильм 2'), (select id from attribute where title='рецензия')),
('имени В.И. Пушкина', (select id from film where title='фильм 2'), (select id from attribute where title='премия')),
('2024-12-12', (select id from film where title='фильм 2'), (select id from attribute where title='важные даты')),
('2024-12-13', (select id from film where title='фильм 2'), (select id from attribute where title='важные даты')),
('2024-12-17', (select id from film where title='фильм 2'), (select id from attribute where title='служебные даты'))
;
