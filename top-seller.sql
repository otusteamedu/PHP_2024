SELECT m.title,
       SUM(t.price) AS top_seller
FROM movie m
         JOIN
     show s ON m.movie_id = s.movie_id
         JOIN
     Ticket t ON s.show_id = t.show_id
GROUP BY m.title
ORDER BY top_seller DESC LIMIT 1;
