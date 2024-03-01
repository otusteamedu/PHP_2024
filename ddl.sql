CREATE DATABASE cinema ENCODING = 'UTF8';

CREATE TABLE public.cinema_halls (
    id bigserial NOT NULL,
    "name" varchar NOT NULL,
    CONSTRAINT cinema_halls_pk PRIMARY KEY (id)
);

CREATE TABLE public.seats (
    id bigserial NOT NULL,
    cinema_hall_id int8 NOT NULL,
    "row" varchar NOT NULL,
    "number" varchar NOT NULL,
    "type" varchar NOT NULL,
    CONSTRAINT seats_check CHECK (
        (
            (type) :: text = ANY (
                (
                    ARRAY ['first'::character varying, 'second'::character varying, 'third'::character varying]
                ) :: text []
            )
        )
    ),
    CONSTRAINT seats_pk PRIMARY KEY (id),
    CONSTRAINT seats_unique UNIQUE (cinema_hall_id, "row", number),
    CONSTRAINT seats_cinema_halls_fk FOREIGN KEY (cinema_hall_id) REFERENCES public.cinema_halls(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE INDEX seats_cinema_hall_id_idx ON public.seats USING btree (cinema_hall_id);

CREATE TABLE public.movies (
    id bigserial NOT NULL,
    "name" varchar NOT NULL,
    CONSTRAINT movies_pk PRIMARY KEY (id)
);

CREATE TABLE public.prices (
    id bigserial NOT NULL,
    date_from date NOT NULL,
    movie_id int8 NOT NULL,
    "type" varchar NOT NULL,
    price float8 NOT NULL,
    CONSTRAINT prices_check CHECK (
        (
            (type) :: text = ANY (
                ARRAY [('first'::character varying)::text, ('second'::character varying)::text, ('third'::character varying)::text]
            )
        )
    ),
    CONSTRAINT prices_pk PRIMARY KEY (id),
    CONSTRAINT prices_unique UNIQUE (movie_id, type, date_from),
    CONSTRAINT prices_movies_fk FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE INDEX prices_movie_id_idx ON public.prices USING btree (movie_id);

CREATE TABLE public.shows (
    id bigserial NOT NULL,
    movie_id int8 NOT NULL,
    cinema_hall_id int8 NOT NULL,
    "from" time NOT NULL,
    "to" time NOT NULL,
    CONSTRAINT shows_check CHECK (("to" > "from")),
    CONSTRAINT shows_pk PRIMARY KEY (id),
    CONSTRAINT shows_cinema_halls_fk FOREIGN KEY (cinema_hall_id) REFERENCES public.cinema_halls(id),
    CONSTRAINT shows_movies_fk FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE INDEX shows_cinema_hall_id_idx ON public.shows USING btree (cinema_hall_id);

CREATE INDEX shows_movie_id_idx ON public.shows USING btree (movie_id);

CREATE TABLE public.tickets (
    id bigserial NOT NULL,
    show_id int8 NOT NULL,
    seat_id int8 NOT NULL,
    is_sold bool NOT NULL DEFAULT false,
    CONSTRAINT tickets_pk PRIMARY KEY (id),
    CONSTRAINT tickets_seats_fk FOREIGN KEY (seat_id) REFERENCES seats(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT tickets_shows_fk FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE INDEX tickets_seat_id_idx ON public.tickets USING btree (seat_id);

CREATE INDEX tickets_show_id_idx ON public.tickets USING btree (show_id);

CREATE TABLE public.sales (
    id bigserial NOT NULL,
    "date" date NOT NULL,
    amount float8 NOT NULL,
    ticket_id int8 NOT NULL,
    CONSTRAINT sales_pk PRIMARY KEY (id),
    CONSTRAINT sales_shows_fk FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT sales_tickets_fk FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE INDEX sales_show_id_idx ON public.sales USING btree (show_id);

CREATE INDEX sales_ticket_id_idx ON public.sales USING btree (ticket_id);