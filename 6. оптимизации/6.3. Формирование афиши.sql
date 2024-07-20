/**
  Индекс уже есть для sessions.start_time из 6.1.
  Так же, вероятно лучше не использовать date() там где это не совсем уместно.
 */
CREATE INDEX idx_sessions_start_time_date ON sessions (DATE(start_time));
