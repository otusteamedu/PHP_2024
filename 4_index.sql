--1. Выбор всех фильмов на сегодня
DROP INDEX IF EXISTS IX_SHOWTIME_1;
DROP INDEX IF EXISTS IX_SHOWTIME_2;
EXPLAIN ANALYZE select * FROM query_1;

CREATE INDEX IX_SHOWTIME_1 ON showtime (film_id);
CREATE INDEX IX_SHOWTIME_2 ON showtime (start);

EXPLAIN ANALYZE select * FROM query_1;

DROP INDEX IF EXISTS IX_SHOWTIME_1;
EXPLAIN ANALYZE SELECT * from query_1;
--2. Подсчёт проданных билетов за неделю
DROP INDEX IF EXISTS IX_PURCHASE_1;
EXPLAIN ANALYZE SELECT * from query_2;
CREATE INDEX IX_PURCHASE_1 ON purchase (purchase_date);
EXPLAIN ANALYZE SELECT * from query_2;
--3. Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN ANALYZE SELECT * from query_3;
--4. Поиск 3 самых прибыльных фильмов за неделю
DROP INDEX IF EXISTS IX_SHOWTIME_2;
DROP INDEX IF EXISTS IX_SHOWTIME_3;
EXPLAIN ANALYZE SELECT * from query_4;
CREATE INDEX IX_SHOWTIME_3 ON showtime(date(start));
EXPLAIN ANALYZE SELECT * from query_4;

--5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
EXPLAIN ANALYZE SELECT * from query_5;
--6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN ANALYZE SELECT * from query_6;
