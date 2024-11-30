create table movies
(
    id   serial primary key,
    name varchar(255) not null
);

create table attribute_types
(
    id   serial primary key,
    name varchar(255) not null,
    type varchar(50)  not null
);

create table attributes
(
    id      serial primary key,
    type_id bigint references attribute_types (id),
    name    varchar(255) not null
);

create table movie_attribute_values
(
    id            serial primary key,
    movie_id      bigint references movies (id),
    attribute_id  bigint references attributes (id),
    value_text    text,
    value_boolean boolean,
    value_date    date,
    value_float   float,
    created_at    timestamp default current_timestamp
);

create index idx_movie_id on movie_attribute_values (movie_id);
create index idx_attribute_id on movie_attribute_values (attribute_id);