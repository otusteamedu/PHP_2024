CREATE TABLE IF NOT EXISTS news (
    id          SERIAL UNIQUE PRIMARY KEY,
    date        DATE NOT NULL,
    url         varchar(255) NOT NULL,
    title       varchar(255) NOT NULL
);