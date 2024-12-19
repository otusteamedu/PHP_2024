create table public.films
(
    uuid uuid default gen_random_uuid() not null
        constraint films_pk
            primary key,
    name varchar
);

alter table public.films
    owner to postgres;

create table public.films_types_attributes
(
    uuid       uuid    default gen_random_uuid() not null
        constraint films_types_attributes_pk
            primary key,
    name       varchar,
    type_value varchar default 'value_str'::character varying
);

alter table public.films_types_attributes
    owner to postgres;

create table public.films_attributes
(
    uuid      uuid default gen_random_uuid() not null
        constraint films_attributes_pk
            primary key,
    uuid_type uuid
        constraint films_attributes_films_types_attributes_id_fk
            references public.films_types_attributes,
    name      varchar
);

alter table public.films_attributes
    owner to postgres;

create table public.films_values
(
    uuid_film      uuid not null
        constraint films_values_films_uuid_fk
            references public.films,
    uuid_attribite uuid not null
        constraint films_values_films_attributes_id_fk
            references public.films_attributes,
    value_str      varchar,
    value_date     date,
    value_decimal  numeric(15,2),
    constraint films_values_pk
        primary key (uuid_film, uuid_attribite)
);

alter table public.films_values
    owner to postgres;

