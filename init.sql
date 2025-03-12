-- DROP DATABASE IF EXISTS media_monitoring;

-- CREATE DATABASE media_monitoring;

CREATE TABLE IF NOT EXISTS news
(
    id    SERIAL PRIMARY KEY,
    date  TIMESTAMP    NOT NULL,
    url   VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL
);