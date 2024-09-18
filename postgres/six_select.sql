--1. Выбор всех фильмов на сегодня
EXPLAIN SELECT DISTINCT film.name FROM film
JOIN session
ON film.id = session.film_id AND DATE(session.time_display) = CURRENT_DATE;
/*
Результат для 1000 сессий:

"Unique  (cost=37.36..37.38 rows=5 width=118)"
"  ->  Sort  (cost=37.36..37.37 rows=5 width=118)"
"        Sort Key: film.name"
"        ->  Nested Loop  (cost=0.16..37.30 rows=5 width=118)"
"              ->  Seq Scan on session  (cost=0.00..24.27 rows=5 width=4)"
"                    Filter: (date(time_display) = CURRENT_DATE)"
"              ->  Memoize  (cost=0.16..4.97 rows=1 width=122)"
"                    Cache Key: session.film_id"
"                    Cache Mode: logical"
"                    ->  Index Scan using film_pkey on film  (cost=0.15..4.96 rows=1 width=122)"
"                          Index Cond: (id = session.film_id)"

Результат для 1000000 сессий:

"Unique  (cost=14751.59..14753.59 rows=200 width=118)"
"  ->  Sort  (cost=14751.59..14752.59 rows=400 width=118)"
"        Sort Key: film.name"
"        ->  Gather  (cost=14692.30..14734.30 rows=400 width=118)"
"              Workers Planned: 2"
"              ->  HashAggregate  (cost=13692.30..13694.30 rows=200 width=118)"
"                    Group Key: film.name"
"                    ->  Hash Join  (cost=19.90..13687.10 rows=2083 width=118)"
"                          Hash Cond: (session.film_id = film.id)"
"                          ->  Parallel Seq Scan on session  (cost=0.00..13661.67 rows=2083 width=4)"
"                                Filter: (date(time_display) = CURRENT_DATE)"
"                          ->  Hash  (cost=14.40..14.40 rows=440 width=122)"
"                                ->  Seq Scan on film  (cost=0.00..14.40 rows=440 width=122)"

скорость очень сильно падает на этапе посика по датам
*/

--Добавим индекс
CREATE INDEX session_date_index ON session USING btree(DATE(session.time_display));
/*
Результат для 1000 сессий:

"Unique  (cost=24.42..24.44 rows=5 width=118)"
"  ->  Sort  (cost=24.42..24.43 rows=5 width=118)"
"        Sort Key: film.name"
"        ->  Nested Loop  (cost=4.47..24.36 rows=5 width=118)"
"              ->  Bitmap Heap Scan on session  (cost=4.32..11.33 rows=5 width=4)"
"                    Recheck Cond: (date(time_display) = CURRENT_DATE)"
"                    ->  Bitmap Index Scan on session_date_index  (cost=0.00..4.32 rows=5 width=0)"
"                          Index Cond: (date(time_display) = CURRENT_DATE)"
"              ->  Memoize  (cost=0.16..4.97 rows=1 width=122)"
"                    Cache Key: session.film_id"
"                    Cache Mode: logical"
"                    ->  Index Scan using film_pkey on film  (cost=0.15..4.96 rows=1 width=122)"
"                          Index Cond: (id = session.film_id)"

Результат для 1000000 сессий:

"HashAggregate  (cost=6467.70..6469.70 rows=200 width=118)"
"  Group Key: film.name"
"  ->  Hash Join  (cost=79.08..6455.20 rows=5000 width=118)"
"        Hash Cond: (session.film_id = film.id)"
"        ->  Bitmap Heap Scan on session  (cost=59.18..6422.05 rows=5000 width=4)"
"              Recheck Cond: (date(time_display) = CURRENT_DATE)"
"              ->  Bitmap Index Scan on session_date_index  (cost=0.00..57.93 rows=5000 width=0)"
"                    Index Cond: (date(time_display) = CURRENT_DATE)"
"        ->  Hash  (cost=14.40..14.40 rows=440 width=122)"
"              ->  Seq Scan on film  (cost=0.00..14.40 rows=440 width=122)"
*/



