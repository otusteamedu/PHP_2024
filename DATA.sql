INSERT INTO movies("name")
SELECT
    random_string((1 + random() * 30)::integer)
FROM generate_series(1, 10000000) as gs(id);