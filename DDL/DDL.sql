CREATE TABLE IF NOT EXISTS films (
     id          varchar(32) UNIQUE PRIMARY KEY,
     name        text
);


CREATE TABLE IF NOT EXISTS attribute_types (
    id varchar(32) UNIQUE PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS attributes (
    id                  varchar(32) UNIQUE PRIMARY KEY,
    attributetype_id    varchar(32),
    name                text,
    FOREIGN KEY (attributetype_id) REFERENCES attribute_types(id)
);


CREATE TABLE IF NOT EXISTS values (
    film_id         varchar(32) ,
    attribute_id    varchar(32),
    value           text,
    FOREIGN KEY (film_id) REFERENCES films(id),
    FOREIGN KEY (attribute_id) REFERENCES attributes(id)
);


INSERT INTO films VALUES ('master_i_margarita','Мастер и Маргарита'),('onegin','Онегин'),('duna_2','Дюна 2');

INSERT INTO attribute_types VALUES ('text'),('date'),('logic'),('money');

INSERT INTO attributes VALUES ('reviews','text','Рецензии'),
                              ('award_oscar','logic','Премия Оскар'),
                              ('award_nika','logic','Премия Ника'),
                              ('world_premiere_date','date','Дата мировой премьеры'),
                              ('ru_premiere_date','date','Дата премьеры в России'),
                              ('ticket_trade_begin','date','Начало продажи билетов'),
                              ('ticket_trade_end','date','Окончание продажи билетов'),
                              ('seat_price','money','Стоимость места'),
                              ('seat_price_luxe','money','Стоимость Luxe-места');

INSERT INTO values VALUES ('master_i_margarita','reviews','Рецензия 1'),
                          ('master_i_margarita','reviews','Рецензия 2'),
                          ('master_i_margarita','award_oscar','true'),
                          ('master_i_margarita','award_nika','false'),
                          ('master_i_margarita','world_premiere_date','20.02.2024'),
                          ('master_i_margarita','ru_premiere_date','20.02.2024'),
                          ('master_i_margarita','ticket_trade_begin','19.02.2024'),
                          ('master_i_margarita','ticket_trade_end','2.03.2024'),
                          ('master_i_margarita','seat_price','500.00'),
                          ('master_i_margarita','seat_price_luxe','600.00'),
                          ('onegin','reviews','Рецензия 1'),
                          ('onegin','reviews','Рецензия 2'),
                          ('onegin','award_oscar','true'),
                          ('onegin','award_nika','true'),
                          ('onegin','world_premiere_date','26.02.2024'),
                          ('onegin','ru_premiere_date','26.02.2024'),
                          ('onegin','ticket_trade_begin','25.02.2024'),
                          ('onegin','ticket_trade_end','10.03.2024'),
                          ('onegin','seat_price','550.00'),
                          ('onegin','seat_price_luxe','650.00'),
                          ('duna_2','reviews','Рецензия 1'),
                          ('duna_2','reviews','Рецензия 2'),
                          ('duna_2','award_oscar','false'),
                          ('duna_2','award_nika','false'),
                          ('duna_2','world_premiere_date','03.03.2024'),
                          ('duna_2','ru_premiere_date','15.03.2024'),
                          ('duna_2','ticket_trade_begin','14.03.2024'),
                          ('duna_2','ticket_trade_end','30.03.2024'),
                          ('duna_2','seat_price','600.00'),
                          ('duna_2','seat_price_luxe','700.00');
