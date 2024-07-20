explain analyze
SELECT s.id                     as session_id,
       MIN(s2.markup + s.price) as min_final_price,
       MAX(s2.markup + s.price) as max_final_price
FROM sessions s
         JOIN halls h on h.id = s.hall_id
         JOIN seats s2 on h.id = s2.hall_id
GROUP BY s.id;
