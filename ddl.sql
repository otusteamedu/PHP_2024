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
    id            serial primary key,
    movie_id      integer
    references movies (id),
    attribute_id  integer
    references attributes (id),
    value_text    text          null,
    value_string  varchar(256)  null,
    value_integer int           null,
    value_float   decimal(8, 2) null,
    value_date    date          null,
    value_boolean boolean       null
    );