--2. Подсчёт проданных билетов за неделю
EXPLAIN SELECT COUNT(*) FROM ticket
JOIN session
ON ticket.session_id = session.id AND extract(week from cast(session.time_display as date)) = extract(week from cast(current_date as date));

/*
Результат для 10000 билетов и 1000 сессий:

"Aggregate  (cost=219.89..219.90 rows=1 width=8)"
"  ->  Hash Join  (cost=29.27..219.76 rows=51 width=0)"
"        Hash Cond: (ticket.session_id = session.id)"
"        ->  Seq Scan on ticket  (cost=0.00..164.10 rows=10010 width=4)"
"        ->  Hash  (cost=29.21..29.21 rows=5 width=4)"
"              ->  Seq Scan on session  (cost=0.00..29.21 rows=5 width=4)"
"                    Filter: (EXTRACT(week FROM (time_display)::date) = EXTRACT(week FROM CURRENT_DATE))"

Результат для 1000000 сессий и 10000 билетов:

"Finalize Aggregate  (cost=17047.53..17047.54 rows=1 width=8)"
"  ->  Gather  (cost=17047.31..17047.52 rows=2 width=8)"
"        Workers Planned: 2"
"        ->  Partial Aggregate  (cost=16047.31..16047.32 rows=1 width=8)"
"              ->  Hash Join  (cost=289.02..16047.26 rows=21 width=0)"
"                    Hash Cond: (session.id = ticket.session_id)"
"                    ->  Parallel Seq Scan on session  (cost=0.00..15745.01 rows=2083 width=4)"
"                          Filter: (EXTRACT(week FROM (time_display)::date) = EXTRACT(week FROM CURRENT_DATE))"
"                    ->  Hash  (cost=164.01..164.01 rows=10001 width=4)"
"                          ->  Seq Scan on ticket  (cost=0.00..164.01 rows=10001 width=4)"

самое очевидное и простое упрощение - создать индекс который заменит Seq Scan на этапе поиска дат из этой недели на Bitmap Index Scan
*/

--Для этого создам индекс
CREATE INDEX session_week_index ON session USING btree(extract(week from cast(time_display as date)));
/*
Результат для 10000 билетов и 1000 сессий:

"Aggregate  (cost=202.04..202.05 rows=1 width=8)"
"  ->  Hash Join  (cost=11.42..201.91 rows=51 width=0)"
"        Hash Cond: (ticket.session_id = session.id)"
"        ->  Seq Scan on ticket  (cost=0.00..164.10 rows=10010 width=4)"
"        ->  Hash  (cost=11.36..11.36 rows=5 width=4)"
"              ->  Bitmap Heap Scan on session  (cost=4.32..11.36 rows=5 width=4)"
"                    Recheck Cond: (EXTRACT(week FROM (time_display)::date) = EXTRACT(week FROM CURRENT_DATE))"
"                    ->  Bitmap Index Scan on session_week_index  (cost=0.00..4.32 rows=5 width=0)"
"                          Index Cond: (EXTRACT(week FROM (time_display)::date) = EXTRACT(week FROM CURRENT_DATE))"

Результат для 1000000 сессий и 10000 билетов:

"Aggregate  (cost=6735.94..6735.95 rows=1 width=8)"
"  ->  Hash Join  (cost=6545.56..6735.82 rows=50 width=0)"
"        Hash Cond: (ticket.session_id = session.id)"
"        ->  Seq Scan on ticket  (cost=0.00..164.01 rows=10001 width=4)"
"        ->  Hash  (cost=6483.06..6483.06 rows=5000 width=4)"
"              ->  Bitmap Heap Scan on session  (cost=95.18..6483.06 rows=5000 width=4)"
"                    Recheck Cond: (EXTRACT(week FROM (time_display)::date) = EXTRACT(week FROM CURRENT_DATE))"
"                    ->  Bitmap Index Scan on session_week_index  (cost=0.00..93.93 rows=5000 width=0)"
"                          Index Cond: (EXTRACT(week FROM (time_display)::date) = EXTRACT(week FROM CURRENT_DATE))"
*/



