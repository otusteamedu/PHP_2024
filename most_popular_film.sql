SELECT Films.name as "most_popular_film", COUNT(Tikets.id) as "count_of_tikets", sum(Tikets.price) as "income" FROM `Films`
    INNER JOIN Cinema_sessions ON Films.id=Cinema_sessions.id
    INNER JOIN Tikets ON Cinema_sessions.id=Tikets.id
GROUP BY Films.name
ORDER BY `income` DESC LIMIT 1;
