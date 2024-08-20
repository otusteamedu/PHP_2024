CREATE TABLE authors (
                         id SERIAL PRIMARY KEY,
                         name varchar(255) NOT NULL,
                         last_name VARCHAR(255) NOT NULL,
                         patronymic VARCHAR(255),
                         date_of_birth DATE NOT NULL,
                         date_of_death DATE,
                         country varchar(255),
                         gender CHAR(1)
);

CREATE TABLE books (
                       id SERIAL PRIMARY KEY,
                       name varchar(255) NOT NULL,
                       author_id INTEGER REFERENCES authors(id) ON DELETE CASCADE,
                       date_of_issue DATE,
                       rating FLOAT,
                       number_of_copies integer
);

CREATE INDEX idx_authors_last_name ON authors(last_name);
CREATE INDEX idx_books_rating ON books(rating);