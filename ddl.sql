create table if not exists eav.films_entity
(
    id   integer      not null
    constraint films_entity_pk
    primary key,
    name varchar(255) not null
);

alter table eav.films_entity
    owner to postgres;

create table if not exists eav.attributes_types
(
    id   integer     not null
    constraint attributes_types_pk
    primary key,
    type varchar(20) not null
);

alter table eav.attributes_types
    owner to postgres;

create table if not exists eav.attributes
(
    id   integer      not null
    constraint attributes_pk
    primary key,
    name varchar(255) not null,
    type integer
    constraint attributes_attributes_types_null_fk
    references eav.attributes_types
);

alter table eav.attributes
    owner to postgres;

create table if not exists eav.values
(
    id           integer not null
    constraint values_pk
    primary key,
    entity_id    integer
    constraint values_films_entity_null_fk
    references eav.films_entity,
    attribute_id integer
    constraint values_attributes_null_fk
    references eav.attributes,
    v_text       text,
    v_date       date,
    v_bool       boolean,
    v_int        integer,
    v_float      numeric
);

alter table eav.values
    owner to postgres;

