    DROP TABLE IF EXISTS tbl_film CASCADE;
    DROP TABLE IF EXISTS tbl_hall CASCADE;
    DROP TABLE IF EXISTS tbl_place CASCADE;
    DROP TABLE IF EXISTS tbl_show CASCADE;
    DROP TABLE IF EXISTS tbl_price CASCADE;
    DROP TABLE IF EXISTS tbl_ticket CASCADE;



    CREATE TABLE tbl_film (
        id serial4 NOT NULL,
        title varchar(255) NOT NULL,
        CONSTRAINT films_pkey PRIMARY KEY (id)
    );

    CREATE TABLE tbl_hall (
        "id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
        "name" VARCHAR(255) NOT NULL,
        "rows" INT NOT NULL,
        "cols" INT NOT NULL,
        PRIMARY KEY ("id")
    );

    CREATE TABLE tbl_place (
        "id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
        "hall_id" INT NOT NULL,
        "row" INT NOT NULL,
        "col" INT NOT NULL,
        PRIMARY KEY ("id")
    );

    CREATE TABLE tbl_show (
        "id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
        "film_id" INT NOT NULL,
        "hall_id" INT NOT NULL,
        "date" DATE NOT NULL,
        "time_start" TIMESTAMP NOT NULL,
        "time_end" TIMESTAMP NOT NULL,
        PRIMARY KEY ("id")
    );

    CREATE TABLE tbl_price (
        "id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
        "show_id" INT NOT NULL,
        "place_id" INT NOT NULL,
        "price" MONEY NOT NULL,
        PRIMARY KEY ("id")
    );

    CREATE TABLE tbl_ticket (
        id INT GENERATED ALWAYS AS IDENTITY NOT NULL,
        paid BOOLEAN NOT NULL DEFAULT FALSE,
        show_id INT NOT NULL,
        place_id INT NOT NULL,
        price_id INT NOT NULL,
        time_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        time_paid TIMESTAMP,
        PRIMARY KEY (id)
    );

    ALTER TABLE tbl_place
        ADD FOREIGN KEY ("hall_id") REFERENCES tbl_hall("id");

    ALTER TABLE tbl_show
        ADD FOREIGN KEY ("film_id") REFERENCES tbl_film("id"),
        ADD FOREIGN KEY ("hall_id") REFERENCES tbl_hall("id");

    ALTER TABLE tbl_price
        ADD FOREIGN KEY ("place_id") REFERENCES tbl_place("id"),
        ADD FOREIGN KEY ("show_id") REFERENCES tbl_show("id");

    ALTER TABLE tbl_ticket
        ADD FOREIGN KEY ("price_id") REFERENCES tbl_price("id"),
        ADD FOREIGN KEY ("place_id") REFERENCES tbl_place("id"),
        ADD FOREIGN KEY ("show_id") REFERENCES tbl_show("id");

