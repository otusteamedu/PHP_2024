/**
  Индекс уже существует на tickets.purchased_at. Желательно тоже не использовать date() если возможно.
 */
CREATE INDEX idx_tickets_purchased_at ON tickets (purchased_at);

/**
  Индексы на join
 */
CREATE INDEX idx_tickets_session_id ON tickets (session_id);
CREATE INDEX idx_tickets_seat_id ON tickets (seat_id);
CREATE INDEX idx_sessions_movie_id ON sessions (movie_id);
