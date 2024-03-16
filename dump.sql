--
-- PostgreSQL database dump
--
-- Dumped from database version 14.6 (Ubuntu 14.6-0ubuntu0.22.04.1)
-- Dumped by pg_dump version 14.6 (Ubuntu 14.6-0ubuntu0.22.04.1)
SET
    statement_timeout = 0;

SET
    lock_timeout = 0;

SET
    idle_in_transaction_session_timeout = 0;

SET
    client_encoding = 'UTF8';

SET
    standard_conforming_strings = on;

SELECT
    pg_catalog.set_config('search_path', '', false);

SET
    check_function_bodies = false;

SET
    xmloption = content;

SET
    client_min_messages = warning;

SET
    row_security = off;

--
-- Name: value_type; Type: TYPE; Schema: public; Owner: pozys
--
CREATE TYPE public.value_type AS ENUM (
    'text',
    'boolean',
    'float',
    'date',
    'integer'
);

ALTER TYPE public.value_type OWNER TO pozys;

SET
    default_tablespace = '';

SET
    default_table_access_method = heap;

--
-- Name: attribute_types; Type: TABLE; Schema: public; Owner: pozys
--
CREATE TABLE public.attribute_types (
    id integer NOT NULL,
    title character varying NOT NULL,
    value_type public.value_type NOT NULL
);

ALTER TABLE
    public.attribute_types OWNER TO pozys;

--
-- Name: attribute_types_id_seq; Type: SEQUENCE; Schema: public; Owner: pozys
--
ALTER TABLE
    public.attribute_types
ALTER COLUMN
    id
ADD
    GENERATED ALWAYS AS IDENTITY (
        SEQUENCE NAME public.attribute_types_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1
    );

--
-- Name: attributes; Type: TABLE; Schema: public; Owner: pozys
--
CREATE TABLE public.attributes (
    id integer NOT NULL,
    attribute_type_id integer NOT NULL,
    title character varying NOT NULL
);

ALTER TABLE
    public.attributes OWNER TO pozys;

--
-- Name: attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: pozys
--
ALTER TABLE
    public.attributes
ALTER COLUMN
    id
ADD
    GENERATED ALWAYS AS IDENTITY (
        SEQUENCE NAME public.attributes_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1
    );

--
-- Name: movies; Type: TABLE; Schema: public; Owner: pozys
--
CREATE TABLE public.movies (
    id integer NOT NULL,
    title character varying NOT NULL
);

ALTER TABLE
    public.movies OWNER TO pozys;

--
-- Name: values; Type: TABLE; Schema: public; Owner: pozys
--
CREATE TABLE public."values" (
    movie_id integer NOT NULL,
    attribute_id integer NOT NULL,
    text_value text,
    boolean_value boolean DEFAULT false NOT NULL,
    float_value real,
    date_value date,
    integer_value integer
);

ALTER TABLE
    public."values" OWNER TO pozys;

--
-- Name: marketing; Type: VIEW; Schema: public; Owner: pozys
--
CREATE VIEW public.marketing AS
SELECT
    m.title AS movie,
    at2.title AS attribute_type,
    a.title AS attribute,
    CASE
        at2.value_type
        WHEN 'text' :: public.value_type THEN v.text_value
        WHEN 'boolean' :: public.value_type THEN (v.boolean_value) :: text
        WHEN 'float' :: public.value_type THEN (v.float_value) :: text
        WHEN 'integer' :: public.value_type THEN (v.integer_value) :: text
        WHEN 'date' :: public.value_type THEN (v.date_value) :: text
        ELSE '' :: text
    END AS value
FROM
    (
        (
            (
                public.movies m
                JOIN public."values" v ON ((m.id = v.movie_id))
            )
            JOIN public.attributes a ON ((v.attribute_id = a.id))
        )
        JOIN public.attribute_types at2 ON ((a.attribute_type_id = at2.id))
    );

ALTER TABLE
    public.marketing OWNER TO pozys;

--
-- Name: movies_id_seq; Type: SEQUENCE; Schema: public; Owner: pozys
--
ALTER TABLE
    public.movies
ALTER COLUMN
    id
ADD
    GENERATED ALWAYS AS IDENTITY (
        SEQUENCE NAME public.movies_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1
    );

--
-- Name: tasks; Type: VIEW; Schema: public; Owner: pozys
--
CREATE VIEW public.tasks AS
SELECT
    m.title AS movie,
    ac.title AS actual_tasks,
    aa.title AS actual_20_days_before_tasks
FROM
    (
        (
            (
                (
                    public.movies m
                    LEFT JOIN public."values" vc ON (
                        (
                            (m.id = vc.movie_id)
                            AND (vc.date_value = CURRENT_DATE)
                        )
                    )
                )
                LEFT JOIN public.attributes ac ON (
                    (
                        (vc.attribute_id = ac.id)
                        AND (ac.attribute_type_id = 5)
                    )
                )
            )
            LEFT JOIN public."values" va ON (
                (
                    (m.id = va.movie_id)
                    AND (va.date_value >= (CURRENT_DATE + 20))
                )
            )
        )
        LEFT JOIN public.attributes aa ON (
            (
                (va.attribute_id = aa.id)
                AND (aa.attribute_type_id = 5)
            )
        )
    );

