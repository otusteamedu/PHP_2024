--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 17.1

-- Started on 2025-01-12 17:56:39

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2 (class 3079 OID 16384)
-- Name: adminpack; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS adminpack WITH SCHEMA pg_catalog;


--
-- TOC entry 4572 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION adminpack; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION adminpack IS 'administrative functions for PostgreSQL';


--
-- TOC entry 3 (class 3079 OID 615323)
-- Name: uuid-ossp; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;


--
-- TOC entry 4573 (class 0 OID 0)
-- Dependencies: 3
-- Name: EXTENSION "uuid-ossp"; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';


--
-- TOC entry 249 (class 1255 OID 713756)
-- Name: fill_hall_rows(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fill_hall_rows() RETURNS boolean
    LANGUAGE plpgsql
    AS $$DECLARE
  hallrow RECORD;
BEGIN
  DELETE FROM cinema_hall_rows;

  FOR hallrow IN
	SELECT uuid, s.a+1 as num_seat, ((s.a/num_cols)+1) num_row, 
		  mod(s.a, num_cols)+1 num_col, num_rows, num_cols 
		  FROM cinema_halls, generate_series(0, cinema_halls.num_seats-1) as s(a)     
	LOOP		
		INSERT INTO cinema_hall_rows(id_hall, num_row, num_col, num_seat)
	VALUES (hallrow.uuid, hallrow.num_row, hallrow.num_col, hallrow.num_seat);
  	END LOOP;	  
	return true;
END;
$$;


ALTER FUNCTION public.fill_hall_rows() OWNER TO postgres;

--
-- TOC entry 251 (class 1255 OID 717948)
-- Name: fill_session_all_halls_random_films(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fill_session_all_halls_random_films(days integer) RETURNS boolean
    LANGUAGE plpgsql
    AS $$DECLARE
    date_year date := '2025-1-1';
	i integer := 0;
	num_film integer := 0;
	begin_time time := '07:00:00';
	durval interval := '00:00:00';
	filmrow RECORD;
	hallrow RECORD;
    temprow RECORD;
BEGIN
	 DELETE FROM cinema_sessions;
	 FOR hallrow IN
		SELECT uuid FROM cinema_halls     
	 LOOP		
		FOR i in 0..days LOOP
		  durval := '00:00:00';
		  WHILE durval < '17:00:00' LOOP
		  num_film := 1+random()*9;
			
		  FOR filmrow IN
			SELECT uuid, duration FROM cinema_films as s WHERE s.num=num_film LIMIT 1     
		  LOOP	  
			INSERT INTO cinema_sessions(uuid, id_hall, id_film, begin_date, begin_time) 
			  VALUES (gen_random_uuid(), hallrow.uuid, filmrow.uuid, date_year+i, begin_time+durval);
		  END LOOP;
		  durval := durval + filmrow.duration; 
		  END LOOP;
  		END LOOP;
	END LOOP;	
	
    -- заменим случайный uuid на предустановленный 
	-- чтобы не переписывать запросы 5,6 с этим параметром
    FOR temprow IN
        SELECT uuid FROM cinema_sessions as s WHERE s.id_hall = uuid('8a00af45-7d72-48d8-8195-a86cd03dc98b') 
		offset random() * (select count(*) from cinema_sessions where id_hall = uuid('8a00af45-7d72-48d8-8195-a86cd03dc98b')) limit 1
    LOOP
		UPDATE cinema_sessions SET uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')  
		  WHERE uuid = temprow.uuid;		
	END LOOP;
  
	return true;
END;
$$;


ALTER FUNCTION public.fill_session_all_halls_random_films(days integer) OWNER TO postgres;

--
-- TOC entry 248 (class 1255 OID 698311)
-- Name: fill_tickets_no_prices(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fill_tickets_no_prices() RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
	temprow RECORD;
    num integer := 0; 
BEGIN
	EXECUTE format('DELETE FROM cinema_tickets');
	FOR temprow IN
        SELECT s.uuid, h.num_seats FROM cinema_sessions as s 
			LEFT JOIN cinema_halls as h ON s.id_hall = h.uuid 
			ORDER BY begin_date, begin_time
    	LOOP
			FOR num IN 1..temprow.num_seats LOOP
    			INSERT INTO cinema_tickets(id_session, num_seat, price, sold) 
				  VALUES (temprow.uuid, num, 0, false);
			END LOOP;
		END LOOP;	  
	RETURN TRUE;
END;
$$;


ALTER FUNCTION public.fill_tickets_no_prices() OWNER TO postgres;

--
-- TOC entry 250 (class 1255 OID 712197)
-- Name: fill_tickets_prices(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fill_tickets_prices() RETURNS boolean
    LANGUAGE plpgsql
    AS $$DECLARE
	timerow RECORD;
	ticketrow RECORD; 
BEGIN
	FOR timerow IN
	  SELECT p1.id_hall, p1.begin_date, p1.begin_time as begin_time, MIN(p2.begin_time) as end_time, p1.num_seat, p1.price FROM cinema_prices as p1 
        LEFT JOIN cinema_prices as p2 ON p1.id_hall = p2.id_hall AND p1.begin_date = p2.begin_date 
	      AND p1.num_seat = p2.num_seat AND p1.begin_time < p2.begin_time
      GROUP BY p1.id_hall, p1.begin_date, p1.begin_time, p1.num_seat, p1.price 
      ORDER BY begin_date, begin_time
	LOOP
  	  FOR ticketrow IN
        SELECT id_session, num_seat FROM cinema_tickets as t
		  INNER JOIN cinema_sessions as s ON s.uuid = t.id_session
		WHERE s.id_hall = timerow.id_hall AND s.begin_date >= timerow.begin_date
		  AND (t.num_seat = timerow.num_seat OR timerow.num_seat = 0) 
		  AND s.begin_time >= timerow.begin_time 
		  AND (s.begin_time < timerow.end_time OR timerow.end_time IS NULL)
      LOOP
		UPDATE cinema_tickets as t SET price = timerow.price  
		  WHERE t.id_session = ticketrow.id_session AND t.num_seat = ticketrow.num_seat;		
	  END LOOP;	
	END LOOP;  
	return true;
END;
$$;


ALTER FUNCTION public.fill_tickets_prices() OWNER TO postgres;

--
-- TOC entry 247 (class 1255 OID 708139)
-- Name: fill_tickets_random_sold(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.fill_tickets_random_sold() RETURNS boolean
    LANGUAGE plpgsql
    AS $$DECLARE
	temprow RECORD;
BEGIN
	FOR temprow IN
        SELECT id_session, num_seat, RANDOM() < 0.7 as sold FROM cinema_tickets
    LOOP
		UPDATE cinema_tickets as t SET sold = temprow.sold  
		  WHERE t.id_session = temprow.id_session AND t.num_seat = temprow.num_seat;		
	END LOOP;	  
	return true;
END;
$$;


ALTER FUNCTION public.fill_tickets_random_sold() OWNER TO postgres;

--
-- TOC entry 235 (class 1255 OID 694704)
-- Name: random_string(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.random_string(length integer) RETURNS text
    LANGUAGE plpgsql
    AS $$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$$;


ALTER FUNCTION public.random_string(length integer) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 219 (class 1259 OID 642220)
-- Name: cinema_films; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cinema_films (
    uuid uuid DEFAULT gen_random_uuid() NOT NULL,
    name character varying(100) NOT NULL,
    duration interval,
    num integer
);


ALTER TABLE public.cinema_films OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 713533)
-- Name: cinema_hall_rows; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cinema_hall_rows (
    id_hall uuid NOT NULL,
    num_row integer NOT NULL,
    num_col integer NOT NULL,
    num_seat integer NOT NULL
);


ALTER TABLE public.cinema_hall_rows OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 642278)
-- Name: cinema_halls; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cinema_halls (
    uuid uuid DEFAULT gen_random_uuid() NOT NULL,
    name character varying(100) NOT NULL,
    num_seats integer DEFAULT 0 NOT NULL,
    num_rows integer,
    num_cols integer
);


ALTER TABLE public.cinema_halls OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 642394)
-- Name: cinema_prices; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cinema_prices (
    id_hall uuid NOT NULL,
    begin_date date NOT NULL,
    begin_time time without time zone NOT NULL,
    num_seat integer DEFAULT 0 NOT NULL,
    price numeric(15,2) DEFAULT '0'::numeric NOT NULL
);


ALTER TABLE public.cinema_prices OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 642679)
-- Name: cinema_sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cinema_sessions (
    uuid uuid DEFAULT gen_random_uuid() NOT NULL,
    id_hall uuid NOT NULL,
    id_film uuid NOT NULL,
    begin_date date NOT NULL,
    begin_time time without time zone NOT NULL
);


ALTER TABLE public.cinema_sessions OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 642694)
-- Name: cinema_tickets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cinema_tickets (
    id_session uuid NOT NULL,
    num_seat integer NOT NULL,
    price numeric(15,2) NOT NULL,
    sold boolean DEFAULT false NOT NULL
);


ALTER TABLE public.cinema_tickets OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 615471)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id bigint NOT NULL,
    version character varying(255) NOT NULL,
    class character varying(255) NOT NULL,
    "group" character varying(255) NOT NULL,
    namespace character varying(255) NOT NULL,
    "time" integer NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 615470)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 4574 (class 0 OID 0)
