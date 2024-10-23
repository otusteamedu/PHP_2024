/* UP */
CREATE DATABASE chat_bot ENCODING = 'UTF8';

CREATE TABLE product (
    id VARCHAR(50) PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    sku VARCHAR(50) UNIQUE NOT NULL,
    category VARCHAR(50) NOT NULL,
    price NUMERIC(9,2) NOT NULL,
    volume NUMERIC(9,2) NOT NULL
);

CREATE INDEX product_category_idx ON product (category);

/* DOWN */
-- DROP DATABASE chat_bot
-- DROP TABLE  product
