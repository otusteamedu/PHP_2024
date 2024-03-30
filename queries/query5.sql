-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

select s.id, s.row_number as row, s.seat_number as number,
    case
        when t.session_id is null then false
        else true
    end as is_sold
from public.seat s
left join public.ticket t on s.id = t.seat_id and t.session_id = 1 and t.date = current_date
order by s.id;