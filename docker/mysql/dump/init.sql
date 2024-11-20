CREATE TABLE IF NOT EXISTS requests
(
    id         VARCHAR(36) PRIMARY KEY,
    status     VARCHAR(20) NOT NULL,
    data       JSON        NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
