--2. Подсчёт проданных билетов за неделю

SELECT count(tickets.id) as CTN from tickets
    join orders on orders.id = tickets.order_id
    where orders.date_created BETWEEN CURRENT_DATE - interval '6 days' AND CURRENT_DATE