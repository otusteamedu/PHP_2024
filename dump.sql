--
-- PostgreSQL database dump
--

-- Dumped from database version 16.4 (Debian 16.4-1.pgdg120+1)
-- Dumped by pg_dump version 16.4 (Debian 16.4-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: category_seats; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.category_seats (
    id integer NOT NULL,
    name_category character varying(100) NOT NULL
);


ALTER TABLE public.category_seats OWNER TO root;

--
-- Name: category_seats_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

ALTER TABLE public.category_seats ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.category_seats_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: country_films; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.country_films (
    country character varying(100) NOT NULL
);


ALTER TABLE public.country_films OWNER TO root;

--
-- Name: films; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.films (
    id_film integer NOT NULL,
    name_film text NOT NULL,
    country_film character varying(100) NOT NULL,
    producer_film character varying(100) NOT NULL,
    genre_film character varying(100) NOT NULL
);


ALTER TABLE public.films OWNER TO root;

--
-- Name: films_id_film_seq; Type: SEQUENCE; Schema: public; Owner: root
--

ALTER TABLE public.films ALTER COLUMN id_film ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.films_id_film_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: genre; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.genre (
    genre_name character varying(100) NOT NULL
);


ALTER TABLE public.genre OWNER TO root;

--
-- Name: halls; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.halls (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.halls OWNER TO root;

--
-- Name: halls_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

ALTER TABLE public.halls ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.halls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: prices; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.prices (
    category_id integer NOT NULL,
    date_session date NOT NULL,
    time_session time without time zone NOT NULL,
    price numeric NOT NULL,
    id_session integer NOT NULL
);


ALTER TABLE public.prices OWNER TO root;

--
-- Name: seats_rows; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.seats_rows (
    hall integer NOT NULL,
    category integer NOT NULL,
    seat integer,
    "row" integer,
    id integer NOT NULL
);


ALTER TABLE public.seats_rows OWNER TO root;

--
-- Name: seats_rows_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

ALTER TABLE public.seats_rows ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.seats_rows_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: session_films; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.session_films (
    id integer NOT NULL,
    id_hall integer NOT NULL,
    time_session time without time zone NOT NULL,
    date_session date NOT NULL,
    film integer NOT NULL
);


ALTER TABLE public.session_films OWNER TO root;

--
-- Name: tickets; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.tickets (
    number bigint NOT NULL,
    sold bit(1),
    id_seat integer NOT NULL,
    session integer
);


ALTER TABLE public.tickets OWNER TO root;

--
-- Name: tickets_number_seq; Type: SEQUENCE; Schema: public; Owner: root
--

ALTER TABLE public.tickets ALTER COLUMN number ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.tickets_number_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Data for Name: category_seats; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.category_seats (id, name_category) FROM stdin;
1	vip
2	simple
\.


--
-- Data for Name: country_films; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.country_films (country) FROM stdin;
Франция
Китай
Россия
\.


--
-- Data for Name: films; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.films (id_film, name_film, country_film, producer_film, genre_film) FROM stdin;
4	Трое в одном противогазе	Россия	Гайдай	Комедия
6	1+1	Франция	Джорж Бутье	Драма
7	Конь в Пальто	Китай	Джеки Чан	Комедия
\.


--
-- Data for Name: genre; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.genre (genre_name) FROM stdin;
Драма
Комедия
Мюзикл
\.


--
-- Data for Name: halls; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.halls (id, name) FROM stdin;
1	Большой
2	Малый
\.


--
-- Data for Name: prices; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.prices (category_id, date_session, time_session, price, id_session) FROM stdin;
\.


--
-- Data for Name: seats_rows; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.seats_rows (hall, category, seat, "row", id) FROM stdin;
2	2	12	3	1
1	1	2	11	2
1	2	12	2	3
2	1	10	5	4
\.


--
-- Data for Name: session_films; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.session_films (id, id_hall, time_session, date_session, film) FROM stdin;
1	1	17:00:00	2024-01-01	4
2	2	19:00:00	2024-02-02	7
3	1	20:00:00	2024-01-01	7
\.


--
-- Data for Name: tickets; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.tickets (number, sold, id_seat, session) FROM stdin;
1	1	1	1
2	1	2	2
3	1	3	1
\.


--
-- Name: category_seats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.category_seats_id_seq', 2, true);


--
-- Name: films_id_film_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.films_id_film_seq', 7, true);


--
-- Name: halls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.halls_id_seq', 2, true);


--
-- Name: seats_rows_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.seats_rows_id_seq', 4, true);


--
-- Name: tickets_number_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.tickets_number_seq', 3, true);


--
-- Name: category_seats category_seats_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.category_seats
    ADD CONSTRAINT category_seats_pkey PRIMARY KEY (id);


--
-- Name: country_films country_films_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.country_films
    ADD CONSTRAINT country_films_pkey PRIMARY KEY (country);


--
-- Name: films films_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_pkey PRIMARY KEY (id_film);


--
-- Name: genre genre_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.genre
    ADD CONSTRAINT genre_pkey PRIMARY KEY (genre_name);


--
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (id);


--
-- Name: prices prices_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.prices
    ADD CONSTRAINT prices_pkey PRIMARY KEY (category_id, id_session);


--
-- Name: seats_rows seats_rows_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.seats_rows
    ADD CONSTRAINT seats_rows_pkey PRIMARY KEY (id);


--
-- Name: session_films session_films_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.session_films
    ADD CONSTRAINT session_films_pkey PRIMARY KEY (id);


--
-- Name: tickets tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_pkey PRIMARY KEY (number);


--
-- Name: prices category_fk; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.prices
    ADD CONSTRAINT category_fk FOREIGN KEY (category_id) REFERENCES public.category_seats(id);


--
-- Name: seats_rows category_seats_fk; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.seats_rows
    ADD CONSTRAINT category_seats_fk FOREIGN KEY (category) REFERENCES public.category_seats(id);


--
-- Name: films country_films_fk; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT country_films_fk FOREIGN KEY (country_film) REFERENCES public.country_films(country);


--
-- Name: session_films film_sess_fg; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.session_films
    ADD CONSTRAINT film_sess_fg FOREIGN KEY (film) REFERENCES public.films(id_film) NOT VALID;


--
-- Name: films films_genre_film_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_genre_film_fkey FOREIGN KEY (genre_film) REFERENCES public.genre(genre_name);


--
-- Name: films genre_film_fk; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT genre_film_fk FOREIGN KEY (genre_film) REFERENCES public.genre(genre_name);


--
-- Name: seats_rows hall_seats_fk; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.seats_rows
    ADD CONSTRAINT hall_seats_fk FOREIGN KEY (hall) REFERENCES public.halls(id) NOT VALID;


--
-- Name: session_films hall_sess_fk; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.session_films
    ADD CONSTRAINT hall_sess_fk FOREIGN KEY (id_hall) REFERENCES public.halls(id);


--
-- Name: prices id_sess_fk; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.prices
    ADD CONSTRAINT id_sess_fk FOREIGN KEY (id_session) REFERENCES public.session_films(id);


--
-- Name: tickets seats_ticket_fg; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT seats_ticket_fg FOREIGN KEY (id_seat) REFERENCES public.seats_rows(id);


--
-- Name: tickets sessions_tickets; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT sessions_tickets FOREIGN KEY (session) REFERENCES public.session_films(id) NOT VALID;


--
-- PostgreSQL database dump complete
--

