-- ТАБЛИЦЫ

create table if not exists clients
(
    id   bigint unsigned auto_increment
    primary key,
    name varchar(255) not null
    )
    collate = utf8mb4_unicode_ci;

create table if not exists countries
(
    id   bigint unsigned auto_increment
    primary key,
    name varchar(255) not null
    )
    collate = utf8mb4_unicode_ci;

create table if not exists films
(
    id         bigint unsigned auto_increment
    primary key,
    name       varchar(255)                        not null,
    year       int                                 not null,
    type       enum ('FILM', 'CARTOON')            not null,
    start_date timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP comment 'Дата начала продаж билетов'
    )
    collate = utf8mb4_unicode_ci;

create table if not exists country_film
(
    country_id bigint unsigned not null,
    film_id    bigint unsigned not null,
    constraint country_film_country_id_foreign
    foreign key (country_id) references countries (id)
    on delete cascade,
    constraint country_film_film_id_foreign
    foreign key (film_id) references films (id)
    on delete cascade
    )
    collate = utf8mb4_unicode_ci;

create table if not exists halls
(
    id   bigint unsigned auto_increment
    primary key,
    name varchar(255)                  not null,
    type enum ('IMAX', 'COMMON', '3D') not null
    )
    collate = utf8mb4_unicode_ci;

create table if not exists hall_seats
(
    id                bigint unsigned auto_increment
    primary key,
    hall_id           bigint unsigned not null,
    number            varchar(255)    not null,
    price_coefficient decimal(8, 2)    not null comment 'Коэфициент цены в зависимости от расположения',
    max_count         int             not null comment 'Максимальная вместимость (н-р, диван - 2 человека)',
    constraint hall_seats_hall_id_foreign
    foreign key (hall_id) references halls (id)
    on delete cascade
    )
    collate = utf8mb4_unicode_ci;

create table if not exists times
(
    id   bigint unsigned auto_increment
    primary key,
    time varchar(255) not null
    )
    collate = utf8mb4_unicode_ci;

create table if not exists sessions
(
    id      bigint unsigned auto_increment
    primary key,
    hall_id bigint unsigned                     not null,
    film_id bigint unsigned                     not null,
    time_id bigint unsigned                     not null,
    date    timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    price   decimal(8, 2)                        not null,
    constraint sessions_film_id_foreign
    foreign key (film_id) references films (id)
    on delete cascade,
    constraint sessions_hall_id_foreign
    foreign key (hall_id) references halls (id)
    on delete cascade,
    constraint sessions_time_id_foreign
    foreign key (time_id) references times (id)
    on delete cascade
    )
    collate = utf8mb4_unicode_ci;

create table if not exists tickets
(
    id                     bigint unsigned auto_increment
    primary key,
    client_id              bigint unsigned not null,
    session_id             bigint unsigned not null,
    hall_seat_id           bigint unsigned not null,
    session_price          decimal(8, 2)    not null comment 'Фиксируем цену на сеанс на случай если поменяется',
    seat_price_coefficient decimal(8, 2)    not null comment 'Фиксируем кф-т сиденья на случай если поменяется',
    constraint tickets_client_id_foreign
    foreign key (client_id) references clients (id)
    on delete cascade,
    constraint tickets_hall_seat_id_foreign
    foreign key (hall_seat_id) references sessions (id)
    on delete cascade,
    constraint tickets_session_id_foreign
    foreign key (session_id) references sessions (id)
    on delete cascade
    )
    collate = utf8mb4_unicode_ci;

-- Заполнение базы

INSERT INTO halls (id, name, type) VALUES (1, 'Зал 1', 'COMMON');
INSERT INTO halls (id, name, type) VALUES (2, 'Зал 2', 'IMAX');

INSERT INTO hall_seats (id, hall_id, number, price_coefficient, max_count) VALUES (1, 1, 'A1', 1, 1);
INSERT INTO hall_seats (id, hall_id, number, price_coefficient, max_count) VALUES (2, 1, 'C1', 1.5, 2);
INSERT INTO hall_seats (id, hall_id, number, price_coefficient, max_count) VALUES (3, 2, 'A1', 1, 1);
INSERT INTO hall_seats (id, hall_id, number, price_coefficient, max_count) VALUES (4, 2, 'C1', 1.5, 2);

INSERT INTO times (id, time) VALUES (1, '10:00');
INSERT INTO times (id, time) VALUES (2, '10:30');
INSERT INTO times (id, time) VALUES (3, '11:00');

INSERT INTO countries (id, name) VALUES (1, 'США');
INSERT INTO countries (id, name) VALUES (2, 'Великобритания');

INSERT INTO films (id, name, year, type, start_date) VALUES (1, 'Бегущий в лабиринте', 2014, 'FILM', '2014-09-01 00:00:00');
INSERT INTO films (id, name, year, type, start_date) VALUES (2, 'Прежде, чем я усну', 2014, 'FILM', '2014-09-03 00:00:00');

INSERT INTO country_film (country_id, film_id) VALUES (1, 1);
INSERT INTO country_film (country_id, film_id) VALUES (2, 1);
INSERT INTO country_film (country_id, film_id) VALUES (1, 2);
INSERT INTO country_film (country_id, film_id) VALUES (2, 2);

INSERT INTO sessions (id, hall_id, film_id, time_id, date, price) VALUES (1, 1, 1, 1, '2014-09-01 00:00:00', 450);
INSERT INTO sessions (id, hall_id, film_id, time_id, date, price) VALUES (2, 2, 1, 2, '2014-09-02 00:00:00', 500);
INSERT INTO sessions (id, hall_id, film_id, time_id, date, price) VALUES (3, 1, 2, 1, '2014-09-03 00:00:00', 600);
INSERT INTO sessions (id, hall_id, film_id, time_id, date, price) VALUES (4, 2, 2, 3, '2014-09-04 00:00:00', 700);

INSERT INTO clients (id, name) VALUES (1, 'Иван Иванович');
INSERT INTO clients (id, name) VALUES (2, 'Сергей Сергеевич');
INSERT INTO clients (id, name) VALUES (3, 'Василий Васильевич');

INSERT INTO tickets (id, client_id, session_id, hall_seat_id, session_price, seat_price_coefficient) VALUES (1, 1, 1, 1, 450, 1);
INSERT INTO tickets (id, client_id, session_id, hall_seat_id, session_price, seat_price_coefficient) VALUES (2, 2, 1, 2, 450, 1.5);
INSERT INTO tickets (id, client_id, session_id, hall_seat_id, session_price, seat_price_coefficient) VALUES (3, 3, 4, 4, 700, 1.5);


-- Самый прибыльный фильм

select f.id as film_id, f.name as film_name
     , sum(t.session_price * t.seat_price_coefficient) as total_price
from tickets t
         join sessions s on s.id = t.session_id
         join films f on f.id = s.film_id
group by f.id
order by total_price desc limit 1