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
-- Data for Name: halls; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.halls VALUES (1, 'Зал #1', NULL);
INSERT INTO public.halls VALUES (2, 'Зал №2', NULL);


--
-- Data for Name: movies; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.movies VALUES (2, 'Риддик', 'очень интерестно', 2, NULL);
INSERT INTO public.movies VALUES (3, 'Полицейский из Беверли Хил3', 'очень интерестно', 2, NULL);
INSERT INTO public.movies VALUES (1, 'Унесеные ветром', 'очень интерестно', 2, NULL);


--
-- Data for Name: order_statuses; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.order_statuses VALUES (1, 'Ожидает оплаты', NULL);
INSERT INTO public.order_statuses VALUES (2, 'Оплачен', NULL);


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.roles VALUES (1, 'Кассир', NULL);
INSERT INTO public.roles VALUES (2, 'Зритель', NULL);


--
-- Data for Name: seats; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.seats VALUES (1, 'A1', 1, NULL);
INSERT INTO public.seats VALUES (2, 'A2', 1, NULL);
INSERT INTO public.seats VALUES (3, 'A3', 1, NULL);
INSERT INTO public.seats VALUES (4, 'A4', 1, NULL);
INSERT INTO public.seats VALUES (5, 'A5', 1, NULL);
INSERT INTO public.seats VALUES (6, 'A6', 1, NULL);
INSERT INTO public.seats VALUES (7, 'A7', 1, NULL);
INSERT INTO public.seats VALUES (8, 'B1', 2, NULL);
INSERT INTO public.seats VALUES (9, 'B2', 2, NULL);
INSERT INTO public.seats VALUES (10, 'B3', 2, NULL);
INSERT INTO public.seats VALUES (11, 'B4', 2, NULL);
INSERT INTO public.seats VALUES (12, 'B5', 2, NULL);


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.sessions VALUES (1, '2024-07-09 14:45:43', 1, NULL);
INSERT INTO public.sessions VALUES (2, '2024-07-10 14:46:24', 1, NULL);
INSERT INTO public.sessions VALUES (3, '2024-07-09 14:46:44', 2, NULL);


--
-- Data for Name: tickets; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tickets VALUES (1, 1, 1, 10.00, NULL);
INSERT INTO public.tickets VALUES (2, 1, 2, 10.00, NULL);
INSERT INTO public.tickets VALUES (3, 1, 3, 10.00, NULL);
INSERT INTO public.tickets VALUES (4, 1, 4, 10.00, NULL);
INSERT INTO public.tickets VALUES (5, 1, 5, 10.00, NULL);
INSERT INTO public.tickets VALUES (6, 1, 6, 10.00, NULL);
INSERT INTO public.tickets VALUES (7, 1, 7, 10.00, NULL);
INSERT INTO public.tickets VALUES (8, 3, 8, 15.00, NULL);
INSERT INTO public.tickets VALUES (9, 3, 9, 15.00, NULL);
INSERT INTO public.tickets VALUES (10, 3, 10, 15.00, NULL);
INSERT INTO public.tickets VALUES (11, 3, 11, 15.00, NULL);
INSERT INTO public.tickets VALUES (12, 3, 12, 15.00, NULL);
INSERT INTO public.tickets VALUES (13, 2, 8, 7.00, NULL);
INSERT INTO public.tickets VALUES (14, 2, 9, 7.00, NULL);
INSERT INTO public.tickets VALUES (15, 2, 10, 7.00, NULL);
INSERT INTO public.tickets VALUES (16, 2, 11, 7.00, NULL);
INSERT INTO public.tickets VALUES (17, 2, 12, 7.00, NULL);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES (1, '1@ya.ru', 'кассир #1', '2024-07-03 14:58:18', NULL, 1);
INSERT INTO public.users VALUES (2, '2@ya.ru', 'зритель #1', '2024-07-03 14:59:07', NULL, 2);
INSERT INTO public.users VALUES (3, '3@ya.ru', 'зритель #2', '2024-07-03 15:02:48', NULL, 2);


--
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.orders VALUES (1, 1, 1, 2, '2024-07-03 15:04:31', NULL);
INSERT INTO public.orders VALUES (2, 1, 2, 1, '2024-07-03 15:04:49', NULL);
INSERT INTO public.orders VALUES (3, 1, 3, 2, '2024-07-03 15:06:11', NULL);
INSERT INTO public.orders VALUES (4, 2, 10, 2, '2024-07-03 15:06:54', NULL);
INSERT INTO public.orders VALUES (5, 3, 14, 2, '2024-07-03 15:07:14', NULL);
INSERT INTO public.orders VALUES (6, 1, 12, 2, '2024-07-03 15:07:59', NULL);


--
-- Name: halls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.halls_id_seq', 2, true);


--
-- Name: movies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.movies_id_seq', 3, true);


--
-- Name: order_statuses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.order_statuses_id_seq', 2, true);


--
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orders_id_seq', 6, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 2, true);


--
-- Name: seats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seats_id_seq', 12, true);


--
-- Name: sessions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sessions_id_seq', 3, true);


--
-- Name: tickets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tickets_id_seq', 17, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 3, true);


--
-- PostgreSQL database dump complete
--

