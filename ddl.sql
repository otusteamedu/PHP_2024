/*Создаем базу*/

DROP TABLE IF EXISTS public.movies CASCADE;
CREATE TABLE public.movies
(
    id          bigserial    NOT NULL,
    title       varchar(191) NOT NULL,
    description varchar(191) NOT NULL,

    CONSTRAINT movies_pkey PRIMARY KEY (id)
);



DROP TABLE IF EXISTS public.halls CASCADE;
CREATE TABLE public.halls
(
    id    bigserial    NOT NULL,
    title varchar(191) NOT NULL,

    CONSTRAINT halls_pkey PRIMARY KEY (id)
);

DROP TABLE IF EXISTS public.show_categories CASCADE;
CREATE TABLE public.show_categories
(
    id    bigserial    NOT NULL,
    title varchar(191) NOT NULL,
    price float8       NOT NULL,

    CONSTRAINT show_categories_pkey PRIMARY KEY (id)
);

DROP TABLE IF EXISTS public.shows CASCADE;
CREATE TABLE public.shows
(
    id          bigserial NOT NULL,
    begin_time  timestamp NOT NULL,
    end_time    timestamp NOT NULL,
    category_id bigserial NOT NULL,
    movie_id    bigserial NOT NULL,
    hall_id     bigserial NOT NULL,

    CONSTRAINT shows_pkey PRIMARY KEY (id),
    CONSTRAINT shows_categories_fk FOREIGN KEY (category_id) REFERENCES show_categories (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT shows_movies_fk FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT shows_halls_fk FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

DROP TABLE IF EXISTS public.seat_categories CASCADE;
CREATE TABLE public.seat_categories
(
    id           bigserial    NOT NULL,
    title        varchar(191) NOT NULL,
    category_fee float8       NOT NULL,

    CONSTRAINT seat_category_pkey PRIMARY KEY (id)
);

DROP TABLE IF EXISTS public.seats CASCADE;
CREATE TABLE public.seats
(
    id               bigserial NOT NULL,
    seat_category_id bigserial NOT NULL,
    hall_id          bigserial NOT NULL,
    seat_num         int       NOT NULL,
    row_num          int       NOT NULL,

    CONSTRAINT seats_pkey PRIMARY KEY (id),
    CONSTRAINT seats_hals_fk FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT seats_categories_fk FOREIGN KEY (seat_category_id) REFERENCES seat_categories (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

DROP TABLE IF EXISTS public.tickets CASCADE;
CREATE TABLE public.tickets
(
    id          bigserial NOT NULL,
    show_id     bigserial NOT NULL,
    seat_id     bigserial NOT NULL,
    total_price float8    NOT NULL,
    sale_time   timestamp NOT NULL,


    CONSTRAINT tickets_pkey PRIMARY KEY (id),
    CONSTRAINT tickets_shows_fk FOREIGN KEY (show_id) REFERENCES shows (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT tickets_seats_fk FOREIGN KEY (seat_id) REFERENCES seats (id) ON DELETE RESTRICT ON UPDATE CASCADE
);