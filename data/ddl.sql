DROP TABLE IF EXISTS movies;

CREATE TABLE IF NOT EXISTS movies
(
    id          SERIAL PRIMARY KEY,
    title       VARCHAR(50) NOT NULL,
    start_date  DATE,
    end_date    DATE,
    rental_cost FLOAT       NOT NULL
);