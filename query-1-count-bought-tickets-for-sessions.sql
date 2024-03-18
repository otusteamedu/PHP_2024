-- Посчитать проданные билеты и их суммарную стоимость для каждого сеанса

select ticket.session_id, count(id)  as tickets_sold, sum(price) as earned
from ticket
where bought = TRUE
group by (session_id)
order by tickets_sold