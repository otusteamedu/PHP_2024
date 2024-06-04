CREATE TABLE IF NOT EXISTS products (
    id          SERIAL UNIQUE PRIMARY KEY,
    type        varchar(32) NOT NULL,
    recipe      text NOT NULL,
    status      int NOT NULL
);

CREATE TABLE IF NOT EXISTS ingredients (
    name        varchar(255) NOT NULL
);