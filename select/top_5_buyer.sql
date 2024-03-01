SELECT SUM(session.price) AS money, ticket.owner AS owner
FROM ticket
LEFT JOIN session
    ON session.id = ticket.id
GROUP BY ticket.owner
ORDER BY money DESC
LIMIT 5;