--3. Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN SELECT film.name, session.time_display FROM film
JOIN session
ON film.id = session.film_id AND DATE(session.time_display) = CURRENT_DATE;

/*
Результат для 1000 сессий:

"Nested Loop  (cost=0.00..25.49 rows=5 width=126)"
"  Join Filter: (film.id = session.film_id)"
"  ->  Seq Scan on session  (cost=0.00..24.27 rows=5 width=12)"
"        Filter: (date(time_display) = CURRENT_DATE)"
"  ->  Materialize  (cost=0.00..1.04 rows=3 width=122)"
"        ->  Seq Scan on film  (cost=0.00..1.03 rows=3 width=122)"

Результат для 1000000 сессий:

"Nested Loop  (cost=1000.16..15287.20 rows=5000 width=126)"
"  ->  Gather  (cost=1000.00..15161.67 rows=5000 width=12)"
"        Workers Planned: 2"
"        ->  Parallel Seq Scan on session  (cost=0.00..13661.67 rows=2083 width=12)"
"              Filter: (date(time_display) = CURRENT_DATE)"
"  ->  Memoize  (cost=0.16..0.18 rows=1 width=122)"
"        Cache Key: session.film_id"
"        Cache Mode: logical"
"        ->  Index Scan using film_pkey on film  (cost=0.15..0.17 rows=1 width=122)"
"              Index Cond: (id = session.film_id)"

Запрос будет оптимизирован индексом session_date_index, созданным для первого запроса и даст результат:

Результат для 1000 сессий:

"Nested Loop  (cost=4.32..12.55 rows=5 width=126)"
"  Join Filter: (film.id = session.film_id)"
"  ->  Bitmap Heap Scan on session  (cost=4.32..11.33 rows=5 width=12)"
"        Recheck Cond: (date(time_display) = CURRENT_DATE)"
"        ->  Bitmap Index Scan on session_date_index  (cost=0.00..4.32 rows=5 width=0)"
"              Index Cond: (date(time_display) = CURRENT_DATE)"
"  ->  Materialize  (cost=0.00..1.04 rows=3 width=122)"
"        ->  Seq Scan on film  (cost=0.00..1.03 rows=3 width=122)"

Результат для 1000000 сессий:

"Hash Join  (cost=79.08..6455.20 rows=5000 width=126)"
"  Hash Cond: (session.film_id = film.id)"
"  ->  Bitmap Heap Scan on session  (cost=59.18..6422.05 rows=5000 width=12)"
"        Recheck Cond: (date(time_display) = CURRENT_DATE)"
"        ->  Bitmap Index Scan on session_date_index  (cost=0.00..57.93 rows=5000 width=0)"
"              Index Cond: (date(time_display) = CURRENT_DATE)"
"  ->  Hash  (cost=14.40..14.40 rows=440 width=122)"
"        ->  Seq Scan on film  (cost=0.00..14.40 rows=440 width=122)"
*/



--4. Поиск 3 самых прибыльных фильмов за неделю
--цена фильма за неделю 
CREATE OR REPLACE FUNCTION film_cost_week(
    IN current_film_id INTEGER, 
    OUT sum_price INTEGER)
AS
$$
BEGIN

    SELECT SUM(ticket.price) FROM ticket
    JOIN session
    ON ticket.session_id = session.id
    JOIN film 
    ON film.id = session.film_id AND film_id = current_film_id
    WHERE extract(week from cast(session.time_display as date)) = extract(week from cast(current_date as date))
    INTO sum_price;

END;
$$
LANGUAGE plpgsql;
--запрос
EXPLAIN SELECT name, film_cost_week(id) AS cost FROM film
ORDER BY cost DESC
LIMIT 3;

