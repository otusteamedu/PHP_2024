create table if not exists hall
(
    id serial primary key,
    name varchar(255) not null,
    capacity integer not null
);

create table if not exists seat
(
    id serial primary key,
    hall_id integer references hall,
    row integer not null,
    number integer not null
);

create table if not exists movie
(
    id serial primary key,
    title varchar(255) not null,
    about varchar(255) not null,
    duration integer not null,
    rent_start date not null,
    rent_end date not null
);

create table if not exists show
(
    id serial primary key,
    hall_id integer not null references hall,
    movie_id integer not null references movie,
    date date not null,
    time time not null,
    price_per_ticket numeric(10, 2) not null
);

create table if not exists ticket
(
    id serial primary key,
    show_id integer not null references show,
    seat_id integer not null references seat,
    purchase_time timestamp not null
);

create table if not exists customer
(
    id serial primary key,
    show_id integer not null references show,
    first_name varchar(255) not null,
    last_name varchar(255) not null,
    second_name varchar(255) not null,
    phone varchar(255) not null,
    email varchar(255) not null,
    birthdate date not null
);

