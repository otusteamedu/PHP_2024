SELECT * FROM sessions
WHERE movie_id = 1;

SELECT * FROM "order"
WHERE user_id = 1;

SELECT * FROM "order"
                  JOIN "user" u on u.id = "order".user_id
WHERE u.email = 'mail1@mail.ru';

SELECT movie_id, COUNT(o.id) FROM sessions
JOIN "order" o on sessions.id = o.session_id
WHERE movie_id=1
GROUP BY movie_id;
