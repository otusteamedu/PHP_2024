create table products
(
    id      int auto_increment,
    title   varchar(255) not null,
    price   int          not null,
    remnant int          null,
    constraint id_primary_auto
        primary key (id)
);