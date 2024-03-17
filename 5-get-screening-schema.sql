select hall_lines.name as line_name,
       hall_seats.name as seat_name,
       seat_types.name,
       seat_types.color,
       screening_prices.price,
       case
           when orders.id is not null
               then false
           else true
           end as is_available
from screenings
         inner join  hall_lines on screenings.hall_id = hall_lines.hall_id
         inner join hall_seats on hall_seats.line_id = hall_lines.id
         inner join seat_types on seat_types.id = hall_seats.type_id
         inner join screening_prices on screening_prices.screening_id = screenings.id and screening_prices.seat_type_id = seat_types.id
         left join orders on orders.seat_id = hall_seats.id and orders.screening_date >= current_date::date
where screenings.id = 1