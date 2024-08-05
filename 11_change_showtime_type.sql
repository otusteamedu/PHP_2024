ALTER TABLE timetable ADD COLUMN showtime_unix INT;
UPDATE timetable SET showtime_unix = EXTRACT(EPOCH FROM showtime)::INT;
ALTER TABLE timetable DROP COLUMN showtime;
ALTER TABLE timetable RENAME COLUMN showtime_unix TO showtime;

SELECT * FROM timetable
WHERE showtime >= EXTRACT(EPOCH FROM TIMESTAMP '2024-07-27 00:00:00')::INT
  AND showtime < EXTRACT(EPOCH FROM TIMESTAMP '2024-07-28 00:00:00')::INT;


--Seq Scan on timetable  (cost=0.00..2946.00 rows=1 width=12)
--  Filter: ((showtime >= 1722038400) AND (showtime < 1722124800))

CREATE INDEX idx_timetable_showtime_partial ON timetable(showtime)
    WHERE DATE(showtime) = '2024-07-27';

--Bitmap Heap Scan on timetable  (cost=5.09..222.41 rows=66 width=12)
--  Recheck Cond: ((showtime >= 1722038400) AND (showtime < 1722124800))
--  ->  Bitmap Index Scan on idx_timetable_showtime_partial  (cost=0.00..5.08 rows=66 width=0)
--        Index Cond: ((showtime >= 1722038400) AND (showtime < 1722124800))

-- перевод поле в int и хранение в timestamp в совокупности с индексом отлично оптимизировала запрос по выборке сеансов на дату