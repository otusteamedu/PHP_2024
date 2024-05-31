DROP TABLE IF EXISTS "film" CASCADE;
DROP TABLE IF EXISTS "attribute_type" CASCADE;
DROP TABLE IF EXISTS "attribute" CASCADE;
DROP TABLE IF EXISTS "attribute_value" CASCADE;

CREATE TABLE IF NOT EXISTS "film" (
    "id" SERIAL PRIMARY KEY,
    "title" VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS "attribute_type" (
    "id" SERIAL PRIMARY KEY,
    "type" VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS "attribute" (
    "id" SERIAL PRIMARY KEY,
    "name" VARCHAR(255) NOT NULL,
    "attribute_type_id" INT NOT NULL,
    FOREIGN KEY ("attribute_type_id") REFERENCES "attribute_type"("id")
);

CREATE TABLE IF NOT EXISTS "attribute_value" (
    "id" SERIAL PRIMARY KEY,
    "film_id" INT NOT NULL,
    "attribute_id" INT NOT NULL,
    "value_text" TEXT DEFAULT NULL,
    "value_boolean" BOOLEAN DEFAULT NULL,
    "value_date" DATE DEFAULT NULL,
    "value_int" INT DEFAULT NULL,
    "value_decimal" decimal(10, 2) DEFAULT NULL,
    FOREIGN KEY ("film_id") REFERENCES "film"("id"),
    FOREIGN KEY ("attribute_id") REFERENCES "attribute"("id")
);

INSERT INTO "attribute_type" ("type") VALUES
('Text'),
('Boolean'),
('Date'),
('Integer'),
('Decimal')
;

-- Insert sample data into attribute table
INSERT INTO "attribute" ("name", "attribute_type_id") VALUES
('Critic Review', 1),
('Unknown Academy Review', 1),
('Oscar', 2),
('Nika', 2),
('World Premiere', 3),
('Premiere in Russia', 3),
('Ticket Sales Start Date', 3),
('TV Ad Start Date', 3),
('Budget', 4),
('Box Office', 4),
('IMDb Rating', 5),
('Rotten Tomatoes Rating', 5),
('Average price of ticket', 5)
;

-- Insert sample data into film table
INSERT INTO "film" ("title") VALUES
('Avengers: Endgame'),
('Inception'),
('The Lion King'),
('Titanic'),
('Jurassic Park');

-- Insert sample data into attribute_value table
-- For Avengers: Endgame
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(1, 1, 'Excellent storyline with stunning visual effects.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(1, 2, 'Highly praised by unknown academy.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(1, 3, true);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(1, 4, false);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(1, 5, '2019-04-26');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(1, 6, '2019-04-25');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(1, 7, '2019-03-01');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(1, 8, '2019-02-01');

-- For Inception
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(2, 1, 'Mind-bending thriller with complex narrative.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(2, 2, 'A fascinating masterpiece.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(2, 3, true);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(2, 4, false);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(2, 5, '2010-07-16');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(2, 6, '2010-07-15');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(2, 7, '2010-06-01');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(2, 8, '2010-05-01');

-- For The Lion King
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(3, 1, 'Heartwarming tale with beautiful animation.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(3, 2, 'Beloved by audiences of all ages.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(3, 3, true);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(3, 4, true);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(3, 5, '1994-06-15');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(3, 6, '1994-06-24');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(3, 7, '1994-05-01');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(3, 8, '1994-04-01');

-- For Titanic
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(4, 1, 'Epic romance and disaster film.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(4, 2, 'A timeless classic.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(4, 3, true);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(4, 4, true);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(4, 5, '1997-12-19');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(4, 6, '1997-12-20');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(4, 7, '1997-11-01');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(4, 8, '1997-10-01');

-- For Jurassic Park
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(5, 1, 'Groundbreaking special effects and adventure.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_text") VALUES
(5, 2, 'A thrilling ride.');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(5, 3, false);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_boolean") VALUES
(5, 4, false);
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(5, 5, '1993-06-11');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(5, 6, '1993-06-12');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(5, 7, '1993-05-01');
INSERT INTO "attribute_value" ("film_id", "attribute_id", "value_date") VALUES
(5, 8, '1993-04-01');

CREATE VIEW current_tasks AS
    SELECT
        f.title AS film,
        a.name AS task,
        av.value_date AS due_date
    FROM
        film f
            JOIN attribute_value av ON f.id = av.film_id
            JOIN attribute a ON av.attribute_id = a.id
            JOIN attribute_type at ON a.attribute_type_id = at.id
    WHERE at.type = 'date' AND av.value_date = CURRENT_DATE
;

CREATE VIEW upcoming_tasks AS
    SELECT
        f.title AS film,
        a.name AS task,
        av.value_date AS due_date
    FROM film f
        JOIN attribute_value av ON f.id = av.film_id
        JOIN attribute a ON av.attribute_id = a.id
        JOIN attribute_type at ON a.attribute_type_id = at.id
    WHERE at.type = 'date' AND av.value_date = CURRENT_DATE + INTERVAL '20 days'
;

CREATE VIEW marketing_data AS
    SELECT
        f.title AS film,
        at.type AS attribute_type,
        a.name AS attribute,
        COALESCE(av.value_text::text, av.value_boolean::text, av.value_date::text) AS value
    FROM film f
        JOIN attribute_value av ON f.id = av.film_id
        JOIN attribute a ON av.attribute_id = a.id
        JOIN attribute_type at ON a.attribute_type_id = at.id
;
