-- Фильмы
INSERT INTO films (title, description, duration, start_date, end_date, age_rating, directors)
VALUES
    ('Девушка с татуировкой дракона', 'Журналиста Микаэля Блумквиста (Дэниэл Крэйг) приглашает к себе на остров крупный
    бизнесмен Хенрик Вагнер (Кристофер Пламмер) и просит разобраться в тайне сорокалетней давности — тогда пропала его
    племянница, о чьей судьбе с тех пор ничего не известно. В помощники к Блумквисту попадает хакерша Лисбет Саландер ..',
    151, '2024-12-01', '2025-01-30', 18, 'Дэвид Финчер'),
    ('Мистер Робот', 'Эллиот (Рами Малек) страдает от проблем с психикой и наркозависимостью, к тому же ведет двойную
    жизнь. Днем парень — специалист по кибербезопасности в большой компании. Ночью — хитрый хакер, вместе с коллегами
    стремящийся пошатнуть мировую экономику и отобрать власть у жадных корпораций.',
    60, '2024-12-09', '2025-02-10', 18, 'Сэм Эсмейл'),
    ('Пятая власть', 'История Джулиана Ассанжа (Бенедикт Камбербэтч), хакера и основателя сайта WikiLeaks, где за
    короткое время было опубликовано огромное количество государственных секретов разных стран — и обычно не
    самых приятных...', 123, '2024-12-15', '2025-02-14', 16, 'Билл Кондон')
;
-- Типы атрибутов
INSERT INTO attribute_types (name, data_type) values
      ('рецензия', 'text'),
      ('премия', 'string'),
      ('важные даты', 'date'),
      ('служебные даты', 'date')
;
-- Атрибуты
INSERT INTO attributes (film_id, name, type_id) values
    ((select film_id from films where title='Девушка с татуировкой дракона'), 'Критика', (select type_id from attribute_types where name='рецензия')),
    ((select film_id from films where title='Мистер Робот'), 'Золотой глобус', (select type_id from attribute_types where name='премия')),
    ((select film_id from films where title='Пятая власть'), 'Премьера в РФ', (select type_id from attribute_types where name='важные даты')),
    ((select film_id from films where title='Девушка с татуировкой дракона'), 'Дата начала продажи билетов', (select type_id from attribute_types where name='служебные даты'))
;

-- Значения атрибутов
INSERT INTO attributes_values (attribute_id, value_text) values
      ((select attribute_id from attributes where name='Критика'),
      'Вот пример креативного продюсерства — Скотт Рудин назначил режиссером «Девушки с татуировкой дракона» Дэвида
      Финчера и тем самым обрек фильм на успех.')
;
INSERT INTO attributes_values (attribute_id, value_date) values
      ((select attribute_id from attributes where name='Золотой глобус'), '2020-01-05')
;
INSERT INTO attributes_values (attribute_id, value_date) values
      ((select attribute_id from attributes where name='Премьера в РФ'), '2013-10-24')
;
INSERT INTO attributes_values (attribute_id, value_date) values
      ((select attribute_id from attributes where name='Дата начала продажи билетов'), '2024-12-20')
;

INSERT INTO attributes (film_id, name, type_id) values
    ((select film_id from films where title='Девушка с татуировкой дракона'), 'Дата начала рекламы', (select type_id from attribute_types where name='служебные даты'))
;

INSERT INTO attributes_values (attribute_id, value_date) values
    ((select attribute_id from attributes where name='Дата начала рекламы'), '2025-01-05')
;

INSERT INTO attributes (film_id, name, type_id) values
    ((select film_id from films where title='Мистер Робот'), 'Дата начала продажи билетов', (select type_id from attribute_types where name='служебные даты'))
;
INSERT INTO attributes_values (attribute_id, value_date) values
    (6, '2025-01-25')