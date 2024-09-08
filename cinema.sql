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
    "tariff_id" bigint                   NOT NULL,
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
    "id"          serial   NOT NULL UNIQUE,
    "seat_id"     bigint   NOT NULL,
    "session_id"  bigint   NOT NULL,
    "final_price" smallint NOT NULL,
    "sold_at"     timestamp with time zone,
    PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "tariffs"
(
    "id"    serial   NOT NULL UNIQUE,
    "price" smallint NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "discounts"
(
    "id"              serial                   NOT NULL UNIQUE,
    "name"            varchar(255)             NOT NULL,
    "description"     varchar(255)             NOT NULL,
    "unit"            smallint                 NOT NULL,
    "value"           smallint                 NOT NULL,
    "available_from"  timestamp with time zone NOT NULL,
    "available_until" timestamp with time zone NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "discount_ticket"
(
    "id"          serial NOT NULL UNIQUE,
    "discount_id" bigint NOT NULL,
    "ticket_id"   bigint NOT NULL,
    PRIMARY KEY ("id")
);

ALTER TABLE "sessions"
    ADD CONSTRAINT "sessions_fk1" FOREIGN KEY ("film_id") REFERENCES "films" ("id");

ALTER TABLE "sessions"
    ADD CONSTRAINT "sessions_fk2" FOREIGN KEY ("hall_id") REFERENCES "halls" ("id");

ALTER TABLE "sessions"
    ADD CONSTRAINT "sessions_fk3" FOREIGN KEY ("tariff_id") REFERENCES "tariffs" ("id");

ALTER TABLE "seats"
    ADD CONSTRAINT "seats_fk1" FOREIGN KEY ("hall_id") REFERENCES "halls" ("id");
ALTER TABLE "tickets"
    ADD CONSTRAINT "tickets_fk1" FOREIGN KEY ("seat_id") REFERENCES "seats" ("id");

ALTER TABLE "tickets"
    ADD CONSTRAINT "tickets_fk2" FOREIGN KEY ("session_id") REFERENCES "sessions" ("id");

ALTER TABLE "discount_ticket"
    ADD CONSTRAINT "discount_ticket_fk1" FOREIGN KEY ("discount_id") REFERENCES "discounts" ("id");

ALTER TABLE "discount_ticket"
    ADD CONSTRAINT "discount_ticket_fk2" FOREIGN KEY ("ticket_id") REFERENCES "tickets" ("id");