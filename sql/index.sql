create index idx_cinema_id on hall(cinema_id);
create index idx_director_id on movies(director_id);
create index idx_movie_id on sessions(movie_id);
create index idx_hall_id on sessions(hall_id);
create index idx_session_id on tickets(session_id);
create index idx_seat_id on tickets(seat_id);
create index idx_buyer_id on orders(buyer_id);
create index idx_ticket_id on orders(ticket_id);
create index idx_movie_actor_id on movies_actors(movie_id);
create index idx_actor_id on movies_actors(actor_id);

create index idx_sessions_start_time on sessions(start_time);
create index idx_tickets_purchase_time on tickets(purchase_time);

create index idx_ticket_price on tickets(price);

create index idx_movies_name on movies(name);
create index idx_sessions_movie_id on sessions(movie_id);
create index idx_sessions_hall_id on sessions(hall_id);
create index idx_seats_hall_id on seats(hall_id);
create index idx_orders_ticket_id on orders(ticket_id);

create index idx_tickets_session_id on tickets(session_id);

create unique index idx_buyer_fullname on buyer(fullname);
create unique index idx_buyer_phone on buyer(phone);
