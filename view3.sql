--Формирование афиши (фильмы, которые показывают сегодня)
SELECT f.title, s.time_start, s.time_end - s.time_start AS duration
FROM tbl_film f
LEFT JOIN tbl_show s ON s.film_id = f.id
WHERE s.date = CURRENT_DATE;