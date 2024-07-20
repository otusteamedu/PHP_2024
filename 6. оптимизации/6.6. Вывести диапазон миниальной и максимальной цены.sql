/**
  Индексы на join
 */
CREATE INDEX idx_sessions_hall_id ON sessions (hall_id);
CREATE INDEX idx_halls_id ON halls (id);
CREATE INDEX idx_seats_hall_id ON seats (hall_id);
