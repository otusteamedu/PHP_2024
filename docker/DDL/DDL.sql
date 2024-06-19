CREATE TABLE IF NOT EXISTS products (
    id              SERIAL UNIQUE PRIMARY KEY,
    type            varchar(32) NOT NULL,
    recipe          text NOT NULL,
    comment         text DEFAULT NULL,
    status          int NOT NULL
);