-- Cleanup
TRUNCATE movies RESTART IDENTITY CASCADE;
TRUNCATE sessions RESTART IDENTITY CASCADE;
TRUNCATE sales RESTART IDENTITY CASCADE;

-- Fill "movies" table
SELECT generate_movies(10000);

-- Fill "sessions" table
SELECT generate_sessions(10000);

-- Fill "sales" table
SELECT generate_sales(10000);
