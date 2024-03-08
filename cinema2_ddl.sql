create table auditorium
(
    id   int auto_increment
        primary key,
    name varchar(255) not null,
    constraint auditorium_name_uk
        unique (name)
);

create table country
(
    id   int auto_increment
        primary key,
    name varchar(255) not null,
    constraint country_name_uk
        unique (name)
);

create table genre
(
    id   int auto_increment
        primary key,
    name varchar(128) not null,
    constraint genre_name_uk
        unique (name)
);

create table movie
(
    id          int auto_increment
        primary key,
    name        varchar(128)  not null,
    duration    smallint      not null,
    description varchar(1024) null,
    date        date          null,
    country_id  int           not null,
    constraint movie_name_uk
        unique (name),
    constraint movie_country_id_fk
        foreign key (country_id) references country (id)
);

create table movie_genre
(
    movie_id int not null,
    genre_id int not null,
    primary key (genre_id, movie_id),
    constraint movie_genre_genre_id_fk
        foreign key (genre_id) references genre (id),
    constraint movie_genre_movie_id_fk
        foreign key (movie_id) references movie (id)
);

create table seat
(
    id           int auto_increment
        primary key,
    `row_number` smallint not null,
    seat_number  smallint not null
);

create table session
(
    id            int auto_increment
        primary key,
    movie_id      int           not null,
    auditorium_id int           not null,
    price         decimal(4, 2) not null,
    start         time          not null,
    end           time          not null,
    constraint session_auditorium_id_fk
        foreign key (auditorium_id) references auditorium (id),
    constraint session_movie_id_fk
        foreign key (movie_id) references movie (id)
);

create table ticket
(
    id         int auto_increment
        primary key,
    date       date null,
    session_id int  not null,
    seat_id    int  null,
    constraint ticket_pk
        unique (date, session_id, seat_id),
    constraint ticket_seat_id_fk
        foreign key (seat_id) references seat (id),
    constraint ticket_session_id_fk
        foreign key (session_id) references session (id)
);

