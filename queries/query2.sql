-- 2. Подсчёт проданных билетов за неделю

select count(*) as total
from public.ticket t
where t.date >= (current_date - 6) and t.date <= current_date;