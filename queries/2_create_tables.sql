create table film
(
    id serial primary key,
    name varchar(4096) not null unique
);

create type attr_type AS enum ('varchar', 'integer', 'bool', 'timestamp', 'float');

create table attribute_type
(
    id serial primary key,
    name varchar(4096),
    type attr_type
);

create table film_attribute
(
    id serial primary key,
    name varchar(4096) not null unique,
    type_id integer references attribute_type
);

create table film_value
(
    film_id integer references film(id),
    film_attribute_id integer references film_attribute(id),

    value_varchar varchar(4096) null default null,
    value_integer integer null default null,
    value_float float null default null,
    value_bool bool null default null,
    value_timestamp timestamp null default null,

    primary key (film_id, film_attribute_id)
);


