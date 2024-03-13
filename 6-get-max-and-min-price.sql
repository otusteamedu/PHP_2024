select MAX(screening_prices.price), MIN(screening_prices.price)
from screenings
         inner join  hall_lines on screenings.hall_id = hall_lines.hall_id
         inner join hall_seats on hall_seats.line_id = hall_lines.id
         inner join seat_types on seat_types.id = hall_seats.type_id
         inner join screening_prices on screening_prices.screening_id = screenings.id and screening_prices.seat_type_id = seat_types.id
where screenings.id = 1