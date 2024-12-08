SELECT m.title, SUM(t.price) AS ticket_price
FROM `purchase_tickets` pt
         JOIN `purchases` p ON pt.purchase_id = p.id
         JOIN `tickets` t ON pt.ticket_id = t.id
         JOIN shows s ON t.show_id = s.id
         JOIN movies m ON s.movie_id = m.id
GROUP BY m.title;