EXPLAIN ANALYZE
SELECT seat_number, is_sold
FROM seats
WHERE session_id = <specific_session_id>;
