CREATE TABLE film 
(
    Id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    created_on TIMESTAMP(0) NOT NULL DEFAULT NOW(), 
    edit_on TIMESTAMP(0) NOT NULL DEFAULT NOW()
);

CREATE TABLE attribute_type
(
    Id SERIAL PRIMARY KEY,
    type_name VARCHAR(20) NOT NULL
);

CREATE TABLE attribute
(
    Id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    created_on TIMESTAMP(0) NOT NULL DEFAULT NOW(), 
    edit_on TIMESTAMP(0) NOT NULL DEFAULT NOW(),

    attribute_type_id INTEGER,
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_type (Id)
);

CREATE TABLE attribute_value
(
    Id SERIAL PRIMARY KEY,
    integer_value INTEGER DEFAULT NULL,
    numeric_value NUMERIC DEFAULT NULL,
    text_value TEXT DEFAULT NULL,
    bolean_value BOOLEAN DEFAULT NULL,
    datetime_value TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,

    film_id INTEGER,
    FOREIGN KEY (film_id) REFERENCES film (Id) ON DELETE CASCADE,
    attribute_id INTEGER,
    FOREIGN KEY (attribute_id) REFERENCES attribute (Id)
);



INSERT INTO attribute_type(type_name)
VALUES
('integer'),
('numeric'),
('text'),
('boolean'),
('datetime');

INSERT INTO attribute (name, attribute_type_id)
VALUES
('Описание', 2),
('Теги', 2),
('Режиссёр', 2),
('Премьера', 4),
('Продолжительность (мин)', 0);

INSERT INTO film (name)
VALUES
('Ворон'),
('Ларго Винч: Гнев прошлого'),
('Лунтик. Возвращение домой');

INSERT INTO attribute_value (film_id, attribute_id, text_value) 
VALUES
--описания
(0, 0, 'Пожертвовав собой, чтобы спасти возлюбленную, Эрик Дрэйвен застревает между мирами живых и мёртвых. Вернувшись с того света, он не остановится ни перед чем, чтобы свести счёты с убийцами. Отныне он Ворон, жаждущий справедливости, и его месть будет жестока как никогда.'),
(1, 0, 'Во время семейного отпуска у красавца и миллиардера Ларго Винча похищают сына. Одновременно Ларго оказывается обвинённым в убийстве. Его объявляют в розыск международные спецслужбы. Бизнес-империя Ларго начинает рушиться. Только поняв, как связаны между собой эти разрозненные события и окунувшись в прошлое своей семьи, Ларго Винч сможет противостоять гневу загадочного и всемогущего противника и спасти сына.'),
(2, 0, 'Новые приключения Лунтика и его друзей — кузнечика Кузи,​ Пчелёнка, бабочки Элины, гусениц Вупсня и Пупсня и других.​ На этот раз весёлая компания решает помочь Лунтику найти маму и вернуться домой на Луну. Для этого Лунтику необходимо взобраться на Чёрную гору, дорога на которую полна приключений и опасностей. Дружба будет подвергаться сложным испытаниям, но добрые и верные товарищи сумеют преодолеть любые преграды.Новые приключения Лунтика и его друзей — кузнечика Кузи,​ Пчелёнка, бабочки Элины, гусениц Вупсня и Пупсня и других.​ На этот раз весёлая компания решает помочь Лунтику найти маму и вернуться домой на Луну. Для этого Лунтику необходимо взобраться на Чёрную гору, дорога на которую полна приключений и опасностей. Дружба будет подвергаться сложным испытаниям, но добрые и верные товарищи сумеют преодолеть любые преграды.'),
--теги
(0, 1, 'Кино'),
(0, 1, 'Фэнтези'),
(0, 1, 'Боевик'),
(0, 1, 'Триллер'),
(0, 1, 'Мелодрама'),
(0, 1, 'Криминальный'),
(0, 1, '18+'),
   
(1, 1, 'Кино'),
(1, 1, 'Боевик'),
(1, 1, 'Триллер'),
(1, 1, 'Приключения'),
(1, 1, '16+'),

(2, 1, 'Кино'),
(2, 1, 'Мультфильм'),
(2, 1, 'Приключения'),
(2, 1, 'Детям'),
(2, 1, '0+'),

--режессеры
(0, 2, 'Руперт Сандерс'),
(1, 2, 'Оливье Массе-Депасс'),
(2, 2, 'Константин Бронзит');

INSERT INTO attribute_value (film_id, attribute_id, datetime_value) 
VALUES
--даты приемьеры
(0, 3, CURRENT_DATE),
(1, 3, CURRENT_DATE),
(2, 3, CURRENT_DATE + INTERVAL '20 days');

INSERT INTO attribute_value (film_id, attribute_id, integer_value) 
VALUES
--продолжительность
(0, 4, 111),
(1, 4, 100),
(2, 4, 78);



--фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
CREATE VIEW actual_today (film_name, attribute_name) AS
SELECT f.name, atr.name from attribute_value atr_v
JOIN attribute atr ON atr.Id = atr_v.attribute_id
JOIN attribute_type atr_t ON atr_t.Id = atr.attribute_type_id
JOIN film f ON f.id = atr_v.film_id
WHERE atr_v.datetime_value = CURRENT_DATE
ORDER BY f.name, atr.name;

CREATE VIEW actual_after_20_days (film_name, attribute_name) AS
SELECT f.name, atr.name from attribute_value atr_v
JOIN attribute atr ON atr.Id = atr_v.attribute_id
JOIN attribute_type atr_t ON atr_t.Id = atr.attribute_type_id
JOIN film f ON f.id = atr_v.film_id
WHERE atr_v.datetime_value = (CURRENT_DATE + INTERVAL '20 days')
ORDER BY f.name, atr.name;

--фильм, тип атрибута, атрибут, значение (значение выводим как текст)
CREATE VIEW poster(film_name, attribute_type_name, attribute_name, attribute_value_text) AS
SELECT f.name, atr_t.type_name, atr.name,
    CASE 
        WHEN atr_t.type_name = 'integer' THEN atr_v.integer_value:: TEXT
        WHEN atr_t.type_name = 'numeric' THEN atr_v.numeric_value:: TEXT
        WHEN atr_t.type_name = 'datetime' THEN atr_v.datetime_value:: TEXT
        WHEN atr_t.type_name = 'boolean' THEN 
            CASE 
                WHEN atr_v.bolean_value = TRUE THEN 'да'
                ELSE 'нет'
            END
        ELSE atr_v.text_value
    END
FROM attribute_value atr_v
JOIN attribute atr ON atr.Id = atr_v.attribute_id
JOIN attribute_type atr_t ON atr_t.Id = atr.attribute_type_id
JOIN film f ON f.Id = atr_v.film_id
ORDER BY f.name, atr.name, atr_t.type_name;