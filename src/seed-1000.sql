-- Cleanup
TRUNCATE movies RESTART IDENTITY CASCADE;
TRUNCATE sessions RESTART IDENTITY CASCADE;
TRUNCATE sales RESTART IDENTITY CASCADE;

-- Fill "movies" table
SELECT generate_movies(1000);

-- Fill "sessions" table
SELECT generate_sessions(1000);

-- Fill "sales" table
SELECT generate_sales(1000);
