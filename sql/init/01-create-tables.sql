-- Create the tables with PostgreSQL syntax
BEGIN;

--
-- Table structure for table attributes
--

CREATE TABLE attributes (
    attribute_id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    attribute_type_id INTEGER NOT NULL
);

--
-- Table structure for table attribute_types
--

CREATE TABLE attribute_types (
    attribute_type_id SERIAL PRIMARY KEY,
    type_name VARCHAR(50) NOT NULL
);

--
-- Table structure for table attribute_values
--

CREATE TABLE attribute_values (
    value_id SERIAL PRIMARY KEY,
    movie_id INTEGER NOT NULL,
    attribute_id INTEGER NOT NULL,
    value_text TEXT DEFAULT NULL,
    value_date DATE DEFAULT NULL,
    value_image VARCHAR(255) DEFAULT NULL,
    value_bool BOOLEAN DEFAULT NULL,
    value_int INTEGER DEFAULT NULL,
    value_float FLOAT DEFAULT NULL
);

--
-- Table structure for table cinema
--

CREATE TABLE cinema (
    cinema_id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL
);

--
-- Table structure for table customer
--

CREATE TABLE customer (
    customer_id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

--
-- Table structure for table film
--

CREATE TABLE film (
    film_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    duration INTEGER NOT NULL,
    genre VARCHAR(100) DEFAULT NULL,
    rating FLOAT DEFAULT NULL,
    release_date DATE DEFAULT NULL
);

--
-- Table structure for table hall
--

CREATE TABLE hall (
    hall_id SERIAL PRIMARY KEY,
    cinema_id INTEGER REFERENCES cinema(cinema_id) ON DELETE CASCADE,
    hall_number INTEGER NOT NULL,
    capacity INTEGER NOT NULL
);

--
-- Table structure for table session
--

CREATE TABLE session (
    session_id SERIAL PRIMARY KEY,
    hall_id INTEGER REFERENCES hall(hall_id) ON DELETE CASCADE,
    film_id INTEGER REFERENCES film(film_id) ON DELETE CASCADE,
    start_time TIMESTAMP NOT NULL
);

--
-- Table structure for table zone
--

CREATE TABLE zone (
    zone_id SERIAL PRIMARY KEY,
    hall_id INTEGER REFERENCES hall(hall_id) ON DELETE CASCADE,
    zone_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

--
-- Table structure for table ticket
--

CREATE TABLE ticket (
    ticket_id SERIAL PRIMARY KEY,
    session_id INTEGER REFERENCES session(session_id) ON DELETE CASCADE,
    zone_id INTEGER REFERENCES zone(zone_id) ON DELETE CASCADE,
    row INTEGER NOT NULL,
    seat_number VARCHAR(10) NOT NULL,
    customer_id INTEGER REFERENCES customer(customer_id) ON DELETE SET NULL,
    price DECIMAL(10,2) NOT NULL,
    purchase_time TIMESTAMP NOT NULL
);

-- Create foreign key constraints for remaining tables
ALTER TABLE attributes
    ADD CONSTRAINT fk_attribute_type FOREIGN KEY (attribute_type_id) REFERENCES attribute_types(attribute_type_id);

ALTER TABLE attribute_values
    ADD CONSTRAINT fk_av_movie FOREIGN KEY (movie_id) REFERENCES film(film_id),
    ADD CONSTRAINT fk_av_attribute FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id);

-- Create indexes
CREATE INDEX idx_av_movie ON attribute_values(movie_id);
CREATE INDEX idx_av_attribute ON attribute_values(attribute_id);

COMMIT;