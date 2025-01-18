SELECT movies.name           AS film,
       sessions.session_time AS session_time,
       halls.room_number     AS room,
       places.row            AS row,
       places.place          AS place,
       prices.price          AS price,
       tickets.user_id       AS status
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN halls ON sessions.hall_id = halls.id
         JOIN places ON halls.id = places.hall_id
         JOIN prices ON sessions.id = prices.session_id AND places.id = prices.place_id
         LEFT JOIN tickets ON prices.id = tickets.price_id
ORDER BY session_time ASC;
