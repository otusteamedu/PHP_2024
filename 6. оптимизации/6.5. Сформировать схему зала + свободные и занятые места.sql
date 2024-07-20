/**
  Индексы на join, можно составной индекс создать тут.
 */
CREATE INDEX idx_sessions_hall_id ON sessions (hall_id);
CREATE INDEX idx_seats_hall_id ON seats (hall_id);
CREATE INDEX idx_tickets_session_seat ON tickets (session_id, seat_id);
