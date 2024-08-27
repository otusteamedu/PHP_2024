-- drop tables if they exist
drop view if exists "query_1" cascade;
drop view if exists "query_2" cascade;
drop view if exists "query_3" cascade;
drop view if exists "query_4" cascade;
drop view if exists "query_5" cascade;
drop view if exists "query_6" cascade;
drop table if exists "ticket_purchase" cascade;
drop table if exists "ticket" cascade;
drop table if exists "purchase" cascade;
drop table if exists "seat" cascade;
drop table if exists "seat_type" cascade;
drop table if exists "showtime" cascade;
drop table if exists "film" cascade;
drop table if exists "screen" cascade;
drop table if exists "screen_type" cascade;
drop table if exists "employer" cascade;
drop table if exists "customer" cascade;
drop table if exists "user" cascade;
drop table if exists "cinema" cascade;

create table if not exists "cinema" (
    "id" serial primary key,
    "title" varchar(255) not null,
    "location" text not null,
    "contacts" text not null
);

create table if not exists "screen_type" (
    "id" serial primary key,
    "type" varchar(255) not null,
    "price_factor" decimal(10,0) not null default 1
);

create table if not exists "screen" (
    "id" serial primary key,
    "cinema_id" int not null,
    "title" varchar(255) not null,
    "capacity" int not null,
    "type" int not null,
    foreign key ("cinema_id") references "cinema"("id"),
    foreign key ("type") references "screen_type"("id")
);

create table if not exists "film" (
    "id" serial primary key,
    "title" varchar(255) not null,
    "genre" varchar(255),
    "duration" int,
    "release_date" date,
    "description" text,
    "price" decimal(10, 2) not null
);

create table if not exists "showtime" (
    "id" serial primary key,
    "screen_id" int not null,
    "film_id" int,
    "start" timestamp not null,
    "end" timestamp not null,
    "price_factor" decimal(10, 2) not null default 1,
    foreign key ("screen_id") references "screen"("id"),
    foreign key ("film_id") references "film"("id")
);

create table if not exists "seat_type" (
   "id" serial primary key,
    "type" text not null,
    "price_factor" decimal(10, 2) not null default 1
);

create table if not exists "seat" (
    "id" serial primary key,
    "screen_id" int not null,
    "block" varchar(255) null,
    "row_number" varchar(255) not null,
    "seat_number" varchar(255) not null,
    "seat_type" int not null,
    foreign key ("screen_id") references "screen"("id"),
    foreign key ("seat_type") references "seat_type"("id"),
    unique ("screen_id", "block", "row_number", "seat_number")
);

create table if not exists "user" (
    "id" serial primary key,
    "name" varchar(255) not null,
    "lastname" varchar(255) not null
);

create table if not exists "customer" (
    "id" serial primary key,
    "user_id" int not null unique,
    "bonuses" decimal(10,0) not null,
    "membership_status" int not null,
    foreign key ("user_id") references "user"("id")
);

create table if not exists "employer" (
    "id" serial primary key,
    "user_id" int not null,
    "position_id" int not null,
    "cinema_id" int not null,
    "salary" decimal(10,0) not null,
    foreign key ("user_id") references "user"("id"),
    foreign key ("cinema_id") references "cinema"("id"),
    unique ("user_id", "position_id", "cinema_id")
);

create table if not exists purchase (
    "id" serial primary key,
    "purchase_date" timestamp not null,
    "price" decimal(10,2) not null,
    "bonuses" decimal(10,2) not null,
    "customer_id" int references customer(id),
    "employer_id" int references employer(id)
);

create table if not exists ticket (
    "id" serial primary key,
    "purchase_id" int not null references purchase("id"),
    "showtime_id" int not null references showtime("id"),
    "seat_id" int not null references seat("id"),
    "price" decimal(10,2) not null,
    unique("showtime_id", "seat_id")
);

--1. Выбор всех фильмов на сегодня
create view query_1 as
    select distinct film.title
        from film
            join showtime on film.id = showtime.film_id
        where date(showtime.start) = CURRENT_DATE
    order by film.title
;
--2. Подсчёт проданных билетов за неделю
create view query_2 as
    select count(distinct ticket.id)
        from ticket
            join purchase on ticket.purchase_id = purchase.id
        where purchase.purchase_date >= current_date - interval '7 days' and purchase.purchase_date <= current_date;
;
--3. Формирование афиши (фильмы, которые показывают сегодня)
create view query_3 as
    select film.id, film.title, showtime.start, showtime.end
        from film
            join showtime on film.id = showtime.film_id
        where date(showtime.start) = CURRENT_DATE
;
--4. Поиск 3 самых прибыльных фильмов за неделю
create view query_4 as
    select film.title, t1.total_income
    from (
         select showtime.film_id, sum(ticket.price) as total_income
         from showtime
                  join ticket on showtime.id = ticket.showtime_id
         where date(showtime.start) between current_date - interval '7 days' AND CURRENT_DATE
         group by showtime.film_id
         order by total_income desc limit 3
    ) t1
    join film on t1.film_id = film.id
    order by t1.total_income desc
;
--5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
create view query_5 as
    select seat.row_number, seat.seat_number,
        case when ticket.id is not null then '1'
            else '0'
        end as state
    from
        seat
            inner join showtime on seat.screen_id = showtime.screen_id
            left join ticket on showtime.id = ticket.showtime_id and seat.id = ticket.seat_id
        where showtime.id = 1
    order by
        seat.row_number,
        seat.seat_number
;
--6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
create view query_6 as
    select max(ticket.price), min(ticket.price)
    from ticket
    where ticket.showtime_id = 1
;
