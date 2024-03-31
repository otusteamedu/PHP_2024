DROP TABLE IF EXISTS tbl_film CASCADE;
DROP TABLE IF EXISTS tbl_hall CASCADE;
DROP TABLE IF EXISTS tbl_place CASCADE;
DROP TABLE IF EXISTS tbl_show CASCADE;
DROP TABLE IF EXISTS tbl_price CASCADE;
DROP TABLE IF EXISTS tbl_ticket CASCADE;

CREATE TABLE tbl_film (
	"id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
	"title" varchar(255) NOT NULL,
	"description" text NOT NULL,
	"duration" INT NOT NULL,
	CONSTRAINT "tbl_film_pkey" PRIMARY KEY ("id")
);

CREATE TABLE tbl_hall (
	"id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
	"name" varchar(255) NOT NULL,
    "rows" INT not null,
	"cols" INT not null,
	CONSTRAINT "tbl_hall_pkey" PRIMARY KEY ("id")
);


CREATE TABLE tbl_place (
	"id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
	"hall_id" INT NOT NULL,
	"row" INT NOT NULL,
	"col" INT NOT NULL,
	"markup" INT NOT NULL DEFAULT 0,
	CONSTRAINT "tbl_place_pkey" PRIMARY KEY ("id"),
	CONSTRAINT "tbl_place_hall_id_fkey" FOREIGN KEY ("hall_id") REFERENCES tbl_hall("id")
);


CREATE TABLE tbl_show (
	"id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
	"film_id" INT NOT NULL,
	"hall_id" INT NOT NULL,
	"date" date NOT NULL,
	"time_start" timestamp NOT NULL,
	"time_end" timestamp NOT NULL,
    "base_price" money NOT NULL,
	CONSTRAINT "no_time_range_overlap" EXCLUDE USING gist (int4range("hall_id", "hall_id", '[]'::text) WITH =, tsrange("time_start", "time_end", '[]'::text) WITH &&),
	CONSTRAINT "tbl_show_pkey" PRIMARY KEY ("id"),
	CONSTRAINT "tbl_show_film_id_fkey" FOREIGN KEY ("film_id") REFERENCES tbl_film("id"),
	CONSTRAINT "tbl_show_hall_id_fkey" FOREIGN KEY ("hall_id") REFERENCES tbl_hall("id")
);

CREATE TABLE tbl_price (
    "id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
    "show_id" INT NOT NULL,
    "place_id" INT NOT NULL,
    "price" money NOT NULL,
    CONSTRAINT tbl_price_pkey PRIMARY KEY (id),
    CONSTRAINT tbl_price_place_id_fkey FOREIGN KEY (place_id) REFERENCES tbl_place(id),
    CONSTRAINT tbl_price_show_id_fkey FOREIGN KEY (show_id) REFERENCES tbl_show(id),
    CONSTRAINT tbl_price_unique UNIQUE (place_id,show_id)
);

CREATE TABLE tbl_ticket (
	"id" INT GENERATED ALWAYS AS IDENTITY NOT NULL,
	"show_id" INT NOT NULL,
	"place_id" INT NOT NULL,
	"price" money NOT NULL,
	"paid" bool NOT NULL DEFAULT false,
	CONSTRAINT tbl_ticket_pkey PRIMARY KEY (id),
    CONSTRAINT tbl_ticket_unique UNIQUE (place_id,show_id)
);
