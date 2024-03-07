create table public.film_attribute_types
(
    id   serial
        constraint film_attribute_types_pk
            primary key,
    name varchar,
    type varchar
);

alter table public.film_attribute_types
    owner to root;

create index film_attribute_types_id_index
    on public.film_attribute_types (id);

create index film_attribute_types_name_index
    on public.film_attribute_types (name);

create table public.film_attributes
(
    id      serial
        constraint film_attributes_pk
            primary key,
    type_id integer not null
        constraint film_attributes_film_attribute_types_id_fk
            references public.film_attribute_types,
    name    varchar not null
);

alter table public.film_attributes
    owner to root;

create index film_attributes_name_index
    on public.film_attributes (name);

create table public.film_attribute_values
(
    id              serial
        constraint film_attribute_values_pk
            primary key,
    attribute_id    integer not null
        constraint film_attribute_values_film_attributes_id_fk
            references public.film_attributes,
    film_id         integer
        constraint film_attribute_values_films_id_fk
            references public.films,
    value_string    text,
    value_integer   integer,
    value_timestamp timestamp,
    value_boolean   boolean,
    value_float     double precision
);

alter table public.film_attribute_values
    owner to root;

create index film_attribute_values_value_string_index
    on public.film_attribute_values (value_string);

create index film_attribute_values_value_float_index
    on public.film_attribute_values (value_float);

create index film_attribute_values_value_integer_index
    on public.film_attribute_values (value_integer);

create index film_attribute_values_value_timestamp_index
    on public.film_attribute_values (value_timestamp);

create index film_attribute_values_value_boolean_index
    on public.film_attribute_values (value_boolean);

create view public.actual_service_actions(name, task_today, task_20_day) as
SELECT films.name,
       fatoday.name  AS task_today,
       fa20days.name AS task_20_day
FROM films
         LEFT JOIN film_attribute_values favtoday
                   ON films.id = favtoday.film_id AND favtoday.value_timestamp::date = CURRENT_DATE
         LEFT JOIN film_attribute_values fav20days ON films.id = fav20days.film_id AND fav20days.value_timestamp::date =
                                                                                       (CURRENT_DATE + '20 days'::interval)
         JOIN film_attributes fatoday ON fatoday.id = favtoday.attribute_id AND fatoday.type_id = 4
         JOIN film_attributes fa20days ON fa20days.id = fav20days.attribute_id AND fatoday.type_id = 4;

alter table public.actual_service_actions
    owner to root;

create view public.actual_attributes(name, type, attribute_name, value) as
SELECT films.name,
       fat.name AS type,
       fa.name  AS attribute_name,
       CASE
           WHEN fat.type::text = 'boolean'::text THEN fav.value_boolean::character varying::text
           WHEN fat.type::text = 'date'::text THEN fav.value_timestamp::character varying::text
           ELSE fav.value_string
END  AS value
FROM films
         JOIN film_attribute_values fav ON films.id = fav.film_id
         JOIN film_attributes fa ON fa.id = fav.attribute_id
         JOIN film_attribute_types fat ON fat.id = fa.type_id;

alter table public.actual_attributes
    owner to root;

