create table if not exists users
(
    id    integer      not null
    constraint users_pk
    primary key,
    name  varchar(255) not null,
    email varchar(255),
    constraint users_name_email_unique
    unique (name, email)
);

alter table users
    owner to postgres;

create table if not exists films
(
    id         integer      not null
    constraint films_pk
    primary key,
    name       varchar(255) not null,
    date_begin date,
    date_end   date
);

alter table films
    owner to postgres;

create table if not exists halls
(
    id   integer     not null
    constraint hall_pk
    primary key,
    name varchar(20) not null
);

alter table halls
    owner to postgres;

create table if not exists sessions
(
    id             integer                  not null
    constraint sessions_pk
    primary key,
    hall_id        integer                  not null
    constraint sessions_halls_null_fk
    references halls,
    film_id        integer                  not null
    constraint sessions_films_null_fk
    references films,
    datatime_begin timestamp with time zone not null,
    datetime_end   timestamp with time zone not null,
    price integer     not null
    constraint sessions_unique
    unique (hall_id, datetime_end, datatime_begin, film_id)
);

alter table sessions
    owner to postgres;

create table if not exists hall_rows
(
    id       integer not null
    constraint hall_rows_pk
    primary key,
    hall_id  integer not null
    constraint hall_rows_halls_null_fk
    references halls,
    number   integer not null,
    capacity integer not null
);

alter table hall_rows
    owner to postgres;

create table if not exists tickets
(
    id         integer not null
    constraint tickets_pk
    primary key,
    user_id    integer not null
    constraint tickets_users_null_fk
    references users,
    session_id integer not null
    constraint tickets_sessions_null_fk
    references sessions,
    row_id     integer
    constraint tickets_hall_rows_null_fk
    references hall_rows,
    seat       integer,
    price      integer not null,
    constraint tickets_session_row_seat_unique
    unique (session_id, row_id, seat)
);

alter table tickets
    owner to postgres;

