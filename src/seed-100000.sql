-- Cleanup
TRUNCATE movies RESTART IDENTITY CASCADE;
TRUNCATE sessions RESTART IDENTITY CASCADE;
TRUNCATE sales RESTART IDENTITY CASCADE;

-- Fill "movies" table
SELECT generate_movies(100000);

-- Fill "sessions" table
SELECT generate_sessions(100000);

-- Fill "sales" table
SELECT generate_sales(100000);
