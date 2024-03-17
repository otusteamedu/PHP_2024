select count(*)
from orders
where screening_date >= date_trunc('week', CURRENT_DATE)::date
and screening_date <= date_trunc('week', CURRENT_DATE)::date + '6 days'::interval + '24 hours'::interval