CREATE INDEX idx_sessions_date ON sessions (session_date);
CREATE INDEX idx_sessions_film_id ON sessions (film_id);
CREATE INDEX idx_tickets_session_id ON tickets (session_id);
CREATE INDEX idx_tickets_price ON tickets (price); 