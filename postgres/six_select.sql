--1. Выбор всех фильмов на сегодня
SELECT film.name FROM film
JOIN session
ON film.id = session.film_id AND DATE(session.time_display) = CURRENT_DATE;



--2. Подсчёт проданных билетов за неделю
SELECT COUNT(*) FROM ticket
JOIN session
ON ticket.session_id = session.id AND extract(week from cast(session.time_display as date)) = extract(week from cast(current_date as date));



--3. Формирование афиши (фильмы, которые показывают сегодня)
SELECT film.name, session.time_display FROM film
JOIN session
ON film.id = session.film_id AND DATE(session.time_display) = CURRENT_DATE;



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
SELECT name, film_cost_week(id) AS cost FROM film
ORDER BY cost DESC
LIMIT 3;



--5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT site.id, site_row, site_number FROM site
LEFT JOIN ticket
ON ticket.site_id = site.id AND ticket.session_id = 0
WHERE ticket.site_id IS NULL 
ORDER BY site.site_row;
--так же этот запрос определён в функции
SELECT * FROM get_free_site(0);



--6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
SELECT MAX(ticket.price), MIN(ticket.price) 
FROM ticket
WHERE session_id = 0;

--или определим специальную функцию
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

SELECT * FROM min_max_price(0);