/*
Результат для 10000 билетов и 1000 сессий: 

"Limit  (cost=130.09..130.09 rows=3 width=122)"
"  ->  Sort  (cost=130.09..131.19 rows=440 width=122)"
"        Sort Key: (film_cost_week(id)) DESC"
"        ->  Seq Scan on film  (cost=0.00..124.40 rows=440 width=122)"

Результат для 1000000 сессий и 10000 билетов:

"Limit  (cost=130.09..130.09 rows=3 width=122)"
"  ->  Sort  (cost=130.09..131.19 rows=440 width=122)"
"        Sort Key: (film_cost_week(id)) DESC"
"        ->  Seq Scan on film  (cost=0.00..124.40 rows=440 width=122)"
*/

--Добавим индекс
CREATE INDEX ticket_session_id_index ON ticket USING btree(session_id);
/*
Результат для 10000 билетов и 1000 сессий: 

"Limit  (cost=1.80..1.81 rows=3 width=122)"
"  ->  Sort  (cost=1.80..1.81 rows=3 width=122)"
"        Sort Key: (film_cost_week(id)) DESC"
"        ->  Seq Scan on film  (cost=0.00..1.78 rows=3 width=122)"

Результат для 1000000 сессий и 10000 билетов:

"Limit  (cost=1.80..1.81 rows=3 width=122)"
"  ->  Sort  (cost=1.80..1.81 rows=3 width=122)"
"        Sort Key: (film_cost_week(id)) DESC"
"        ->  Seq Scan on film  (cost=0.00..1.78 rows=3 width=122)"
*/


--5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
EXPLAIN SELECT site.id, site_row, site_number FROM site
LEFT JOIN ticket
ON ticket.site_id = site.id AND ticket.session_id = 0
WHERE ticket.site_id IS NULL 
ORDER BY site.site_row;
/*
Результат для 1000 сессий и 10000 билетов:

"Sort  (cost=281.60..284.40 rows=1121 width=12)"
"  Sort Key: site.site_row"
"  ->  Hash Anti Join  (cost=189.24..224.81 rows=1121 width=12)"
"        Hash Cond: (site.id = ticket.site_id)"
"        ->  Seq Scan on site  (cost=0.00..21.30 rows=1130 width=12)"
"        ->  Hash  (cost=189.12..189.12 rows=9 width=4)"
"              ->  Seq Scan on ticket  (cost=0.00..189.12 rows=9 width=4)"
"                    Filter: (session_id = 0)"

Результат для 1000000 сессий и 10000 билетов:

"Sort  (cost=281.73..284.54 rows=1127 width=12)"
"  Sort Key: site.site_row"
"  ->  Hash Anti Join  (cost=189.05..224.60 rows=1127 width=12)"
"        Hash Cond: (site.id = ticket.site_id)"
"        ->  Seq Scan on site  (cost=0.00..21.30 rows=1130 width=12)"
"        ->  Hash  (cost=189.01..189.01 rows=3 width=4)"
"              ->  Seq Scan on ticket  (cost=0.00..189.01 rows=3 width=4)"
"                    Filter: (session_id = 0)"
*/

