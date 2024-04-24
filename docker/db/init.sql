CREATE TABLE IF NOT EXISTS users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(64),
    last_name VARCHAR(64),
    email VARCHAR(64)
);