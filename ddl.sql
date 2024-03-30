create table if not exists public.auditorium
(
    id   smallserial
        primary key,
    name varchar(255) not null
        constraint auditorium_name_uk
            unique
);

alter table public.auditorium
    owner to postgres;

create table if not exists public.country
(
    id   smallserial
        primary key,
    name varchar(255) not null
        constraint country_name_uk
            unique
);

alter table public.country
    owner to postgres;

create table if not exists public.genre
(
    id   smallserial
        primary key,
    name varchar(128) not null
        constraint genre_name_uk
            unique
);

alter table public.genre
    owner to postgres;

create table if not exists public.movie
(
    id                  bigserial
        primary key,
    name                varchar(128) not null
        constraint movie_name_uk
            unique,
    duration            smallint,
    description         varchar(1024),
    world_premiere_date date,
    country_id          smallint     not null
        constraint movie_country_id_fk
            references public.country,
    start_date          date not null,
    last_date           date
);

alter table public.movie
    owner to postgres;

create table if not exists public.movie_genre
(
    movie_id bigint  not null
        constraint movie_genre_movie_id_fk
            references public.movie,
    genre_id integer not null
        constraint movie_genre_genre_id_fk
            references public.genre,
    primary key (genre_id, movie_id)
);

alter table public.movie_genre
    owner to postgres;

create table if not exists public.seat
(
    id          smallserial
        primary key,
    row_number  smallint not null,
    seat_number smallint not null
);

alter table public.seat
    owner to postgres;

create table if not exists public.session
(
    id            bigserial
        primary key,
    movie_id      bigint        not null
        constraint session_movie_id_fk
            references public.movie,
    auditorium_id smallint      not null
        constraint session_auditorium_id_fk
            references public.auditorium,
    price         numeric(5, 2) not null,
    start_time    time          not null,
    end_time      time          not null
);

alter table public.session
    owner to postgres;

create table if not exists public.ticket
(
    id         bigserial
        primary key,
    date       date   not null,
    session_id bigint not null
        constraint ticket_session_id_fk
            references public.session,
    seat_id    smallint
        constraint ticket_seat_id_fk
            references public.seat,
    constraint ticket_pk
        unique (date, session_id, seat_id)
);

alter table public.ticket
    owner to postgres;

