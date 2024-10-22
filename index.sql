-- Индекс для улучшения выборки фильмов на сегодня:
CREATE INDEX idx_sessions_session_date ON sessions(session_date);

-- Индекс для ускорения подсчёта билетов:
CREATE INDEX idx_tickets_sold_at ON tickets(sold_at);

-- Индекс для поиска самых прибыльных фильмов:
CREATE INDEX idx_tickets_session_id ON tickets(session_id);
CREATE INDEX idx_sessions_film_id ON sessions(film_id);

-- Индекс для схемы зала:
CREATE INDEX idx_seats_session_id ON seats(session_id);