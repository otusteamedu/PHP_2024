/*Создаем таблицы*/

/*Таблица фильмов*/
DROP TABLE IF EXISTS public.movies CASCADE;
CREATE TABLE public.movies
(
    id          bigserial    NOT NULL,
    title       varchar(191) NOT NULL,

    CONSTRAINT movies_pkey PRIMARY KEY (id)
);

/*Enum для типов данных  для атрибутов */
DROP TYPE IF EXISTS value_type CASCADE;
CREATE TYPE value_type AS ENUM ('text', 'date', 'boolean', 'integer', 'float');

/*таблица типов аттрибутов*/
DROP TABLE IF EXISTS public.attribute_types CASCADE;
CREATE TABLE public.attribute_types
(
    id          bigserial    NOT NULL,
    title       varchar(191) NOT NULL,
    value_type  value_type NOT null,

    CONSTRAINT attribute_types_pkey PRIMARY KEY (id)
);

/*таблица аттрибутов*/
DROP TABLE IF EXISTS public.movie_attributes CASCADE;
CREATE TABLE public.movie_attributes
(
    id          		bigserial    NOT NULL,
    title       		varchar(191) NOT NULL,
    attribute_type_id   bigserial    NOT NULL,

    CONSTRAINT movie_attributes_pkey PRIMARY KEY (id),
    CONSTRAINT attribute_type_id_fk FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id) ON DELETE RESTRICT ON UPDATE cascade
);

/* добавляем индекс внешнему ключу*/
CREATE INDEX attribute_type_id_idx ON public.movie_attributes using btree (attribute_type_id);


