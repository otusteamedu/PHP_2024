DROP TABLE IF EXISTS "films" CASCADE;
CREATE TABLE "films"(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NULL,
    release_date date NOT NULL,
    rating float DEFAULT 0,
    duration INT NOT NULL,
    description TEXT NULL
);
