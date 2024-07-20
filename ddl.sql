--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3 (Debian 16.3-1.pgdg120+1)
-- Dumped by pg_dump version 16.3 (Debian 16.3-1.pgdg120+1)

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
-- Name: attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attributes (
                                   id bigint NOT NULL,
                                   name character varying(255) NOT NULL,
                                   attr_type_id bigint NOT NULL,
                                   deleted_at timestamp(0) without time zone
);


ALTER TABLE public.attributes OWNER TO postgres;

--
-- Name: attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.attributes_id_seq OWNER TO postgres;

--
-- Name: attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attributes_id_seq OWNED BY public.attributes.id;


--
-- Name: attributes_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attributes_types (
                                         id bigint NOT NULL,
                                         name character varying(255) NOT NULL,
                                         deleted_at timestamp(0) without time zone
);


ALTER TABLE public.attributes_types OWNER TO postgres;

--
-- Name: attributes_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attributes_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.attributes_types_id_seq OWNER TO postgres;

--
-- Name: attributes_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attributes_types_id_seq OWNED BY public.attributes_types.id;


--
-- Name: movies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movies (
                               id bigint NOT NULL,
                               title character varying(255) NOT NULL,
                               created_at timestamp(0) without time zone NOT NULL,
                               deleted_at timestamp(0) without time zone
);


ALTER TABLE public.movies OWNER TO postgres;

--
-- Name: v_bool; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.v_bool (
                               value_id bigint NOT NULL,
                               value boolean NOT NULL
);


ALTER TABLE public.v_bool OWNER TO postgres;

--
-- Name: v_date; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.v_date (
                               value_id bigint NOT NULL,
                               value date NOT NULL
);


ALTER TABLE public.v_date OWNER TO postgres;

--
-- Name: v_decimal; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.v_decimal (
                                  value_id bigint NOT NULL,
                                  value numeric(8,2) NOT NULL
);


ALTER TABLE public.v_decimal OWNER TO postgres;

--
-- Name: v_integer; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.v_integer (
                                  value_id bigint NOT NULL,
                                  value bigint NOT NULL
);


ALTER TABLE public.v_integer OWNER TO postgres;

--
-- Name: v_text; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.v_text (
                               value_id bigint NOT NULL,
                               value text NOT NULL
);


ALTER TABLE public.v_text OWNER TO postgres;

--
-- Name: values; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."values" (
                                 id bigint NOT NULL,
                                 movie_id bigint NOT NULL,
                                 attr_id bigint NOT NULL
);


ALTER TABLE public."values" OWNER TO postgres;

--
-- Name: marketing; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.marketing AS
SELECT m.title,
       a.name AS attribute_name,
       t.name AS attribute_type_name,
       COALESCE((vb.value)::text, (vd.value)::text, (d.value)::text, (vi.value)::text, vt.value) AS value
FROM ((((((((public."values" v
    LEFT JOIN public.movies m ON ((v.movie_id = m.id)))
    LEFT JOIN public.attributes a ON ((v.attr_id = a.id)))
    LEFT JOIN public.attributes_types t ON ((a.attr_type_id = t.id)))
    LEFT JOIN public.v_bool vb ON ((v.id = vb.value_id)))
    LEFT JOIN public.v_date vd ON ((v.id = vd.value_id)))
    LEFT JOIN public.v_decimal d ON ((v.id = d.value_id)))
    LEFT JOIN public.v_integer vi ON ((v.id = vi.value_id)))
    LEFT JOIN public.v_text vt ON ((v.id = vt.value_id)))
WHERE ((m.deleted_at IS NULL) AND (a.deleted_at IS NULL) AND (t.deleted_at IS NULL));


ALTER VIEW public.marketing OWNER TO postgres;

--
-- Name: movies_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.movies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.movies_id_seq OWNER TO postgres;

--
-- Name: movies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.movies_id_seq OWNED BY public.movies.id;


--
-- Name: service_tasks; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.service_tasks AS
SELECT m.title,
       a.name AS task,
       vd.value AS task_date
