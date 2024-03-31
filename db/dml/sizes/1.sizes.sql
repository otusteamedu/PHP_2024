SELECT nspname || '.' || relname as name,
          pg_size_pretty(pg_total_relation_size(c.oid)) as totalsize,
          pg_size_pretty(pg_relation_size(c.oid)) as relsize
FROM pg_class c
LEFT JOIN pg_namespace n ON (n.oid = c.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(c.oid) DESC
LIMIT 15;
