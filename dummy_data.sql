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

--
-- Data for Name: attributes_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.attributes_types VALUES (1, 'текст', NULL);
INSERT INTO public.attributes_types VALUES (2, 'дата', NULL);
INSERT INTO public.attributes_types VALUES (3, 'число', NULL);
INSERT INTO public.attributes_types VALUES (4, 'флаг', NULL);


--
-- Data for Name: attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.attributes VALUES (1, 'старт проката', 2, NULL);
INSERT INTO public.attributes VALUES (2, 'старт рекламы', 2, NULL);
INSERT INTO public.attributes VALUES (3, 'рецензия', 1, NULL);
INSERT INTO public.attributes VALUES (4, 'год выпуска', 3, NULL);
INSERT INTO public.attributes VALUES (5, 'наличие наград', 4, NULL);


--
-- Data for Name: movies; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.movies VALUES (1, 'Операция «Ы» и другие приключения Шурика', '2024-07-19 11:06:43', NULL);
INSERT INTO public.movies VALUES (2, 'Риддик', '2024-07-19 14:05:04', NULL);


--
-- Data for Name: values; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public."values" VALUES (1, 1, 1);
INSERT INTO public."values" VALUES (2, 1, 2);
INSERT INTO public."values" VALUES (3, 1, 4);
INSERT INTO public."values" VALUES (4, 1, 5);
INSERT INTO public."values" VALUES (5, 2, 1);
INSERT INTO public."values" VALUES (6, 2, 2);
INSERT INTO public."values" VALUES (7, 2, 5);


--
-- Data for Name: v_bool; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.v_bool VALUES (4, true);
INSERT INTO public.v_bool VALUES (7, false);


--
-- Data for Name: v_date; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.v_date VALUES (1, '2024-08-31');
INSERT INTO public.v_date VALUES (2, '2024-08-08');
INSERT INTO public.v_date VALUES (5, '2024-08-08');
INSERT INTO public.v_date VALUES (6, '2024-07-19');


--
-- Data for Name: v_decimal; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: v_integer; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.v_integer VALUES (3, 1965);


--
-- Data for Name: v_text; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: v_varchar; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attributes_id_seq', 5, true);


--
-- Name: attributes_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attributes_types_id_seq', 4, true);


--
-- Name: movies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.movies_id_seq', 2, true);


--
-- Name: values_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.values_id_seq', 7, true);


--
-- PostgreSQL database dump complete
--
