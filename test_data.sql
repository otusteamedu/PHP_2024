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
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.countries VALUES (1, 'Россия', NULL);
INSERT INTO public.countries VALUES (2, 'Франция', NULL);
INSERT INTO public.countries VALUES (3, 'США', NULL);
INSERT INTO public.countries VALUES (4, 'Китай', NULL);


--
-- Data for Name: genres; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.genres VALUES (1, 'Комедия', NULL);
INSERT INTO public.genres VALUES (2, 'Боевик', NULL);
INSERT INTO public.genres VALUES (3, 'Научная фантастика', NULL);
INSERT INTO public.genres VALUES (4, 'Детектив', NULL);


--
-- Data for Name: halls; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.halls VALUES (1, 'Зал #1', NULL);
INSERT INTO public.halls VALUES (2, 'зал №2', NULL);


--
-- Data for Name: movies; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.movies VALUES (1, 'Операция «Ы» и другие приключения Шурика', 'описание:', 1965, 2, NULL);
INSERT INTO public.movies VALUES (2, 'Риддик', 'описание:', 2013, 2, NULL);
INSERT INTO public.movies VALUES (3, 'Возвращение высокого блондина', 'описание:', 1974, 2, NULL);


--
-- Data for Name: movie_country; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.movie_country VALUES (1, 1);
INSERT INTO public.movie_country VALUES (2, 3);
INSERT INTO public.movie_country VALUES (3, 2);


--
-- Data for Name: movie_genre; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.movie_genre VALUES (1, 1);
INSERT INTO public.movie_genre VALUES (2, 2);
INSERT INTO public.movie_genre VALUES (2, 3);
INSERT INTO public.movie_genre VALUES (3, 1);
INSERT INTO public.movie_genre VALUES (3, 3);


--
-- Data for Name: order_statuses; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.order_statuses VALUES (1, 'Ожидает оплаты', NULL);
INSERT INTO public.order_statuses VALUES (2, 'Оплачен', NULL);


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.roles VALUES (1, 'Кассир', NULL);
INSERT INTO public.roles VALUES (2, 'Зрите��ь', NULL);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES (1, '1@ya.ru', 'Кассир #1', '2024-07-04 11:42:32', NULL, 1);
INSERT INTO public.users VALUES (2, '2@ya.ru', 'Зритель #1', '2024-07-04 11:42:59', NULL, 2);
INSERT INTO public.users VALUES (3, '3@ya.ru', 'Зритель #2', '2024-07-04 11:43:25', NULL, 2);


--
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.orders VALUES (1, 1, 1, '2024-07-04 12:14:12', NULL);
INSERT INTO public.orders VALUES (2, 2, 2, '2024-07-04 12:14:21', NULL);
INSERT INTO public.orders VALUES (3, 3, 2, '2024-07-04 12:14:33', NULL);
INSERT INTO public.orders VALUES (4, 2, 2, '2024-07-04 12:14:41', NULL);
INSERT INTO public.orders VALUES (5, 3, 1, '2024-07-04 12:14:51', NULL);
INSERT INTO public.orders VALUES (6, 2, 2, '2024-07-04 12:15:06', NULL);


--
-- Data for Name: seats; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.seats VALUES (1, 1, 1, 1, NULL);
INSERT INTO public.seats VALUES (2, 1, 2, 1, NULL);
INSERT INTO public.seats VALUES (3, 1, 3, 1, NULL);
INSERT INTO public.seats VALUES (4, 1, 4, 1, NULL);
INSERT INTO public.seats VALUES (5, 1, 5, 1, NULL);
INSERT INTO public.seats VALUES (6, 2, 1, 1, NULL);
INSERT INTO public.seats VALUES (7, 2, 2, 1, NULL);
INSERT INTO public.seats VALUES (8, 2, 3, 1, NULL);
INSERT INTO public.seats VALUES (9, 2, 4, 1, NULL);
INSERT INTO public.seats VALUES (10, 2, 5, 1, NULL);
INSERT INTO public.seats VALUES (11, 1, 1, 2, NULL);
INSERT INTO public.seats VALUES (12, 1, 2, 2, NULL);
INSERT INTO public.seats VALUES (13, 1, 3, 2, NULL);
INSERT INTO public.seats VALUES (14, 1, 4, 2, NULL);
INSERT INTO public.seats VALUES (15, 1, 5, 2, NULL);


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.sessions VALUES (1, '2024-07-05 10:00:00', '2024-07-05 11:30:00', 1, NULL);
INSERT INTO public.sessions VALUES (2, '2024-07-06 21:00:00', '2024-07-06 23:00:00', 2, NULL);
INSERT INTO public.sessions VALUES (3, '2024-07-07 10:00:00', '2024-07-07 11:30:00', 1, NULL);
INSERT INTO public.sessions VALUES (4, '2024-07-08 15:30:00', '2024-07-08 17:00:00', 3, NULL);


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
INSERT INTO public.tickets VALUES (8, 1, 8, 10.00, NULL);
INSERT INTO public.tickets VALUES (9, 1, 9, 10.00, NULL);
INSERT INTO public.tickets VALUES (10, 1, 10, 10.00, NULL);
INSERT INTO public.tickets VALUES (11, 2, 11, 15.00, NULL);
INSERT INTO public.tickets VALUES (12, 2, 12, 15.00, NULL);
INSERT INTO public.tickets VALUES (13, 2, 13, 15.00, NULL);
INSERT INTO public.tickets VALUES (14, 2, 14, 15.00, NULL);
INSERT INTO public.tickets VALUES (15, 2, 15, 15.00, NULL);
INSERT INTO public.tickets VALUES (16, 3, 11, 5.00, NULL);
INSERT INTO public.tickets VALUES (17, 3, 12, 5.00, NULL);
INSERT INTO public.tickets VALUES (18, 3, 13, 5.00, NULL);
INSERT INTO public.tickets VALUES (19, 3, 14, 5.00, NULL);
INSERT INTO public.tickets VALUES (20, 3, 15, 5.00, NULL);
INSERT INTO public.tickets VALUES (21, 4, 11, 9.00, NULL);
INSERT INTO public.tickets VALUES (22, 4, 12, 9.00, NULL);
INSERT INTO public.tickets VALUES (23, 4, 13, 9.00, NULL);
INSERT INTO public.tickets VALUES (24, 4, 14, 9.00, NULL);
INSERT INTO public.tickets VALUES (25, 4, 15, 9.00, NULL);


--
-- Data for Name: order_ticket; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.order_ticket VALUES (1, 1);
INSERT INTO public.order_ticket VALUES (1, 2);
INSERT INTO public.order_ticket VALUES (2, 3);
INSERT INTO public.order_ticket VALUES (2, 4);
INSERT INTO public.order_ticket VALUES (2, 5);
INSERT INTO public.order_ticket VALUES (2, 25);


--
-- Name: countries_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.countries_id_seq', 4, true);


--
-- Name: genres_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.genres_id_seq', 4, true);


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

SELECT pg_catalog.setval('public.seats_id_seq', 15, true);


--
-- Name: sessions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sessions_id_seq', 4, true);


--
-- Name: tickets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tickets_id_seq', 25, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 3, true);


--
-- PostgreSQL database dump complete
--
