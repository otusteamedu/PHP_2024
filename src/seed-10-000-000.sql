-- Cleanup
TRUNCATE sessions RESTART IDENTITY CASCADE;
TRUNCATE sales RESTART IDENTITY CASCADE;

-- Fill "sessions" table
SELECT generate_sessions(10000000);

-- Fill "sales" table
SELECT generate_sales(10000000);
