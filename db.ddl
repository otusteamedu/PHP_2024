create table public.films
(
    id            serial
        constraint films_pk
            primary key,
    name          varchar            not null,
    release_start date,
    release_end   date,
    duration      integer default 90 not null
);

alter table public.films
    owner to root;

create index films_name_index
    on public.films (name);

create table public.halls
(
    id   serial
        constraint halls_pk
            primary key,
    name varchar
);

alter table public.halls
    owner to root;

create table public.hall_lines
(
    id      serial
        constraint hall_lines_pk
            primary key,
    hall_id integer not null
        constraint hall_lines_halls_fk
            references public.halls,
    name    varchar not null
);

alter table public.hall_lines
    owner to root;

create table public.seat_types
(
    id    serial
        constraint seat_types_pk
            primary key,
    name  varchar not null,
    color varchar not null,
    constraint seat_types_name_color_index
        unique (name, color)
);

alter table public.seat_types
    owner to root;

create table public.hall_seats
(
    id      serial
        constraint hall_seats_pk
            primary key,
    line_id integer not null
        constraint hall_seats_hall_lines_fk
            references public.hall_lines,
    type_id integer not null
        constraint hall_seats_seat_types_fk
            references public.seat_types,
    name    varchar not null
);

alter table public.hall_seats
    owner to root;

create table public.screenings
(
    id       serial
        constraint screenings_pk
            primary key,
    film_id  integer not null
        constraint screenings_films_fk
            references public.films,
    hall_id  integer not null
        constraint screenings_halls_fk
            references public.halls,
    week_day integer not null,
    time     time    not null,
    constraint screenings_hall_id_film_id_week_day_time_unique
        unique (hall_id, film_id, week_day, time)
);

alter table public.screenings
    owner to root;

create table public.screening_prices
(
    id           serial
        constraint screening_prices_pk
            primary key,
    screening_id integer not null
        constraint screening_prices_screenings_fk
            references public.screenings,
    seat_type_id integer not null
        constraint screening_prices_seat_types_fk
            references public.seat_types,
    price        integer not null
);

alter table public.screening_prices
    owner to root;

create table public.orders
(
    id             serial
        constraint orders_pk
            primary key,
    order_date     timestamp default CURRENT_TIMESTAMP not null,
    screening_date date                                not null,
    screening_id   integer                             not null
        constraint orders_screenings_fk
            references public.screenings,
    seat_id        integer                             not null
        constraint orders_hall_seats_fk
            references public.hall_seats,
    sum            integer                             not null
);

alter table public.orders
    owner to root;

create table public.users
(
    id            serial
        constraint users_pk
            primary key,
    username      varchar not null,
    password_hash varchar not null,
    email         varchar not null
);

alter table public.users
    owner to root;

create unique index users_username_index
    on public.users (username);

create table public.user_orders
(
    id       serial
        constraint user_orders_pk
            primary key,
    user_id  integer not null
        constraint user_orders_users_fk
            references public.users,
    order_id integer not null
        constraint user_orders_orders_fk
            references public.orders
);

alter table public.user_orders
    owner to root;