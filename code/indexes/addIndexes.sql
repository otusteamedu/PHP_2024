create index idx_tickets_purchased_at on tickets (purchased_at);

create index concurrently idx_ticket_prices_id on ticket_prices(id);

create index idx_sessions_start_time on sessions ((start_time::date));

create index idx_sessions_end_time on sessions ((end_time::date));

create index idx_tickets_ticket_price_id_price_purchased_at on tickets (ticket_price_id, price, purchased_at);

create index idx_seats_row_number_seat_number on seats (row_number, seat_number);
