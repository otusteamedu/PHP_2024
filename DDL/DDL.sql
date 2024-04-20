CREATE TABLE IF NOT EXISTS films (
    id          varchar(32) UNIQUE PRIMARY KEY,
    name        text
);

CREATE TABLE IF NOT EXISTS film_attribute_types (
    id          varchar(32) UNIQUE PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS film_attributes (
    id                  varchar(32) UNIQUE PRIMARY KEY,
    attributetype_id    varchar(32),
    name                text,
    FOREIGN KEY (attributetype_id) REFERENCES film_attribute_types(id)
);


CREATE TABLE IF NOT EXISTS values (
    film_id         varchar(32) ,
    attribute_id    varchar(32),
    value_text      text,
    value_date      date DEFAULT NULL,
    value_bool      bool DEFAULT NULL,
    value_float     decimal(11,2) DEFAULT NULL,
    value_int       integer DEFAULT NULL,
    FOREIGN KEY (film_id) REFERENCES films(id),
    FOREIGN KEY (attribute_id) REFERENCES film_attributes(id)
);

CREATE TABLE IF NOT EXISTS sessions (
    id          varchar(32) UNIQUE PRIMARY KEY,
    filmId      varchar(32),
    time        time,
    FOREIGN KEY (filmId) REFERENCES films(id)
);

CREATE TABLE IF NOT EXISTS seats (
    id          SERIAL UNIQUE PRIMARY KEY,
    hall        integer,
    row         integer,
    seat        integer,
    luxe        boolean,
    booked      boolean DEFAULT false
);

CREATE TABLE IF NOT EXISTS payers (
    id          varchar(32) UNIQUE PRIMARY KEY,
    ticketCount integer
);

CREATE TABLE IF NOT EXISTS tickets (
    id          integer UNIQUE PRIMARY KEY,
    payerId     varchar(32),
    sessionId   varchar(32),
    seatId      integer,
    amount      decimal(11,2),
    FOREIGN KEY (payerId) REFERENCES payers(id),
    FOREIGN KEY (sessionId) REFERENCES sessions(id),
    FOREIGN KEY (seatId) REFERENCES seats(id)
);

CREATE TABLE IF NOT EXISTS orders (
    id          integer UNIQUE PRIMARY KEY,
    payerId     varchar(32),
    sum         decimal(11,2),
    createTime   timestamp,
    FOREIGN KEY (payerId) REFERENCES payers(id)
);





INSERT INTO films VALUES ('master_i_margarita','Мастер и Маргарита'),('onegin','Онегин'),('duna_2','Дюна 2');

INSERT INTO attribute_types VALUES ('text'),('date'),('bool'),('float'),('integer');

INSERT INTO attributes VALUES ('reviews','text','Рецензии'),
                              ('award_oscar','bool','Премия Оскар'),
                              ('award_nika','bool','Премия Ника'),
                              ('world_premiere_date','date','Дата мировой премьеры'),
                              ('ru_premiere_date','date','Дата премьеры в России'),
                              ('ticket_trade_begin','date','Начало продажи билетов'),
                              ('ticket_trade_end','date','Окончание продажи билетов'),
                              ('seat_price','float','Стоимость места'),
                              ('seat_price_luxe','float','Стоимость Luxe-места'),
                              ('task_1','date','Напечатать плакаты'),
                              ('task_2','date','Запустить в продажу билеты'),
                              ('task_3','date','Подготовить залы'),
                              ('task_4','date','Запустить рекламу')
                              ;

INSERT INTO values VALUES ('master_i_margarita','reviews','Рецензия 1',null,null,null,null),
                          ('master_i_margarita','reviews','Рецензия 2',null,null,null,null),
                          ('master_i_margarita','award_oscar','',null,true,null,null),
                          ('master_i_margarita','award_nika','',null,false,null,null),
                          ('master_i_margarita','world_premiere_date','','2024-04-30 12:00:00',null,null,null),
                          ('master_i_margarita','ru_premiere_date','','2024-04-30 12:00:00',null,null,null),
                          ('master_i_margarita','ticket_trade_begin','','2024-04-25 12:00:00',null,null,null),
                          ('master_i_margarita','ticket_trade_end','','2024-05-15 12:00:00',null,null,null),
                          ('master_i_margarita','seat_price','',null,null,500.00,null),
                          ('master_i_margarita','seat_price_luxe','',null,null,600.00,null),
                          ('master_i_margarita','task_1','',CURRENT_DATE,null,null,null),
                          ('master_i_margarita','task_2','',CURRENT_DATE,null,null,null),
                          ('master_i_margarita','task_3','',CURRENT_DATE + INTERVAL '20 days',null,null,null),
                          ('master_i_margarita','task_4','',CURRENT_DATE + INTERVAL '20 days',null,null,null),

                          ('onegin','reviews','Рецензия 1',null,null,null,null),
                          ('onegin','reviews','Рецензия 2',null,null,null,null),
                          ('onegin','award_oscar','',null,true,null,null),
                          ('onegin','award_nika','',null,true,null,null),
                          ('onegin','world_premiere_date','','2024-04-29 12:00:00',null,null,null),
                          ('onegin','ru_premiere_date','','2024-04-29 12:00:00',null,null,null),
                          ('onegin','ticket_trade_begin','','2024-04-24 12:00:00',null,null,null),
                          ('onegin','ticket_trade_end','','2024-05-15 12:00:00',null,null,null),
                          ('onegin','seat_price','',null,null,550.00,null),
                          ('onegin','seat_price_luxe','',null,null,650.00,null),
                          ('onegin','task_1','',CURRENT_DATE,null,null,null),
                          ('onegin','task_2','',CURRENT_DATE + INTERVAL '20 days',null,null,null),
                          ('onegin','task_3','',CURRENT_DATE,null,null,null),
                          ('onegin','task_4','',CURRENT_DATE + INTERVAL '20 days',null,null,null),

                          ('duna_2','reviews','Рецензия 1',null,null,null,null),
                          ('duna_2','reviews','Рецензия 2',null,null,null,null),
                          ('duna_2','award_oscar','',null,false,null,null),
                          ('duna_2','award_nika','',null,false,null,null),
                          ('duna_2','world_premiere_date','','2024-04-29 12:00:00',null,null,null),
                          ('duna_2','ru_premiere_date','','2024-04-29 12:00:00',null,null,null),
                          ('duna_2','ticket_trade_begin','','2024-04-24 12:00:00',null,null,null),
                          ('duna_2','ticket_trade_end','','2024-05-15 12:00:00',null,null,null),
                          ('duna_2','seat_price','',null,null,600.00,null),
                          ('duna_2','seat_price_luxe','',null,null,700.00,null),
                          ('duna_2','task_1','',CURRENT_DATE + INTERVAL '20 days',null,null,null),
                          ('duna_2','task_2','',CURRENT_DATE + INTERVAL '20 days',null,null,null),
                          ('duna_2','task_3','',CURRENT_DATE,null,null,null),
                          ('duna_2','task_4','',CURRENT_DATE,null,null,null)
                          ;


CREATE INDEX IND_VALUES
    ON values(film_id,attribute_id,value_bool,value_date,value_text,value_float,value_int);

CREATE VIEW system_data AS
SELECT f.name Фильм,
       CASE WHEN value_date::date = CURRENT_DATE THEN a.name END AS Задачи_на_сегодня,
       CASE WHEN value_date::date = CURRENT_DATE + INTERVAL '20 days' THEN a.name END AS Задачи_на_будущее
FROM (SELECT * FROM values WHERE attribute_id LIKE 'task_%') AS vals
         JOIN films f on f.id = film_id
         JOIN attributes a on a.id = attribute_id
;

CREATE VIEW marketing AS
SELECT f.name Фильмы, at.id Тип_аттрибута, a.name Аттрибут,
        CASE WHEN at.id = 'bool' THEN values.value_bool::text
            WHEN at.id = 'date'THEN values.value_date::text
            WHEN at.id = 'text'THEN values.value_text::text
            WHEN at.id = 'float'THEN values.value_float::text END
        AS Значение FROM values
    JOIN films f on values.film_id = f.id
    JOIN attributes a on a.id = values.attribute_id
    JOIN attribute_types at on at.id = a.attributetype_id
;