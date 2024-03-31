-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
EXPLAIN
ANALYZE
SELECT *
FROM
(
	SELECT *
	FROM seats s
	WHERE s.hall_id = (
		SELECT hall_id
		FROM movies_sessions ms
		WHERE ms.id = 5
	)
	ORDER BY s.row_number, s.seat_number
) as hall_places
LEFT JOIN (
	SELECT seat_id
	FROM seats s
	JOIN tickets t ON s.id = t.seat_id AND t.session_id = 5
	WHERE s.hall_id = (
		SELECT hall_id
		FROM movies_sessions ms
		WHERE ms.id = 5
	)
	ORDER BY t.session_id
) as sold_places ON hall_places.id = sold_places.seat_id;
