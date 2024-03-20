CREATE TABLE movies
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE INDEX movies_name_index
    ON movies (name);

CREATE TABLE attribute_types
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE INDEX attributes_types_name_index
    ON attribute_types (name);

CREATE TABLE attributes
(
    id                SERIAL PRIMARY KEY,
    name              VARCHAR(255) NOT NULL UNIQUE,
    attribute_type_id BIGINT REFERENCES attribute_types (id) ON DELETE SET NULL
);

CREATE INDEX attributes_name_index
    ON attributes (name);

CREATE TABLE values
(
    id           SERIAL PRIMARY KEY,
    movie_id     BIGINT REFERENCES movies (id) ON DELETE CASCADE,
    attribute_id BIGINT REFERENCES attributes (id) ON DELETE CASCADE,
    date_val     DATE,
    text_val     TEXT,
    int_val      INT,
    float_val    FLOAT,
    bool_val     BOOL,
    json_val     JSONB
);

CREATE INDEX values_string_index
    ON values (bool_val);

CREATE INDEX values_date_index
    ON values (date_val);

CREATE INDEX values_text_index
    ON values (text_val);

CREATE INDEX values_int_index
    ON values (int_val);

CREATE INDEX values_float_index
    ON values (float_val);

INSERT INTO movies (name)
VALUES ('best movies 1'),
       ('best movies 2'),
       ('best movies 3'),
       ('best movies 4');

INSERT INTO attribute_types (name)
VALUES ('date'),
       ('text'),
       ('int'),
       ('float'),
       ('bool'),
       ('json');

INSERT INTO attributes (name, attribute_type_id)
VALUES ('in_the_box_office', 5),
       ('start_date', 1),
       ('description', 2),
       ('age_limit', 3);

INSERT INTO values (movie_id, attribute_id, date_val, text_val, int_val, float_val, bool_val)
VALUES (1, 1, null, null, null, null, true),
       (1, 2, '2024-03-21', null, null, null, null),
       (1, 3, null, 'very long description', null, null, null),
       (2, 1, null, null, null, null, true),
       (2, 2, '2024-04-11', null, null, null, null),
       (2, 3, null, 'short description', null, null, null),
       (3, 4, null, null, 18, null, null),
       (3, 2, '2024-03-29', null, null, null, null),
       (4, 3, null, 'cute description', null, null, null);

CREATE VIEW actual_jobs(movie, today, next_20_days) AS
SELECT m.name,
        CASE WHEN v.date_val = CURRENT_DATE THEN v.date_val END as today,
        CASE WHEN v.date_val > CURRENT_DATE AND v.date_val <= (CURRENT_DATE + '20 days'::interval)::DATE
        THEN v.date_val END as next_20_days
FROM movies as m
        LEFT JOIN values as v ON v.movie_id = m.id
        LEFT JOIN attributes as a ON a.id = v.attribute_id
WHERE v.date_val IS NOT NULL;

CREATE VIEW marketing_view(movie, attribute_type, attribute, value) AS
SELECT m.name,
        at.name,
        a.name,
        CASE
           WHEN v.date_val IS NOT NULL THEN v.date_val::TEXT
           WHEN v.text_val IS NOT NULL THEN v.text_val::TEXT
           WHEN v.int_val IS NOT NULL THEN v.int_val::TEXT
           WHEN v.bool_val IS NOT NULL THEN v.bool_val::TEXT
           END as value
FROM movies as m
        LEFT JOIN values as v ON v.movie_id = m.id
        LEFT JOIN attributes as a ON a.id = v.attribute_id
        LEFT JOIN attribute_types as at ON at.id = a.attribute_type_id;

SELECT * FROM actual_jobs;
SELECT * FROM marketing_view;