create table if not exists public.type
(
    id   smallserial
        primary key,
    name varchar(100) not null
        constraint u_type_name
            unique
);

create table if not exists public.attribute
(
    id      serial
        primary key,
    type_id smallint
        constraint attribute_type_id_fk
            references public.type,
    name    varchar(100) not null
        constraint u_attribute_name
            unique
);

create table if not exists public.movie
(
    id   serial
        primary key,
    name varchar(100) not null
        constraint u_movie_name
            unique
);

create table if not exists public.value
(
    id           bigserial
        primary key,
    movie_id     integer
        constraint value_movie_id_fk
            references public.movie,
    attribute_id integer
        constraint value_attribute_id_fk
            references public.attribute,
    text_value   varchar(1024),
    int_value    integer,
    date_value   date,
    time_value   time,
    bool_value   boolean,
    float_value  numeric(5, 3)
);