DROP TABLE IF EXISTS public.values CASCADE;
CREATE TABLE public.values
(
    id          			bigserial    NOT NULL,
    movie_attribute_id     	bigserial    NOT NULL,
    movie_id   				bigserial    NOT NULL,
    text_value 				text default null,
    date_value 				timestamptz default null,
    boolean_value 		    boolean default null,
    integer_value 		    bigint default null,
    float_value 		    float default null,

    CONSTRAINT values_pkey PRIMARY KEY (id),
    CONSTRAINT movie_attribute_id_fk FOREIGN KEY (movie_attribute_id) REFERENCES movie_attributes (id) ON DELETE RESTRICT ON UPDATE cascade,
    CONSTRAINT movie_id_fk FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

/* добавляем индекс внешним ключам */
CREATE INDEX movie_attribute_id_idx ON public.values using btree (movie_attribute_id);
CREATE INDEX movie_id_idx ON public.values using btree (movie_id);


/* Заполняем таблицы данными для тестирования */
INSERT INTO public.movies (title) values
                                      ('Побег из Шоушенка'),
                                      ('Крёстный отец'),
                                      ('Тёмный рыцарь'),
                                      ('Крёстный отец 2'),
                                      ('12 разгневанных мужчин'),
                                      ('Список Шиндлера'),
                                      ('Властелин колец: Возвращение короля'),
                                      ('Криминальное чтиво'),
                                      ('Властелин колец: Братство Кольца'),
                                      ('Хороший, плохой, злой'),
                                      ('Форрест Гамп'),
                                      ('Властелин колец: Две крепости'),
                                      ('Бойцовский клуб'),
                                      ('Начало'),
                                      ('Звёздные войны. Эпизод V: Империя наносит ответный удар'),
                                      ('Матрица'),
                                      ('Славные парни'),
                                      ('Пролетая над гнездом кукушки'),
                                      ('Интерстеллар'),
                                      ('Семь'),
                                      ('Эта прекрасная жизнь'),
                                      ('Семь самураев'),
                                      ('Молчание ягнят'),
                                      ('Спасти рядового Райана'),
                                      ('Город Бога'),
                                      ('Жизнь прекрасна'),
                                      ('Зелёная миля'),
                                      ('Терминатор 2: Судный день'),
                                      ('Звёздные войны. Эпизод IV: Новая надежда'),
                                      ('Назад в будущее'),
                                      ('Унесённые призраками'),
                                      ('Пианист'),
                                      ('Паразиты'),
                                      ('Психо'),
                                      ('Гладиатор'),
                                      ('Король Лев'),
                                      ('Человек-паук: Паутина вселенных'),
                                      ('Отступники'),
                                      ('Одержимость'),
                                      ('Американская история Икс'),
                                      ('Леон'),
                                      ('Могила светлячков'),
                                      ('Престиж'),
                                      ('Харакири'),
                                      ('Дюна: Часть вторая'),
                                      ('Подозрительные лица'),
                                      ('Касабланка'),
                                      ('1+1'),
                                      ('Новый кинотеатр «Парадизо»'),
                                      ('Новые времена'),
                                      ('Чужой'),
                                      ('Окно во двор'),
                                      ('Однажды на Диком Западе'),
                                      ('Огни большого города'),
                                      ('Джанго освобождённый'),
                                      ('Апокалипсис сегодня'),
                                      ('Помни'),
                                      ('ВАЛЛ-И'),
                                      ('Индиана Джонс: В поисках утраченного ковчега'),
                                      ('12-я неудача[англ.]'),
                                      ('Жизнь других'),
                                      ('Бульвар Сансет'),
                                      ('Мстители: Война бесконечности'),
                                      ('Тропы славы'),
                                      ('Человек-паук: Через вселенные'),
                                      ('Свидетель обвинения'),
                                      ('Сияние'),
                                      ('Великий диктатор'),
                                      ('Чужие'),
                                      ('Бесславные ублюдки'),
                                      ('Тёмный рыцарь: Возрождение легенды'),
                                      ('Тайна Коко'),
                                      ('Амадей'),
                                      ('Доктор Стрейнджлав, или Как я перестал бояться и полюбил бомбу'),
                                      ('История игрушек'),
                                      ('Олдбой'),
                                      ('Красота по-американски'),
                                      ('Мстители: Финал'),
                                      ('Храброе сердце'),
                                      ('Подводная лодка'),
                                      ('Умница Уилл Хантинг'),
                                      ('Принцесса Мононоке'),
                                      ('Джокер'),
                                      ('Твоё имя'),
                                      ('Рай и ад'),
                                      ('3 идиота'),
                                      ('Однажды в Америке'),
                                      ('Поющие под дождём'),
                                      ('Капернаум'),
                                      ('Иди и смотри'),
                                      ('Реквием по мечте'),
                                      ('История игрушек: Большой побег'),
                                      ('Звёздные войны. Эпизод VI: Возвращение джедая'),
                                      ('Вечное сияние чистого разума'),
                                      ('Охота'),
                                      ('Космическая одиссея 2001 года'),
                                      ('Жить'),
                                      ('Бешеные псы'),
                                      ('Лоуренс Аравийский'),
                                      ('Квартира'),
                                      ('Пожары'),
                                      ('Оппенгеймер'),
                                      ('К северу через северо-запад'),
                                      ('Лицо со шрамом'),
                                      ('Гражданин Кейн'),
                                      ('Двойная страховка'),
                                      ('М'),
                                      ('Головокружение'),
                                      ('Цельнометаллическая оболочка'),
                                      ('Схватка'),
                                      ('Амели'),
                                      ('Вверх'),
                                      ('Заводной апельсин'),
                                      ('Убить пересмешника'),
                                      ('Развод Надера и Симин'),
                                      ('Афера'),
                                      ('Крепкий орешек'),
                                      ('Индиана Джонс и последний крестовый поход'),
                                      ('Звёздочки на земле'),
                                      ('Метрополис'),
                                      ('Большой куш'),
                                      ('1917'),
                                      ('Секреты Лос-Анджелеса'),
                                      ('Похитители велосипедов'),
                                      ('Гамильтон'),
                                      ('Таксист'),
                                      ('Бункер'),
                                      ('Дангал'),
                                      ('Бэтмен: Начало'),
                                      ('На несколько долларов больше'),
                                      ('Волк с Уолл-стрит'),
                                      ('Зелёная книга'),
                                      ('В джазе только девушки'),
                                      ('Малыш'),
                                      ('Нюрнбергский процесс'),
                                      ('Шоу Трумана'),
                                      ('Отец'),
                                      ('Всё о Еве'),
                                      ('Остров проклятых'),
                                      ('Нефть'),
                                      ('Топ Ган: Мэверик'),
                                      ('Парк юрского периода'),
                                      ('Казино'),
                                      ('Ран'),
                                      ('Шестое чувство'),
                                      ('Лабиринт фавна'),
                                      ('Непрощённый'),
                                      ('Старикам тут не место'),
                                      ('Нечто'),
                                      ('Игры разума'),
                                      ('Убить Билла. Фильм 1'),
                                      ('Сокровища Сьерра-Мадре'),
                                      ('Телохранитель'),
                                      ('Большой побег'),
                                      ('Монти Пайтон и Священный Грааль'),
                                      ('В поисках Немо'),
                                      ('Пленницы'),
                                      ('Ходячий замок'),
                                      ('Расёмон'),
                                      ('Человек-слон'),
                                      ('В случае убийства набирайте «М»'),
                                      ('Китайский квартал'),
                                      ('Унесённые ветром'),
                                      ('Карты, деньги, два ствола'),
                                      ('Тайна в его глазах'),
                                      ('Головоломка'),
                                      ('V — значит вендетта'),
                                      ('Бешеный бык'),
                                      ('Три билборда на границе Эббинга, Миссури'),
                                      ('На игле'),
                                      ('Мост через реку Квай'),
                                      ('Клаус'),
                                      ('Поймай меня, если сможешь'),
                                      ('Фарго'),
                                      ('Воин'),
                                      ('Человек-паук: Нет пути домой'),
                                      ('Гран Торино'),
                                      ('Гарри Поттер и Дары Смерти. Часть 2'),
                                      ('Малышка на миллион'),
                                      ('Мой сосед Тоторо'),
                                      ('Безумный Макс: Дорога ярости'),
                                      ('Дети небес'),
                                      ('12 лет рабства'),
                                      ('Бен-Гур'),
                                      ('Перед рассветом'),
                                      ('Бегущий по лезвию'),
                                      ('Барри Линдон'),
                                      ('Отель «Гранд Будапешт»'),
                                      ('По соображениям совести'),
                                      ('Исчезнувшая'),
                                      ('Общество мёртвых поэтов'),
                                      ('Махарадж[англ.]'),
                                      ('Воспоминания об убийстве'),
                                      ('Во имя отца'),
                                      ('Золотая лихорадка'),
                                      ('Корпорация монстров'),
                                      ('Дикие истории'),
                                      ('Охотник на оленей'),
                                      ('Генерал'),
                                      ('Челюсти'),
                                      ('Шерлок-младший'),
                                      ('Как приручить дракона'),
                                      ('В порту'),
                                      ('Рататуй'),
                                      ('Мэри и Макс'),
                                      ('Плата за страх'),
                                      ('Третий человек'),
                                      ('Земляничная поляна'),
                                      ('Ford против Ferrari'),
                                      ('Мистер Смит едет в Вашингтон'),
                                      ('Токийская повесть'),
                                      ('Логан'),
                                      ('Рокки'),
                                      ('Большой Лебовски'),
                                      ('Седьмая печать'),
                                      ('Комната'),
                                      ('В центре внимания'),
                                      ('Терминатор'),
                                      ('Отель Руанда'),
                                      ('Взвод'),
                                      ('Ненависть'),
                                      ('Пираты Карибского моря: Проклятие «Чёрной жемчужины»'),
                                      ('Перед закатом'),
                                      ('Страсти Жанны д’Арк'),
                                      ('Да прольётся свет[англ.]'),
                                      ('Лучшие годы нашей жизни'),
                                      ('Изгоняющий дьявола'),
                                      ('Гонка'),
                                      ('Суперсемейка'),
                                      ('Волшебник страны Оз'),
                                      ('Телесеть'),
                                      ('Останься со мной'),
                                      ('Хатико: Самый верный друг'),
                                      ('Звуки музыки'),
                                      ('Мой отец и мой сын'),
                                      ('Служанка'),
                                      ('Быть или не быть'),
                                      ('В диких условиях'),
                                      ('Битва за Алжир'),
                                      ('День сурка'),
                                      ('Гроздья гнева'),
                                      ('Стальной гигант');


insert into public.attribute_types (title, value_type) values
                                                           ('рецензии', 'text'),
                                                           ('премия', 'boolean'),
                                                           ('важные даты', 'date'),
                                                           ('служебные даты', 'date');

insert into public.movie_attributes (title, attribute_type_id) values
                                                                   ('Кинопоиск', 1),
                                                                   ('film.ru', 1),
                                                                   ('Золотой глобус', 2),
                                                                   ('Оскар', 2),
                                                                   ('Мировая премьера', 3),
                                                                   ('Премьера в РФ', 3),
                                                                   ('дата начала продажи билетов', 4),
                                                                   ('дата рекламы на ТВ', 4);



/* добавляем рецензии от кинопоиска*/
INSERT INTO public.values (movie_id, movie_attribute_id, text_value)
select id, 1, md5(random()::text) from movies;

/* добавляем рецензии от film.ru */
INSERT INTO public.values (movie_id, movie_attribute_id, text_value)
select id, 2, md5(random()::text) from movies;

/* добавляем ста случайным фильмам премии */
INSERT INTO public.values ( movie_id, movie_attribute_id,boolean_value)
SELECT floor(random() * 242)::int ,
        (array[3, 4])[floor(random() * 2 + 1)],
true
FROM generate_series(1,100) id;

/* добавляем всем фильмам дату мировой премьеры */
INSERT INTO public.values (movie_id, movie_attribute_id, date_value)
select id, 5, random() * ((NOW() + '6 MONTH'::interval) - (NOW() - '6 MONTH'::interval)) + (NOW() - '6 MONTH'::interval)  from movies;

/* добавляем всем фильмам дату премьеры в РФ */
INSERT INTO public.values (movie_id, movie_attribute_id, date_value)
select movie_id, 6, date_value + '5 days' from public.values where movie_attribute_id = 5;

/* добавляем всем фильмам дату начала продажи билетов */
INSERT INTO public.values (movie_id, movie_attribute_id, date_value)
select movie_id, 7, date_value - '30 days'::interval from public.values where movie_attribute_id = 5;

/* добавляем всем фильмам дату рекламы на ТВ */
INSERT INTO public.values (movie_id, movie_attribute_id, date_value)
select movie_id, 8, date_value - '40 days'::interval from public.values where movie_attribute_id = 5;

/*View сборки данных для маркетинга в форме (три колонки):
фильм, тип атрибута, атрибут, значение (значение выводим как текст)*/

CREATE OR REPLACE VIEW public.marketing AS
select
    m.title as movie,
    at2.title as attibute,
    ma.title as attribute_type,
    CASE at2.value_type
        WHEN 'integer' THEN v.integer_value::text
        WHEN 'float' THEN v.float_value::text
        WHEN 'boolean' THEN v.boolean_value::text
        WHEN 'text' THEN v.text_value
        WHEN 'date' THEN v.date_value::date::text
END AS value
from public.values v
join movies m on m.id = v.movie_id
join movie_attributes ma on v.movie_attribute_id = ma.id
join attribute_types at2 ON ma.attribute_type_id = at2.id
order by m.title, at2.title, ma.title;


select * from public.marketing;

/*View сборки служебных данных в форме: фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней*/

CREATE OR REPLACE VIEW public.tasks as
select title,
       today_tasks,
       in_20_days_tasks from
    (select m.title,
            string_agg( case when v.date_value::date = CURRENT_DATE then ma.title else NULL end, ',') as today_tasks,
            string_agg(case when date_value::date = (now() + '20 days')::date then ma.title else NULL end , ',') as in_20_days_tasks
     from public.values v
              join movies m on m.id = v.movie_id
              join movie_attributes ma on v.movie_attribute_id = ma.id
              join attribute_types at2 ON ma.attribute_type_id = at2.id
     where at2.id = 4 group by m.id) as tasks where tasks.today_tasks notnull or tasks.in_20_days_tasks notnull;


select * from public.tasks;