-- Dependencies: 217
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 4393 (class 2604 OID 615474)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4561 (class 0 OID 642220)
-- Dependencies: 219
-- Data for Name: cinema_films; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cinema_films (uuid, name, duration, num) FROM stdin;
0388b3d9-0dec-4ff2-81ea-cfe5ff4896f8	Форест Гамп	02:22:00	1
03a2144e-0a39-418a-a5d2-2884dba282c8	Терминатор	01:48:00	2
3e6e9966-c923-4fb4-99ae-b61dd059c9c3	Зеленая миля	03:09:00	3
5c5af2cf-f153-4e4d-af81-d0dd8a83c258	Титаник	02:40:00	4
75313151-7256-45e7-a57b-e0e99abafb21	Кинд-дза-дза	02:15:00	5
7daa263e-e9e3-455b-9724-ebc2bb9120dd	Солярис	02:49:00	6
94228176-6de7-4185-b019-4f491827a700	Без лица	02:18:00	7
9ff5e3c7-21a3-42e9-b6fb-aff1e1e173dc	Джентельмены удачи	01:24:00	8
a563880d-3ef6-471e-ae41-0adbf8c6a562	Молчание ягнят	01:58:00	9
aeb75115-d9a7-4415-a396-33ac69d97f9a	Один дома	01:43:00	10
\.


