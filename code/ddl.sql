CREATE TABLE "customers"
(
    "id"    bigserial    NOT NULL primary key,
    "name"  varchar(255) NOT NULL,
    "phone" varchar(255) NOT NULL
);
-- DROP TABLE "genres";


CREATE TABLE "genres"
(
    "id"   serial       NOT NULL primary key,
    "name" varchar(255) NOT NULL
);
-- DROP TABLE "halls";


CREATE TABLE "halls"
(
    "id"    serial       NOT NULL primary key,
    "name"  varchar(255) NOT NULL,
    "seats" int          NOT NULL
);
-- DROP TABLE "movies";


CREATE TABLE "movies"
(
    "id"       bigserial     NOT NULL primary key,
    "title"    varchar(255)  NOT NULL,
    "duration" int           NOT NULL,
    "genre_id" bigint        NOT NULL REFERENCES "genres" ("id"),
    "rating"   decimal(2, 1) NOT NULL
);

CREATE INDEX idx_movies_genre_id on movies ("genre_id");
-- DROP TABLE "seats";


CREATE TABLE "seats"
(
    "id"          serial NOT NULL primary key,
    "hall_id"     serial NOT NULL REFERENCES "halls" ("id"),
    "seat_number" int    NOT NULL,
    "row_number"  int    NOT NULL
);

CREATE INDEX idx_seats_hall_id on seats ("hall_id");
-- DROP TABLE "sessions";

CREATE TABLE "sessions"
(
    "id"         bigserial NOT NULL primary key,
    "movie_id"   bigserial NOT NULL REFERENCES "movies" ("id"),
    "hall_id"    bigserial NOT NULL REFERENCES "halls" ("id"),
    "start_time" timestamp NOT NULL,
    "end_time"   timestamp NOT NULL
);

CREATE INDEX idx_sessions_movie_id on sessions ("movie_id");
CREATE INDEX idx_sessions_hall_id on sessions ("hall_id");
-- DROP TABLE "tickets";

CREATE TABLE "ticket_prices"
(
    "id"         bigserial     NOT NULL primary key,
    "session_id" bigserial     NOT NULL REFERENCES "sessions" ("id"),
    "seat_id"    bigserial     NOT NULL REFERENCES "seats" ("id"),
    "price"      decimal(5, 2) NOT NULL
);

CREATE INDEX idx_ticket_prices_session_id on ticket_prices ("session_id");
CREATE INDEX idx_ticket_prices_seat_id on ticket_prices ("seat_id");

CREATE TABLE "tickets"
(
    "id"              bigserial     NOT NULL primary key,
    "ticket_price_id" bigserial     NOT NULL REFERENCES "ticket_prices" ("id"),
    "customer_id"     bigserial     NOT NULL REFERENCES "customers" ("id"),
    "price"           decimal(5, 2) NOT NULL,
    "purchased_at"    timestamp     NOT NULL
);

CREATE INDEX idx_tickets_customer_id on tickets ("customer_id");
CREATE INDEX idx_tickets_ticket_price_id on tickets ("ticket_price_id");
