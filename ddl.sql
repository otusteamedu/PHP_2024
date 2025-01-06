create table product
(
    id    serial primary key,
    title  varchar(255) not null,
    price float        not null
);

create table "user"
(
    id   serial primary key,
    name varchar(255) not null,
    age  integer      not null
);



