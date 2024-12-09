create table if not exists hall
(
    id serial primary key,
    name varchar(255) not null,
    capacity integer not null
);

insert into hall (name, capacity) values
    ('gold', 1000),
    ('silver', 500),
    ('bronze', 300);

create table if not exists seat
(
    id serial primary key,
    hall_id integer references hall,
    row integer not null,
    number integer not null
);

insert into seat (hall_id, row, number) values
    (1, 1, 1),
    (1, 1, 2),
    (1, 1, 3),
    (1, 2, 1),
    (1, 2, 2),
    (1, 2, 3),

    (2, 1, 1),
    (2, 1, 2),
    (2, 1, 3),
    (2, 2, 1),
    (2, 2, 2),
    (2, 2, 2),

    (3, 1, 1),
    (3, 1, 2),
    (3, 1, 3),
    (3, 2, 1),
    (3, 2, 2),
    (3, 2, 2);

create table if not exists movie
(
    id serial primary key,
    title varchar(255) not null,
    about varchar(255) not null,
    duration integer not null,
    rent_start date not null,
    rent_end date not null
);

insert into movie (title, about, duration, rent_start, rent_end) values
    ('film 1', 'about 1', 60, '2013-01-01', '2030-12-30'),
    ('film 2', 'about 2', 120, '2013-01-01', '2030-12-30'),
    ('film 3', 'about 3', 120, '2013-01-01', '2030-12-30'),
    ('film 4', 'about 4', 170, '2013-01-01', '2030-12-30'),
    ('film 5', 'about 5', 96, '2013-01-01', '2030-12-30'),
    ('film 6', 'about 6', 100, '2013-01-01', '2030-12-30');

create table if not exists show
(
    id serial primary key,
    hall_id integer not null references hall,
    movie_id integer not null references movie,
    date date not null,
    time time not null,
    price_per_ticket numeric(10, 2) not null
);

insert into show (hall_id, movie_id, date, time, price_per_ticket) values
    (1, 1, '2021-10-24', '12:00', 350),
    (2, 3, '2021-11-24', '12:15', 450),
    (2, 4, '2021-11-25', '12:15', 250),
    (3, 2, '2021-11-22', '12:15', 150),
    (3, 1, '2021-11-23', '12:10', 450),
    (2, 1, '2022-07-22', '09:00', 650);

create table if not exists ticket
(
    id serial primary key,
    show_id integer not null references show,
    seat_id integer not null references seat,
    purchase_time timestamp not null
);

insert into ticket (show_id, seat_id, purchase_time) values
    (1, 1, '2021-10-23 10:00'),
    (1, 2, '2021-10-23 10:10'),
    (1, 3, '2021-10-23 10:20'),
    (2, 1, '2021-10-23 10:00'),
    (2, 2, '2021-10-23 10:10'),
    (2, 3, '2021-10-23 10:20'),
    (3, 1, '2021-10-23 10:00'),
    (3, 2, '2021-10-23 10:10'),
    (3, 3, '2021-10-23 10:20'),
    (4, 1, '2021-10-23 10:00'),
    (4, 2, '2021-10-23 10:10'),
    (4, 3, '2021-10-23 10:20'),
    (5, 1, '2021-10-23 10:00'),
    (5, 2, '2021-10-23 10:10'),
    (5, 3, '2021-10-23 10:20'),
    (6, 1, '2021-10-23 10:00'),
    (6, 2, '2021-10-23 10:10'),
    (6, 3, '2021-10-23 10:20');
    
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

insert into customer (
        show_id, 
        first_name, 
        last_name, 
        second_name, 
        phone, 
        email, 
        birthdate
    ) values
        (1, 'ivan', 'ivanovich', 'ivanov', '+79999999999', 'test@test.ru', '1991-10-23'),
        (1, 'ivan', 'ivanovich', 'ivanov', '+79999999999', 'test@test.ru', '1991-10-23'),
        (1, 'ivan', 'ivanovich', 'ivanov', '+79999999999', 'test@test.ru', '1991-10-23'),
        (2, 'ivan', 'ivanovich', 'ivanov', '+79999999999', 'test@test.ru', '1991-10-23'),
        (2, 'ivan', 'ivanovich', 'ivanov', '+79999999999', 'test@test.ru', '1991-10-23'),
        (2, 'ivan', 'ivanovich', 'ivanov', '+79999999999', 'test@test.ru', '1991-10-23'),
        (3, 'ivan', 'ivanovich', 'ivanov', '+79999999999', 'test@test.ru', '1991-10-23'),
        (3, 'ivan', 'ivanovich', 'ivanov', '+79999999999', 'test@test.ru', '1991-10-23'),
        (3, 'ivan', 'ivanovich', 'ivanov', '+79999999999', 'test@test.ru', '1991-10-23');
        