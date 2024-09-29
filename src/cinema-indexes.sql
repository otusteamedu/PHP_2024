-- Cleanup
DROP INDEX IF EXISTS idx_hall_seats_hall_id;
DROP INDEX IF EXISTS idx_sales_session_id;
DROP INDEX IF EXISTS idx_sales_seat_id;
DROP INDEX IF EXISTS idx_sessions_movie_id;
DROP INDEX IF EXISTS idx_sessions_hall_id;
DROP INDEX IF EXISTS idx_sessions_date_start;
DROP INDEX IF EXISTS idx_sales_date;
DROP INDEX IF EXISTS idx_hall_seats_price;
DROP INDEX IF EXISTS idx_movies_title;

-- Create indexes for foreign keys
CREATE INDEX idx_hall_seats_hall_id ON hall_seats(hall_id);
CREATE INDEX idx_sales_session_id ON sales(session_id);
CREATE INDEX idx_sales_seat_id ON sales(seat_id);
CREATE INDEX idx_sessions_movie_id ON sessions(movie_id);
CREATE INDEX idx_sessions_hall_id ON sessions(hall_id);

-- Create "idx_sessions_date_start" index
CREATE INDEX idx_sessions_date_start ON sessions(date_start);

-- Create "idx_sales_date" index
CREATE INDEX idx_sales_date ON sales(date);

-- Create "idx_hall_seats_price" index
CREATE INDEX idx_hall_seats_price ON hall_seats(price);

-- Create "idx_movies_title" index
CREATE INDEX idx_movies_title ON movies(title);