--
-- TOC entry 4566 (class 0 OID 713533)
-- Dependencies: 224
-- Data for Name: cinema_hall_rows; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cinema_hall_rows (id_hall, num_row, num_col, num_seat) FROM stdin;
8a00af45-7d72-48d8-8195-a86cd03dc98b	1	1	1
8a00af45-7d72-48d8-8195-a86cd03dc98b	1	2	2
8a00af45-7d72-48d8-8195-a86cd03dc98b	1	3	3
8a00af45-7d72-48d8-8195-a86cd03dc98b	1	4	4
8a00af45-7d72-48d8-8195-a86cd03dc98b	1	5	5
8a00af45-7d72-48d8-8195-a86cd03dc98b	1	6	6
8a00af45-7d72-48d8-8195-a86cd03dc98b	1	7	7
8a00af45-7d72-48d8-8195-a86cd03dc98b	1	8	8
8a00af45-7d72-48d8-8195-a86cd03dc98b	2	1	9
8a00af45-7d72-48d8-8195-a86cd03dc98b	2	2	10
8a00af45-7d72-48d8-8195-a86cd03dc98b	2	3	11
8a00af45-7d72-48d8-8195-a86cd03dc98b	2	4	12
8a00af45-7d72-48d8-8195-a86cd03dc98b	2	5	13
8a00af45-7d72-48d8-8195-a86cd03dc98b	2	6	14
8a00af45-7d72-48d8-8195-a86cd03dc98b	2	7	15
8a00af45-7d72-48d8-8195-a86cd03dc98b	2	8	16
8a00af45-7d72-48d8-8195-a86cd03dc98b	3	1	17
8a00af45-7d72-48d8-8195-a86cd03dc98b	3	2	18
8a00af45-7d72-48d8-8195-a86cd03dc98b	3	3	19
8a00af45-7d72-48d8-8195-a86cd03dc98b	3	4	20
8a00af45-7d72-48d8-8195-a86cd03dc98b	3	5	21
8a00af45-7d72-48d8-8195-a86cd03dc98b	3	6	22
8a00af45-7d72-48d8-8195-a86cd03dc98b	3	7	23
8a00af45-7d72-48d8-8195-a86cd03dc98b	3	8	24
8a00af45-7d72-48d8-8195-a86cd03dc98b	4	1	25
8a00af45-7d72-48d8-8195-a86cd03dc98b	4	2	26
8a00af45-7d72-48d8-8195-a86cd03dc98b	4	3	27
8a00af45-7d72-48d8-8195-a86cd03dc98b	4	4	28
8a00af45-7d72-48d8-8195-a86cd03dc98b	4	5	29
8a00af45-7d72-48d8-8195-a86cd03dc98b	4	6	30
8a00af45-7d72-48d8-8195-a86cd03dc98b	4	7	31
8a00af45-7d72-48d8-8195-a86cd03dc98b	4	8	32
8a00af45-7d72-48d8-8195-a86cd03dc98b	5	1	33
8a00af45-7d72-48d8-8195-a86cd03dc98b	5	2	34
8a00af45-7d72-48d8-8195-a86cd03dc98b	5	3	35
8a00af45-7d72-48d8-8195-a86cd03dc98b	5	4	36
8a00af45-7d72-48d8-8195-a86cd03dc98b	5	5	37
8a00af45-7d72-48d8-8195-a86cd03dc98b	5	6	38
8a00af45-7d72-48d8-8195-a86cd03dc98b	5	7	39
8a00af45-7d72-48d8-8195-a86cd03dc98b	5	8	40
8a00af45-7d72-48d8-8195-a86cd03dc98b	6	1	41
8a00af45-7d72-48d8-8195-a86cd03dc98b	6	2	42
8a00af45-7d72-48d8-8195-a86cd03dc98b	6	3	43
8a00af45-7d72-48d8-8195-a86cd03dc98b	6	4	44
8a00af45-7d72-48d8-8195-a86cd03dc98b	6	5	45
8a00af45-7d72-48d8-8195-a86cd03dc98b	6	6	46
8a00af45-7d72-48d8-8195-a86cd03dc98b	6	7	47
8a00af45-7d72-48d8-8195-a86cd03dc98b	6	8	48
8a00af45-7d72-48d8-8195-a86cd03dc98b	7	1	49
8a00af45-7d72-48d8-8195-a86cd03dc98b	7	2	50
8a00af45-7d72-48d8-8195-a86cd03dc98b	7	3	51
8a00af45-7d72-48d8-8195-a86cd03dc98b	7	4	52
8a00af45-7d72-48d8-8195-a86cd03dc98b	7	5	53
8a00af45-7d72-48d8-8195-a86cd03dc98b	7	6	54
8a00af45-7d72-48d8-8195-a86cd03dc98b	7	7	55
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	1	1	1
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	1	2	2
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	1	3	3
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	1	4	4
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	1	5	5
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	1	6	6
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	2	1	7
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	2	2	8
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	2	3	9
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	2	4	10
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	2	5	11
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	2	6	12
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	3	1	13
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	3	2	14
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	3	3	15
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	3	4	16
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	3	5	17
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	3	6	18
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	4	1	19
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	4	2	20
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	4	3	21
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	4	4	22
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	4	5	23
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	4	6	24
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	5	1	25
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	5	2	26
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	5	3	27
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	5	4	28
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	5	5	29
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	5	6	30
b5281049-2737-4575-bdd1-47c4b8960532	1	1	1
b5281049-2737-4575-bdd1-47c4b8960532	1	2	2
b5281049-2737-4575-bdd1-47c4b8960532	1	3	3
b5281049-2737-4575-bdd1-47c4b8960532	1	4	4
b5281049-2737-4575-bdd1-47c4b8960532	1	5	5
b5281049-2737-4575-bdd1-47c4b8960532	2	1	6
b5281049-2737-4575-bdd1-47c4b8960532	2	2	7
b5281049-2737-4575-bdd1-47c4b8960532	2	3	8
b5281049-2737-4575-bdd1-47c4b8960532	2	4	9
b5281049-2737-4575-bdd1-47c4b8960532	2	5	10
b5281049-2737-4575-bdd1-47c4b8960532	3	1	11
b5281049-2737-4575-bdd1-47c4b8960532	3	2	12
b5281049-2737-4575-bdd1-47c4b8960532	3	3	13
b5281049-2737-4575-bdd1-47c4b8960532	3	4	14
b5281049-2737-4575-bdd1-47c4b8960532	3	5	15
b5281049-2737-4575-bdd1-47c4b8960532	4	1	16
b5281049-2737-4575-bdd1-47c4b8960532	4	2	17
b5281049-2737-4575-bdd1-47c4b8960532	4	3	18
b5281049-2737-4575-bdd1-47c4b8960532	4	4	19
b5281049-2737-4575-bdd1-47c4b8960532	4	5	20
b5281049-2737-4575-bdd1-47c4b8960532	5	1	21
b5281049-2737-4575-bdd1-47c4b8960532	5	2	22
b5281049-2737-4575-bdd1-47c4b8960532	5	3	23
b5281049-2737-4575-bdd1-47c4b8960532	5	4	24
b5281049-2737-4575-bdd1-47c4b8960532	5	5	25
\.


