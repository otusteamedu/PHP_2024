-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN
ANALYZE
SELECT
	min_price.session_id,
	min_price.min,
	max_price.max
FROM (
	SELECT t.session_id, max(price)
	FROM tickets t
	WHERE t.session_id = 2
	GROUP BY t.session_id
) as max_price
JOIN (
	SELECT t.session_id, min(price)
	FROM tickets t
	WHERE t.session_id = 2
	GROUP BY t.session_id
) as min_price ON max_price.session_id = min_price.session_id;