--Добавим индекс:
CREATE INDEX ticket_site_id_index ON ticket USING btree(site_id);
/*
Результат для 1000 сессий и 10000 билетов:

"Sort  (cost=122.81..125.62 rows=1121 width=12)"
"  Sort Key: site.site_row"
"  ->  Hash Anti Join  (cost=30.45..66.03 rows=1121 width=12)"
"        Hash Cond: (site.id = ticket.site_id)"
"        ->  Seq Scan on site  (cost=0.00..21.30 rows=1130 width=12)"
"        ->  Hash  (cost=30.34..30.34 rows=9 width=4)"
"              ->  Bitmap Heap Scan on ticket  (cost=4.35..30.34 rows=9 width=4)"
"                    Recheck Cond: (session_id = 0)"
"                    ->  Bitmap Index Scan on ticket_session_id_index  (cost=0.00..4.35 rows=9 width=0)"
"                          Index Cond: (session_id = 0)"

Результат для 1000000 сессий и 10000 билетов:

"Sort  (cost=107.11..109.93 rows=1127 width=12)"
"  Sort Key: site.site_row"
"  ->  Hash Anti Join  (cost=14.43..49.98 rows=1127 width=12)"
"        Hash Cond: (site.id = ticket.site_id)"
"        ->  Seq Scan on site  (cost=0.00..21.30 rows=1130 width=12)"
"        ->  Hash  (cost=14.40..14.40 rows=3 width=4)"
"              ->  Bitmap Heap Scan on ticket  (cost=4.31..14.40 rows=3 width=4)"
"                    Recheck Cond: (session_id = 0)"
"                    ->  Bitmap Index Scan on ticket_session_id_index  (cost=0.00..4.31 rows=3 width=0)"
"                          Index Cond: (session_id = 0)"
*/



--так же этот запрос определён в функции
EXPLAIN SELECT * FROM get_free_site(0);
/*
Результат для 1000 сессий и 10000 билетовдля 1000 сессий и 10000 билетов:

    "Function Scan on get_free_site  (cost=0.25..10.25 rows=1000 width=12)"

Результат для 1000000 сессий и 10000 билетов:

    "Function Scan on get_free_site  (cost=0.25..10.25 rows=1000 width=12)"
*/


--6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN SELECT MAX(ticket.price), MIN(ticket.price) 
FROM ticket
WHERE session_id = 0;
/*
Оптимизация запросов произойдёт за счет уже сущесвующих индексов:

Результат для 1000 сессий и 10000 билетов:
    До применения индексов:
        "Aggregate  (cost=189.17..189.18 rows=1 width=64)"
        "  ->  Seq Scan on ticket  (cost=0.00..189.12 rows=9 width=5)"
        "        Filter: (session_id = 0)"
    После:
        "Aggregate  (cost=30.39..30.40 rows=1 width=64)"
        "  ->  Bitmap Heap Scan on ticket  (cost=4.35..30.34 rows=9 width=5)"
        "        Recheck Cond: (session_id = 0)"
        "        ->  Bitmap Index Scan on ticket_session_id_index  (cost=0.00..4.35 rows=9 width=0)"
        "              Index Cond: (session_id = 0)"

Результат для 1000000 сессий и 10000 билетов:
    До:
        "Aggregate  (cost=189.03..189.04 rows=1 width=64)"
        "  ->  Seq Scan on ticket  (cost=0.00..189.01 rows=3 width=5)"
        "        Filter: (session_id = 0)"
    После:
        "Aggregate  (cost=14.41..14.42 rows=1 width=64)"
        "  ->  Bitmap Heap Scan on ticket  (cost=4.31..14.40 rows=3 width=5)"
        "        Recheck Cond: (session_id = 0)"
        "        ->  Bitmap Index Scan on ticket_session_id_index  (cost=0.00..4.31 rows=3 width=0)"
        "              Index Cond: (session_id = 0)"


*/

--определим специальную функцию
CREATE OR REPLACE FUNCTION min_max_price(
    IN current_session_id INTEGER, 
    OUT min_price INTEGER, 
    OUT max_price INTEGER)
AS
$$
BEGIN

        SELECT MIN(ticket.price) FROM ticket WHERE session_id = current_session_id INTO min_price;
		SELECT MAX(ticket.price) FROM ticket WHERE session_id = current_session_id INTO max_price;

END;
$$
LANGUAGE plpgsql;

EXPLAIN SELECT * FROM min_max_price(0);


/*
Результат для 1000 сессий и 10000 билетов:

"Function Scan on min_max_price  (cost=0.25..0.26 rows=1 width=8)"

Результат для 1000000 сессий и 10000 билетов:

"Function Scan on min_max_price  (cost=0.25..0.26 rows=1 width=8)"
*/