ALTER TABLE
    public.tasks OWNER TO pozys;

--
-- Data for Name: attribute_types; Type: TABLE DATA; Schema: public; Owner: pozys
--
COPY public.attribute_types (id, title, value_type)
FROM
    stdin;

4 Важные даты date 1 Рецензии text 2 Премия boolean 5 Служебные даты date \.--
-- Data for Name: attributes; Type: TABLE DATA; Schema: public; Owner: pozys
--
COPY public.attributes (id, attribute_type_id, title)
FROM
    stdin;

1 1 Рецензия 1 2 1 Рецензия 2 3 2 Оскар 4 2 Ника 6 4 Мировая премьера 7 4 Премьера в России 8 5 Начало продажи билетов 9 5 Запуск рекламы \.--
-- Data for Name: movies; Type: TABLE DATA; Schema: public; Owner: pozys
--
COPY public.movies (id, title)
FROM
    stdin;

4 Фильм 3 1 Фильм 1 3 Фильм 2 \.--
-- Data for Name: values; Type: TABLE DATA; Schema: public; Owner: pozys
--
COPY public."values" (
    movie_id,
    attribute_id,
    text_value,
    boolean_value,
    float_value,
    date_value,
    integer_value
)
FROM
    stdin;

1 1 Текст рецензии 1 f \ N \ N \ N 1 2 Текст рецензии 2 f \ N \ N \ N 1 3 t \ N \ N \ N 1 4 \ N f \ N \ N \ N 3 1 Текст рецензии 1 f \ N \ N \ N 3 2 Текст рецензии 2 f \ N \ N \ N 3 4 \ N f \ N \ N \ N 3 3 t \ N \ N \ N 1 8 \ N f \ N 2024 -03 -14 \ N 1 9 \ N f \ N 2024 -04 -11 \ N 3 8 \ N f \ N 2024 -03 -15 \ N 4 8 \ N f \ N 2024 -04 -16 \ N 4 9 \ N f \ N 2024 -04 -01 \ N 4 1 Текст рецензии f \ N \ N \ N 4 3 \ N t \ N \ N \ N 4 4 \ N t \ N \ N \ N 3 9 \ N f \ N 2024 -03 -14 \ N \.--
-- Name: attribute_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: pozys
--
SELECT
    pg_catalog.setval('public.attribute_types_id_seq', 5, true);

--
-- Name: attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: pozys
--
SELECT
    pg_catalog.setval('public.attributes_id_seq', 9, true);

--
-- Name: movies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: pozys
--
SELECT
    pg_catalog.setval('public.movies_id_seq', 4, true);

--
-- Name: attribute_types attribute_types_pk; Type: CONSTRAINT; Schema: public; Owner: pozys
--
ALTER TABLE
    ONLY public.attribute_types
ADD
    CONSTRAINT attribute_types_pk PRIMARY KEY (id);

--
-- Name: attributes attributes_pk; Type: CONSTRAINT; Schema: public; Owner: pozys
--
ALTER TABLE
    ONLY public.attributes
ADD
    CONSTRAINT attributes_pk PRIMARY KEY (id);

--
-- Name: movies movies_pkey; Type: CONSTRAINT; Schema: public; Owner: pozys
--
ALTER TABLE
    ONLY public.movies
ADD
    CONSTRAINT movies_pkey PRIMARY KEY (id);

--
-- Name: values values_pk; Type: CONSTRAINT; Schema: public; Owner: pozys
--
ALTER TABLE
    ONLY public."values"
ADD
    CONSTRAINT values_pk PRIMARY KEY (movie_id, attribute_id);

--
-- Name: attribute_types_value_type_idx; Type: INDEX; Schema: public; Owner: pozys
--
CREATE INDEX attribute_types_value_type_idx ON public.attribute_types USING btree (value_type);

--
-- Name: attributes_attribute_type_id_idx; Type: INDEX; Schema: public; Owner: pozys
--
CREATE INDEX attributes_attribute_type_id_idx ON public.attributes USING btree (attribute_type_id);

--
-- Name: values_attribute_id_idx; Type: INDEX; Schema: public; Owner: pozys
--
CREATE INDEX values_attribute_id_idx ON public."values" USING btree (attribute_id);

--
-- Name: values_movie_id_idx; Type: INDEX; Schema: public; Owner: pozys
--
CREATE INDEX values_movie_id_idx ON public."values" USING btree (movie_id);

--
-- Name: attributes attributes_attribute_types_fk; Type: FK CONSTRAINT; Schema: public; Owner: pozys
--
ALTER TABLE
    ONLY public.attributes
ADD
    CONSTRAINT attributes_attribute_types_fk FOREIGN KEY (attribute_type_id) REFERENCES public.attribute_types(id) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- Name: values values_attributes_fk; Type: FK CONSTRAINT; Schema: public; Owner: pozys
--
ALTER TABLE
    ONLY public."values"
ADD
    CONSTRAINT values_attributes_fk FOREIGN KEY (attribute_id) REFERENCES public.attributes(id) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- Name: values values_movies_fk; Type: FK CONSTRAINT; Schema: public; Owner: pozys
--
ALTER TABLE
    ONLY public."values"
ADD
    CONSTRAINT values_movies_fk FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- PostgreSQL database dump complete
--