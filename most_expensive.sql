select
	sessions.movie_id,
	SUM(sessions.base_price * seat_types.price_multiplier) as total_price
from
	sessions
inner join reservations on
	reservations.session_id = sessions.id
inner join hall_seats on
	reservations.hall_seat_id = hall_seats.id
inner join seat_types on
	hall_seats.seat_type_id = seat_types.id
where 
	reservations.is_reserved = 1
group by
	sessions.movie_id
order by
	total_price desc
limit 1