--
-- TOC entry 4562 (class 0 OID 642278)
-- Dependencies: 220
-- Data for Name: cinema_halls; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cinema_halls (uuid, name, num_seats, num_rows, num_cols) FROM stdin;
8a00af45-7d72-48d8-8195-a86cd03dc98b	Большой зал	55	7	8
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	Малый зал	30	5	6
b5281049-2737-4575-bdd1-47c4b8960532	Розовый зал	25	5	5
\.


--
-- TOC entry 4563 (class 0 OID 642394)
-- Dependencies: 221
-- Data for Name: cinema_prices; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cinema_prices (id_hall, begin_date, begin_time, num_seat, price) FROM stdin;
8a00af45-7d72-48d8-8195-a86cd03dc98b	2025-01-01	07:00:00	0	300.00
8a00af45-7d72-48d8-8195-a86cd03dc98b	2025-01-01	13:00:00	0	500.00
8a00af45-7d72-48d8-8195-a86cd03dc98b	2025-01-01	17:00:00	0	600.00
8a00af45-7d72-48d8-8195-a86cd03dc98b	2025-01-01	07:00:00	28	400.00
8a00af45-7d72-48d8-8195-a86cd03dc98b	2025-01-01	07:00:00	29	400.00
8a00af45-7d72-48d8-8195-a86cd03dc98b	2025-01-01	13:00:00	28	600.00
8a00af45-7d72-48d8-8195-a86cd03dc98b	2025-01-01	13:00:00	29	600.00
8a00af45-7d72-48d8-8195-a86cd03dc98b	2025-01-01	17:00:00	28	700.00
8a00af45-7d72-48d8-8195-a86cd03dc98b	2025-01-01	17:00:00	29	700.00
9673aa24-b4d1-42c8-8bdb-03f4f36c1f94	2025-01-01	07:00:00	0	500.00
b5281049-2737-4575-bdd1-47c4b8960532	2025-01-01	07:00:00	0	600.00
\.


