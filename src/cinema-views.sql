-- Cleanup
DROP VIEW IF EXISTS q_1_today_movies;
DROP VIEW IF EXISTS q_2_weekly_sales;
DROP VIEW IF EXISTS q_3_movies_poster;
DROP VIEW IF EXISTS q_4_weekly_sales_valuable_movies;
DROP VIEW IF EXISTS q_5_hall_schema;
DROP VIEW IF EXISTS q_6_min_max_session_price;

-- Create "q_1_today_movies"
CREATE VIEW
    q_1_today_movies
AS SELECT
    movies.title AS movie_title
FROM
    sessions
JOIN
    movies ON movies.id = sessions.movie_id
WHERE
    NOW() BETWEEN sessions.date_start AND CURRENT_DATE + INTERVAL '1 days'
ORDER BY
    sessions.date_start
;

-- Create "q_2_weekly_sales"
CREATE VIEW
    q_2_weekly_sales
AS SELECT
    COUNT(sales.id)
FROM
    sales
WHERE
    sales.date BETWEEN NOW() - INTERVAL '6 days' AND NOW()
;

-- Create "q_3_movies_poster"
CREATE VIEW
    q_3_movies_poster
AS SELECT
    movies.title AS movie_title,
    halls.name AS session_hall_name,
    sessions.date_start AS session_start_date,
    sessions.date_end AS session_end_date
FROM
    sessions
JOIN
    movies ON movies.id = sessions.movie_id
JOIN
    halls ON halls.id = sessions.hall_id
WHERE
    sessions.date_start BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL '1 days'
ORDER BY
    sessions.date_start
;

-- Create "q_4_weekly_sales_valuable_movies"
CREATE VIEW
    q_4_weekly_sales_valuable_movies
AS SELECT
    movies.title AS movie_title,
    sum(sales.grand_total) as sales_grand_total
FROM
    movies
JOIN
    sessions ON sessions.movie_id = movies.id
JOIN
    sales ON sales.session_id = sessions.id
WHERE
    sales.date BETWEEN NOW() - INTERVAL '6 days' AND NOW()
GROUP BY
    movies.id
ORDER BY
    sales_grand_total DESC
;

-- Create "q_5_hall_schema"
CREATE VIEW
    q_5_hall_schema
AS SELECT
    halls.name AS hall_name,
    hall_seats.row_number AS hall_seat_row_number,
    hall_seats.place_number AS hall_seat_place_number,
    CASE WHEN sales.seat_id IS NOT NULL THEN false ELSE true END AS is_available
FROM
    halls
JOIN
    sessions ON sessions.hall_id = halls.id
JOIN
    hall_seats ON hall_seats.hall_id = halls.id
LEFT JOIN
    sales ON sales.session_id = sessions.id AND sales.seat_id = hall_seats.id
WHERE
    sessions.id = (SELECT session_id from sales LIMIT 1)
;

-- Create "q_6_min_max_session_price"
CREATE VIEW
    q_6_min_max_session_price
AS SELECT
    movies.title,
    min(hall_seats.price) AS min_price,
    max(hall_seats.price) AS max_price
FROM
    sessions
JOIN
    movies ON movies.id = sessions.movie_id
JOIN
    hall_seats ON hall_seats.hall_id = sessions.hall_id
WHERE
    sessions.id = (SELECT session_id from sales LIMIT 1)
GROUP BY
    movies.id
;
