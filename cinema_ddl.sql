create table if not exists auditorium
(
    id   int auto_increment
    primary key,
    name varchar(255) not null,
    constraint auditorium_name_uk
    unique (name)
    );

create table if not exists movie
(
    id       int auto_increment
    primary key,
    name     varchar(255) not null,
    duration smallint     not null,
    constraint movie_name_uk
    unique (name)
    );

create table if not exists seat
(
    id   int auto_increment
    primary key,
    type varchar(255) not null,
    constraint seat_type_uk
    unique (type)
    );

create table if not exists session
(
    id            int auto_increment
    primary key,
    movie_id      int  not null,
    start         time not null,
    auditorium_id int  not null,
    constraint session_auditorium_id_fk
    foreign key (auditorium_id) references auditorium (id),
    constraint session_movie_id_fk
    foreign key (movie_id) references movie (id)
    );

create table if not exists ticket
(
    id         int auto_increment
    primary key,
    session_id int           not null,
    seat_id    int           not null,
    price      decimal(4, 2) not null,
    constraint ticket_seat_id_fk
    foreign key (seat_id) references seat (id),
    constraint ticket_session_id_fk
    foreign key (session_id) references session (id)
    );

create table if not exists `order`
(
    id        int auto_increment
    primary key,
    date      date not null,
    ticket_id int  not null,
    quantity  int  not null,
    constraint order_ticket_id_fk
    foreign key (ticket_id) references ticket (id)
    );

