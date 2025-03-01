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

INSERT INTO countries (id, name) VALUES (1, 'США');
INSERT INTO countries (id, name) VALUES (2, 'Великобритания');

INSERT INTO films (id, name, year, start_date) VALUES (1, 'Бегущий в лабиринте', 2014, '2014-09-01 00:00:00');
INSERT INTO films (id, name, year, start_date) VALUES (2, 'Прежде, чем я усну', 2014, '2014-09-03 00:00:00');

INSERT INTO country_film (country_id, film_id) VALUES (1, 1);
INSERT INTO country_film (country_id, film_id) VALUES (2, 1);
INSERT INTO country_film (country_id, film_id) VALUES (1, 2);
INSERT INTO country_film (country_id, film_id) VALUES (2, 2);