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


INSERT INTO films VALUES
    ('master_i_margarita','Мастер и Маргарита'),
    ('onegin','Онегин'),
    ('duna_2','Дюна 2');

INSERT INTO attribute_types VALUES ('text'),('date'),('logic');

INSERT INTO attributes VALUES
                              ('reviews'),
                              ('премии'),
                              ('важные даты'),
                              ('служебные даты'),
                              ('всякая другая хрень');