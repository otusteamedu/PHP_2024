SELECT movieid, SUM(amount) AS 'max sum'
FROM orderdetails
GROUP BY movieid
ORDER BY 'max sum' DESC LIMIT 1;
