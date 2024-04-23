
-- 1. Выбор всех фильмов на сегодня

EXPLAIN analyse SELECT DISTINCT name Фильм FROM films JOIN sessions s on films.id = s.film_id;

-- 2. Подсчет проданных билетов за неделю

EXPLAIN analyse SELECT SUM(amount) FROM tickets WHERE date between CURRENT_DATE - INTERVAL '7 days' AND CURRENT_DATE;

-- 3. Формирование афиши (фильмы, которые показывают сегодня)

EXPLAIN analyse SELECT name Фильм,s.timebegin Время_начала FROM films JOIN sessions s on films.id = s.film_id;

-- 4. Поиск 3 самых прибыльных фильмов за неделю

EXPLAIN analyse SELECT f.name, SUM(amount) FROM tickets
                                                    JOIN sessions s on tickets.session_id = s.id
                                                    JOIN films f on f.id = s.film_id
                WHERE date between CURRENT_DATE - INTERVAL '7 days' AND CURRENT_DATE
                GROUP BY f.name ORDER BY sum DESC LIMIT 3
;

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс (как сделать компактнее не придумал)

EXPLAIN analyse SELECT DISTINCT s.id, s.row, s.seat,
                                CASE WHEN s.id = t.seat_id THEN true ELSE false END AS Занятые_места
                FROM seats s
                         JOIN tickets t on t.date = CURRENT_DATE + INTERVAL '1 days' AND t.session_id = 'last_samurai_10'
                    EXCEPT
                SELECT DISTINCT s.id, s.row, s.seat, false FROM seats s
                                                                    JOIN tickets t on t.date = CURRENT_DATE + INTERVAL '1 days' AND t.session_id = 'last_samurai_10'
                WHERE s.id = t.seat_id
;

-- 6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс

EXPLAIN analyse SELECT f.name Фильм, ss.timebegin Начало_сеанса, MIN(v.value_float) Мин_цена, MAX(v.value_float) Макс_цена  FROM sessions ss
    JOIN films f ON ss.film_id = f.id
    JOIN values v on f.id = v.film_id AND v.attribute_id LIKE 'seat_price%'
                WHERE ss.id = 'last_samurai_10'
                GROUP BY f.name, ss.timebegin;



------ Заполнение

INSERT INTO tickets (payer_id,session_id,seat_id,amount,date)
SELECT
    'payer_100',
    (array(SELECT id FROM sessions))[floor(random()*(SELECT count(id)-1 FROM public.sessions)+1)],
    floor((random()*310) + 1),
    500.00,
    date(CURRENT_DATE + INTERVAL '3 days' - random() * ((CURRENT_DATE + INTERVAL '10 days') - CURRENT_DATE))
FROM generate_series(1,10000);

