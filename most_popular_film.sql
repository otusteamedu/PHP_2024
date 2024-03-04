SELECT Films.name as "most_popular_film", COUNT(Tikets.tiket_id) as "count_of_tikets", sum(Tikets.price) as "income" FROM `Films`
    INNER JOIN Cinema_sessions ON Films.film_id=Cinema_sessions.film_id
    INNER JOIN Tikets ON Cinema_sessions.session_id=Tikets.session_id
    GROUP BY Films.name
    ORDER BY `income` DESC LIMIT 1;

