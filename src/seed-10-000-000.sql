-- Cleanup
TRUNCATE sessions RESTART IDENTITY;
TRUNCATE sales RESTART IDENTITY;

-- Fill "sessions" table
SELECT generate_sessions(10000000);

-- Fill "sales" table
SELECT generate_sales(10000000);
