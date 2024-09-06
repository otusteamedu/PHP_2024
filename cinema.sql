CREATE TABLE IF NOT EXISTS "halls"
(
    "id" serial NOT NULL UNIQUE,
    PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "sessions"
(
    "id"        serial                   NOT NULL UNIQUE,
    "film_id"   bigint                   NOT NULL,
    "hall_id"   bigint                   NOT NULL,
    "starts_at" timestamp with time zone NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "films"
(
    "id"         serial       NOT NULL UNIQUE,
    "name"       varchar(255) NOT NULL,
    "annotation" varchar(255) NOT NULL,
    "duration"   bigint       NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "seats"
(
    "id"      serial   NOT NULL UNIQUE,
    "hall_id" bigint   NOT NULL,
    "row"     smallint NOT NULL,
    "place"   smallint NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "tickets"
(
    "id"         serial   NOT NULL UNIQUE,
    "seat_id"    bigint   NOT NULL,
    "session_id" bigint   NOT NULL,
    "price"      smallint NOT NULL,
    "sold_at"    timestamp with time zone,
    PRIMARY KEY ("id")
);

ALTER TABLE "sessions"
    ADD CONSTRAINT "sessions_fk1" FOREIGN KEY ("film_id") REFERENCES "films" ("id");

ALTER TABLE "sessions"
    ADD CONSTRAINT "sessions_fk2" FOREIGN KEY ("hall_id") REFERENCES "halls" ("id");

ALTER TABLE "seats"
    ADD CONSTRAINT "seats_fk1" FOREIGN KEY ("hall_id") REFERENCES "halls" ("id");

ALTER TABLE "tickets"
    ADD CONSTRAINT "tickets_fk1" FOREIGN KEY ("seat_id") REFERENCES "seats" ("id");

ALTER TABLE "tickets"
    ADD CONSTRAINT "tickets_fk2" FOREIGN KEY ("session_id") REFERENCES "sessions" ("id");