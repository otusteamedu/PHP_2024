CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    release_date DATE NOT NULL,
    duration INTEGER
);
CREATE TABLE attribute_types (
    id SERIAL PRIMARY KEY,
    type VARCHAR(16)
);
CREATE TABLE movie_attributes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255),
    type_id INTEGER NOT NULL,
    FOREIGN KEY (type_id) REFERENCES attribute_types(id)
);
CREATE TABLE movie_values (
    id SERIAL PRIMARY KEY,
    movie_attribute_id INTEGER NOT NULL,
    movie_id INTEGER NOT NULL,
    value_text TEXT,
    value_boolean BOOLEAN,
    value_integer INTEGER,
    value_float FLOAT,
    value_date DATE,
    value_string VARCHAR(255),
    FOREIGN KEY (movie_attribute_id) REFERENCES movie_attributes(id),
    FOREIGN KEY (movie_id)REFERENCES movies(id)
);

CREATE TABLE timetable (
    id SERIAL PRIMARY KEY,
    movie_id INTEGER NOT NULL,
    showtime TIMESTAMP NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(id)
);

CREATE TABLE seats (
    ID SERIAL PRIMARY KEY,
    NUMBER INTEGER NOT NULL,
    ROW INTEGER NOT NULL
);

CREATE TABLE tickets (
    ID SERIAL PRIMARY KEY,
    timetable_id INTEGER NOT NULL,
    seat_id INTEGER NOT NULL,
    price NUMERIC(10, 2) NOT NULL,
    FOREIGN KEY (timetable_id) REFERENCES timetable(id),
    FOREIGN KEY (seat_id) REFERENCES seats(id)
);