CREATE TABLE movies (
                          id integer PRIMARY KEY,
                          name varchar(255) NOT NULL
);

CREATE TABLE attributes (
                              id integer PRIMARY KEY,
                              name varchar(255) NOT NULL,
                              attribute_type integer NOT NULL
);

CREATE INDEX idx_attribute_type ON attributes (attribute_type);

CREATE TABLE attribute_types (
                                   id integer PRIMARY KEY,
                                   name varchar(255) NOT NULL
);

CREATE TABLE attribute_values (
                          id integer PRIMARY KEY,
                          movie_id integer NOT NULL,
                          attribute_id integer NOT NULL,
                          int_value integer DEFAULT NULL,
                          text_value text DEFAULT NULL,
                          bool_value bool DEFAULT NULL,
                          date_value date DEFAULT NULL,
                          float_value DECIMAL(40,20) DEFAULT NULL
);

CREATE INDEX idx_values_attribute  ON attribute_values (attribute_id);
CREATE INDEX idx_values_movie  ON attribute_values (movie_id);

ALTER TABLE attributes ADD FOREIGN KEY (attribute_type) REFERENCES attribute_types (id);

ALTER TABLE attribute_values ADD FOREIGN KEY (attribute_id) REFERENCES attributes (id);

ALTER TABLE attribute_values ADD FOREIGN KEY (movie_id) REFERENCES movies (id);
