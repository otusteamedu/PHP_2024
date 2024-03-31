SELECT
	film_id , sum(price) AS total
FROM tbl_ticket AS t
LEFT JOIN tbl_show AS s ON t.show_id = s.id
WHERE t.paid = true
GROUP BY film_id
ORDER BY total desc
LIMIT 1;