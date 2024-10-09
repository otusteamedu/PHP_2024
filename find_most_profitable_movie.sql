SELECT m.title              AS movie_title,
       SUM(ts.total_amount) AS total_revenue
FROM Movies m
         JOIN
     Sessions s ON m.id = s.movie_id
         JOIN
     Tickets t ON s.id = t.session_id
         JOIN
     TicketSales ts ON t.id = ts.ticket_id
GROUP BY m.title
ORDER BY total_revenue DESC LIMIT 1;