--
-- TOC entry 4564 (class 0 OID 642679)
-- Dependencies: 222
-- Data for Name: cinema_sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cinema_sessions (uuid, id_hall, id_film, begin_date, begin_time) FROM stdin;
\.


--
-- TOC entry 4565 (class 0 OID 642694)
-- Dependencies: 223
-- Data for Name: cinema_tickets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cinema_tickets (id_session, num_seat, price, sold) FROM stdin;
\.


--
-- TOC entry 4560 (class 0 OID 615471)
-- Dependencies: 218
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, version, class, "group", namespace, "time", batch) FROM stdin;
5	2024-12-14-214354	App\\Database\\Migrations\\Cinema_Films	default	App	1734889969	1
6	2024-12-22-165847	App\\Database\\Migrations\\CinrmaHalls	default	App	1734890123	2
10	2024-12-22-170157	App\\Database\\Migrations\\CinemaPrices	default	App	1734891109	3
13	2024-12-22-182551	App\\Database\\Migrations\\CinemaSesions	default	App	1734892952	4
14	2024-12-22-182606	App\\Database\\Migrations\\CimenaTickets	default	App	1734892952	4
\.


--
-- TOC entry 4575 (class 0 OID 0)
-- Dependencies: 217
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 14, true);


--
-- TOC entry 4404 (class 2606 OID 642225)
-- Name: cinema_films pk_cinema_films; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinema_films
    ADD CONSTRAINT pk_cinema_films PRIMARY KEY (uuid);


