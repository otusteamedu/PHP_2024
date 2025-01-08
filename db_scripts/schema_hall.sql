-- EXPLAIN (ANALYZE, BUFFERS)
SELECT st.horizont, st.vertical, 
    CASE WHEN t.is_sold = TRUE THEN 'Занято' ELSE 'Доступно' END AS status
FROM seat st
LEFT JOIN ticket t ON st.id = t.seat_id AND t.session_id = :session_id
WHERE st.hall_id = (
    SELECT hall_id FROM session WHERE id = :session_id
)
ORDER BY st.horizont, st.vertical;