FROM (((public.v_date vd
    LEFT JOIN public."values" v ON ((vd.value_id = v.id)))
    LEFT JOIN public.movies m ON ((v.movie_id = m.id)))
    LEFT JOIN public.attributes a ON ((v.attr_id = a.id)))
WHERE (((vd.value = CURRENT_DATE) OR (vd.value = (CURRENT_DATE + 20))) AND (a.id = ANY (ARRAY[(1)::bigint, (2)::bigint])) AND (m.deleted_at IS NULL));


ALTER VIEW public.service_tasks OWNER TO postgres;

--
-- Name: values_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.values_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.values_id_seq OWNER TO postgres;

--
-- Name: values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.values_id_seq OWNED BY public."values".id;


--
-- Name: attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes ALTER COLUMN id SET DEFAULT nextval('public.attributes_id_seq'::regclass);


--
-- Name: attributes_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes_types ALTER COLUMN id SET DEFAULT nextval('public.attributes_types_id_seq'::regclass);


--
-- Name: movies id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movies ALTER COLUMN id SET DEFAULT nextval('public.movies_id_seq'::regclass);


--
-- Name: values id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."values" ALTER COLUMN id SET DEFAULT nextval('public.values_id_seq'::regclass);


--
-- Name: attributes attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_pkey PRIMARY KEY (id);


--
-- Name: attributes_types attributes_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes_types
    ADD CONSTRAINT attributes_types_pkey PRIMARY KEY (id);


--
-- Name: movies movies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movies
    ADD CONSTRAINT movies_pkey PRIMARY KEY (id);


--
-- Name: v_bool v_bool_value_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_bool
    ADD CONSTRAINT v_bool_value_id_unique UNIQUE (value_id);


--
-- Name: v_date v_date_value_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_date
    ADD CONSTRAINT v_date_value_id_unique UNIQUE (value_id);


--
-- Name: v_decimal v_decimal_value_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_decimal
    ADD CONSTRAINT v_decimal_value_id_unique UNIQUE (value_id);


--
-- Name: v_integer v_integer_value_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_integer
    ADD CONSTRAINT v_integer_value_id_unique UNIQUE (value_id);


--
-- Name: v_text v_text_value_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_text
    ADD CONSTRAINT v_text_value_id_unique UNIQUE (value_id);


--
-- Name: values values_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."values"
    ADD CONSTRAINT values_pkey PRIMARY KEY (id);


--
-- Name: attributes attributes_attr_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_attr_type_id_foreign FOREIGN KEY (attr_type_id) REFERENCES public.attributes_types(id);


--
-- Name: v_bool v_bool_value_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_bool
    ADD CONSTRAINT v_bool_value_id_foreign FOREIGN KEY (value_id) REFERENCES public."values"(id);


--
-- Name: v_date v_date_value_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_date
    ADD CONSTRAINT v_date_value_id_foreign FOREIGN KEY (value_id) REFERENCES public."values"(id);


--
-- Name: v_decimal v_decimal_value_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_decimal
    ADD CONSTRAINT v_decimal_value_id_foreign FOREIGN KEY (value_id) REFERENCES public."values"(id);


--
-- Name: v_integer v_integer_value_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_integer
    ADD CONSTRAINT v_integer_value_id_foreign FOREIGN KEY (value_id) REFERENCES public."values"(id);


--
-- Name: v_text v_text_value_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.v_text
    ADD CONSTRAINT v_text_value_id_foreign FOREIGN KEY (value_id) REFERENCES public."values"(id);


--
-- Name: values values_attr_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."values"
    ADD CONSTRAINT values_attr_id_foreign FOREIGN KEY (attr_id) REFERENCES public.attributes(id);


--
-- Name: values values_movie_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."values"
    ADD CONSTRAINT values_movie_id_foreign FOREIGN KEY (movie_id) REFERENCES public.movies(id);


--
-- PostgreSQL database dump complete
--