--
-- TOC entry 4406 (class 2606 OID 642283)
-- Name: cinema_halls pk_cinema_halls; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinema_halls
    ADD CONSTRAINT pk_cinema_halls PRIMARY KEY (uuid);


--
-- TOC entry 4410 (class 2606 OID 642683)
-- Name: cinema_sessions pk_cinema_sessions; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinema_sessions
    ADD CONSTRAINT pk_cinema_sessions PRIMARY KEY (uuid);


--
-- TOC entry 4402 (class 2606 OID 615478)
-- Name: migrations pk_migrations; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT pk_migrations PRIMARY KEY (id);


--
-- TOC entry 4408 (class 2606 OID 642407)
-- Name: cinema_prices uk_cimena_prices; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinema_prices
    ADD CONSTRAINT uk_cimena_prices UNIQUE (id_hall, begin_date, begin_time, num_seat);


--
-- TOC entry 4412 (class 2606 OID 642701)
-- Name: cinema_tickets uk_cinema_tikets; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinema_tickets
    ADD CONSTRAINT uk_cinema_tikets UNIQUE (id_session, num_seat);


--
-- TOC entry 4413 (class 2606 OID 642399)
-- Name: cinema_prices cinema_prices_id_hall_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinema_prices
    ADD CONSTRAINT cinema_prices_id_hall_foreign FOREIGN KEY (id_hall) REFERENCES public.cinema_halls(uuid);


--
-- TOC entry 4414 (class 2606 OID 642689)
-- Name: cinema_sessions cinema_sessions_id_film_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinema_sessions
    ADD CONSTRAINT cinema_sessions_id_film_foreign FOREIGN KEY (id_film) REFERENCES public.cinema_films(uuid);


--
-- TOC entry 4415 (class 2606 OID 642684)
-- Name: cinema_sessions cinema_sessions_id_hall_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinema_sessions
    ADD CONSTRAINT cinema_sessions_id_hall_foreign FOREIGN KEY (id_hall) REFERENCES public.cinema_halls(uuid);


-- Completed on 2025-01-12 17:56:39

--
-- PostgreSQL database dump complete
--

