SELECT m.title   AS movie_title,
       s.start   AS start_time,
       m.duration,
       c.title   AS theater_title,
       ch.title  AS hall_title,
       t.seat_id AS seat,
       t.price   AS ticket_price
FROM tickets t
         JOIN shows s ON t.show_id = s.id
         JOIN movies m ON s.movie_id = m.id
         JOIN cinema_halls ch ON s.cinema_hall_id = ch.id
         JOIN cinemas c ON ch.cinema_id = c.id
WHERE t.id NOT IN (SELECT pt.ticket_id FROM purchase_tickets pt)
ORDER BY s.start;