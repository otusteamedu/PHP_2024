/**
  Функциональный индекс на sessions.start_date, так как у него большая селективность и как видим что очень
     много данных было отфилтрованно.
 */
CREATE INDEX idx_sessions_start_time_date ON sessions (DATE(start_time));
