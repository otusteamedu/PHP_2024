explain analyze
SELECT h.name    as hall_name,
       s.id      as session,
       se.number as seat_number,
       se.row    as seat_row,
       se.markup as seat_markup,
       CASE
           WHEN t.id IS NULL THEN true
           ELSE false
           END
                 AS is_available
FROM halls h
         JOIN sessions s ON h.id = s.hall_id
         JOIN seats se ON h.id = se.hall_id
         LEFT JOIN tickets t ON s.id = t.session_id AND se.id = t.seat_id;
