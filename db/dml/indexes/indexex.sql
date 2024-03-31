-- Использовался для query1
CREATE INDEX movies_sessions_movie_id on movies_sessions (movie_id);

-- Использовался для query2 и query3
CREATE INDEX tickets_sessions on tickets (session_id);

-- Использовался для query4 и query6
CREATE INDEX tickets_sessions_price on tickets (session_id, price);

-- Использовался для query5
CREATE INDEX ticket_seat_session_id on tickets (seat_id, session_id);
