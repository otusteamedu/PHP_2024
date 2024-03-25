-- movie.country_id
CREATE INDEX IF NOT EXISTS idx_movie_country_id ON movie (country_id);

-- Стоимость фильмов
CREATE INDEX IF NOT EXISTS fk_movie_price_movie_movie_id ON movie_price (movie_id);
CREATE INDEX IF NOT EXISTS idx_movie_price_type ON movie_price (type);

-- Сидения
CREATE INDEX IF NOT EXISTS fk_seat_hall_hall_id ON seat (hall_id);
CREATE INDEX IF NOT EXISTS idx_seat_type ON seat (type);

-- Сеансы
CREATE INDEX IF NOT EXISTS fk_session_hall_hall_id ON session (hall_id);
CREATE INDEX IF NOT EXISTS fk_session_movie_movie_id ON session (movie_id);
CREATE INDEX IF NOT EXISTS idx_session_scheduled_at_date ON session ((scheduled_at::date));

-- Билеты
CREATE INDEX IF NOT EXISTS fk_session_seat_seat_id ON ticket (seat_id);
CREATE INDEX IF NOT EXISTS fk_ticket_session_session_id ON ticket (session_id);

-- Продажи билетов
-- Небольшая денормализация для запроса 4.
ALTER TABLE ticket_sale ADD COLUMN session_id INT NOT NULL;
CREATE INDEX IF NOT EXISTS fk_ticket_ticket_sale_ticket_id ON ticket_sale (ticket_id);
CREATE INDEX IF NOT EXISTS idx_ticket_sale_created_at_week_interval ON ticket_sale USING btree (created_at);
CREATE INDEX IF NOT EXISTS idx_ticket_session_id ON ticket_sale USING btree (session_id);

