CREATE TABLE film 
(
    Id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    price NUMERIC
);

CREATE TABLE hall
(
    Id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    status_ratio NUMERIC --status_ratio э{1.0, 1.2, 3.0}
                    --standart = 1.0
                    --FULL HD = 1.2 
                    -- 3D = 3.0
);

CREATE TABLE session
(
    Id SERIAL PRIMARY KEY,
    time_display TIMESTAMP,
    time_ratio NUMERIC, -- status_ratio э{1.0, 1.5, 2.0} 
                        -- 1.0 утро буднего дня
                        -- 1.5  вечер буднего дня / утро выходного
                        -- 2.0  вечер выходного дня
    film_id INTEGER,
    hall_id INTEGER,
    FOREIGN KEY (film_id) REFERENCES film (Id) ON DELETE CASCADE,
    FOREIGN KEY (hall_id) REFERENCES hall (Id) ON DELETE CASCADE
);

CREATE TABLE site
(
    Id SERIAL PRIMARY KEY,
    site_row INTEGER,
    site_number INTEGER,
    status_ratio NUMERIC -- status_ratio э{1.0, 1.5, 2.0} 
                        --standart = 1.0
                        --vip = 1.5 
                        --chill zone = 2.0
);

CREATE TABLE ticket
(
    Id SERIAL PRIMARY KEY,
    site_id INTEGER,
    session_id INTEGER,
    FOREIGN KEY (site_id) REFERENCES site (Id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES session (Id) ON DELETE CASCADE,
    price NUMERIC  -- = film.price * hall.status_ratio * site.status_ratio * session.time_ratio
);

CREATE TABLE buyer
(
    Id SERIAL PRIMARY KEY,
    name VARCHAR(150),
    ticket_id INTEGER,
    FOREIGN KEY (ticket_id) REFERENCES ticket (Id) ON DELETE CASCADE
);



INSERT INTO film (Id, name, price)
VALUES
(0, 'Ворон', 200),
(1, 'Ларго Винч: Гнев прошлого', 250),
(2, 'Лунтик. Возвращение домой', 190);

INSERT INTO hall (id, name, status_ratio)
VALUES 
(0, 'Обычный зал', 1.0),
(1, 'Вип-зал', 1.5),
(2, '3D зал', 2.0);

INSERT INTO session (id, time_display, film_id, hall_id)
VALUES 
(0, '2024-09-10 21:00', 0, 0),
(1, '2024-09-10 18:00', 1, 0),
(2, '2024-09-10 12:00', 2, 0),

(3, '2024-09-11 23:00', 0, 0),
(4, '2024-09-11 18:00', 1, 1),
(5, '2024-09-11 12:00', 2, 1),

(6, '2024-09-12 21:00', 1, 2),
(7, '2024-09-12 17:00', 2, 2),
(8, '2024-09-12 22:00', 2, 2),

(9, '2024-09-10 19:00', 0, 1),
(10, '2024-09-10 17:00', 1, 1),
(11, '2024-09-10 21:00', 2, 2);



INSERT INTO site (Id, site_row, site_number, status_ratio)
VALUES
(0, 1, 1, 1.0),
(2, 1, 2, 1.0),
(3, 1, 3, 1.0),
(4, 1, 4, 1.0),

(5, 2, 1, 1.0),
(6, 2, 2, 1.5),
(7, 2, 3, 1.5),
(8, 2, 4, 1.0),

(10, 3, 1, 1.0),
(11, 3, 2, 1.5),
(12, 3, 3, 1.5),
(13, 3, 4, 1.0),

(14, 4, 1, 1.5),
(15, 4, 2, 2.0),
(16, 4, 3, 2.0),
(17, 4, 4, 1.5);


--функция расчета цены на сессию и место
CREATE OR REPLACE FUNCTION get_price(current_session_id INTEGER, current_site_id INTEGER)
    RETURNS INTEGER

AS
$$
DECLARE 

    current_price INTEGER;

BEGIN

    SELECT
    (SELECT price FROM film WHERE film.id = 
    (SELECT film_id FROM session WHERE Id = current_session_id)) * 
    (SELECT status_ratio FROM hall WHERE hall.id = 
    (SELECT hall_id FROM session WHERE Id = current_session_id)) * 
    (SELECT status_ratio FROM site WHERE site.id = current_site_id)
    INTO current_price;

    RETURN current_price;

END;
$$
LANGUAGE plpgsql;

INSERT INTO ticket (Id, site_id, session_id, price)
VALUES 
(0, 6, 0, (SELECT * FROM get_price(0, 6))),
(1, 7, 0, (SELECT * FROM get_price(0, 7))),
(2, 11, 1, (SELECT * FROM get_price(1, 11))),
(3, 12, 3, (SELECT * FROM get_price(3, 12))),
(4, 10, 3,(SELECT * FROM get_price(3, 10))),
(5, 5, 5, (SELECT * FROM get_price(5, 5))),
(6, 6, 6, (SELECT * FROM get_price(6, 6))),
(7, 11, 0, (SELECT * FROM get_price(0, 11))),
(8, 15, 2, (SELECT * FROM get_price(2, 15))),
(9, 16, 2, (SELECT * FROM get_price(2, 16)));

INSERT INTO buyer (name, ticket_id)
VALUES
('Петя', 0),
('Ваня', 1),
('Вова', 2),
('Дима', 3),
('Даша', 4),
('Маша', 5),
('Аня', 6),
('Яна', 7),

('Дима', 8),
('Яна', 9);



--1000 случайных показов
do $$
 declare 
  counter integer := 12;
 begin
  while counter <= 1000 loop
	 INSERT INTO session (id, time_display, film_id, hall_id)
		VALUES (
            counter, -- просто по порядку
			(SELECT date_trunc('hour', (current_date + (random() * 360) * '1 day'::interval)) as enddate), -- случайная дата с точночтью до часа с сегодня на год вперд
			(SELECT Id FROM film ORDER BY RANDOM() LIMIT 1), --случайный фильм
			(SELECT Id FROM hall ORDER BY RANDOM() LIMIT 1) --случайный зал
		);
	raise notice 'Counter %', counter;
	counter := counter + 1;
  end loop;
 end$$;

--в одном зале не могут идти одновременно несколько фильмов
DELETE FROM session s1 USING session s2 
WHERE (s1.id > s2.id) 
AND (s1.hall_id = s2.hall_id) 
AND (date_trunc('hour', (s1.time_display)) = (date_trunc('hour', (s2.time_display))));



--функция проверки свободных мест на сессию с конкретным id
CREATE OR REPLACE FUNCTION get_free_site(current_session_id INTEGER)
    RETURNS TABLE (
		Id INTEGER, 
		ses_site_row INTEGER, 
		ses_site_number INTEGER
	)
AS
$$
BEGIN

    RETURN QUERY
        SELECT site.id, site_row, site_number FROM site
        LEFT JOIN ticket
        ON ticket.site_id = site.id AND ticket.session_id = current_session_id
        WHERE ticket.site_id IS NULL 
        ORDER BY site.site_row;

END;
$$
LANGUAGE plpgsql;



--заполним 10000 билетов и на имеющихся покупателей
DO $$
DECLARE

    counter INTEGER := 1;
    current_site_id INTEGER;
    current_session_id INTEGER;
    current_id INTEGER;

BEGIN
    while counter <= 10000 LOOP
        SELECT MAX(Id)+1 FROM ticket INTO current_id; --вычисляем id
        SELECT Id FROM session ORDER BY RANDOM() LIMIT 1 INTO current_session_id; --случайнм образом вбираем сессию из существующих
        SELECT * FROM get_free_site(current_session_id) INTO current_site_id; --выбираем свободное место

        --генерируем случайный билет
        INSERT INTO ticket (Id, session_id, site_id, price) VALUES (
            current_id, 
            current_session_id, 
            current_site_id, 
            (SELECT * FROM get_price(current_session_id, current_site_id)) --считаем цену
        );

        --присваиваем билет покупателям
        INSERT INTO buyer (name, ticket_id) VALUES
		((SELECT name FROM buyer ORDER BY RANDOM() LIMIT 1), current_id);

        raise notice 'Counter %', counter;
        counter := counter + 1;
    END LOOP;
END$$;



--не пригодится, так как функция get_free_site не даст повторений НО на всякий случай оставлю тут
--DELETE FROM ticket AS t1 USING ticket AS t2 WHERE (t1.id > t2.id) AND (t1.session_id = t2.session_id) AND (t1.site_id = t2.site_id);