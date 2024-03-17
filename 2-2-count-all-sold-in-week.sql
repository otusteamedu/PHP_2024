select count(*)
from orders
where order_date >= date_trunc('week', CURRENT_DATE)::date
and order_date <= date_trunc('week', CURRENT_DATE)::date + '6 days'::interval + '24 hours'::interval