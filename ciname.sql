CREATE TABLE "movie" (
                         "id" integer PRIMARY KEY,
                         "name" varchar(255) NOT NULL,
                         "genre" integer,
                         "description" varchar(1000),
                         "director" varchar(255),
                         "producer" varchar,
                         "starring" varchar,
                         "running_time" integer
);

CREATE TABLE "movie_genre" (
                               "id" integer PRIMARY KEY,
                               "movie_id" integer,
                               "genre_id" integer
);

CREATE TABLE "genre" (
                         "id" integer PRIMARY KEY,
                         "name" varchar(255)
);

CREATE TABLE "halls" (
                         "id" integer PRIMARY KEY,
                         "name" varchar(255) NOT NULL
);

CREATE TABLE "row" (
                       "id" integer PRIMARY KEY,
                       "hall_id" integer NOT NULL
);

CREATE TABLE "seat" (
                        "id" integer PRIMARY KEY,
                        "row_id" integer NOT NULL,
                        "ticket_type" integer NOT NULL DEFAULT 0
);

CREATE TABLE "session" (
                           "id" integer PRIMARY KEY,
                           "hall_id" integer NOT NULL,
                           "movie_id" integer NOT NULL,
                           "time_start" datetime,
                           "time_end" datetime,
                           "price_id" ineger NOT NULL
);

CREATE TABLE "user" (
                        "id" integer PRIMARY KEY,
                        "name" varchar(255) NOT NULL,
                        "last_name" varchar(255) NOT NULL,
                        "middle_name" varchar(255),
                        "hashed_password" varchar(255) NOT NULL,
                        "email" varchar(255) NOT NULL,
                        "phone" varchar(100)
);

CREATE TABLE "ticket_type" (
                               "id" integer PRIMARY KEY,
                               "type" integer NOT NULL,
                               "discount" integer NOT NULL
);

CREATE TABLE "order" (
                         "id" integer PRIMARY KEY,
                         "user_id" integer NOT NULL,
                         "session_id" integer NOT NULL,
                         "seat_id" integer NOT NULL
);

CREATE TABLE "session_prices" (
                                  "id" integer PRIMARY KEY,
                                  "price" float
);

ALTER TABLE "ticket_type" ADD FOREIGN KEY ("id") REFERENCES "seat" ("ticket_type");

ALTER TABLE "session" ADD FOREIGN KEY ("hall_id") REFERENCES "halls" ("id");

ALTER TABLE "session" ADD FOREIGN KEY ("movie_id") REFERENCES "movie" ("id");

ALTER TABLE "order" ADD FOREIGN KEY ("user_id") REFERENCES "user" ("id");

ALTER TABLE "seat" ADD FOREIGN KEY ("row_id") REFERENCES "row" ("hall_id");

ALTER TABLE "row" ADD FOREIGN KEY ("hall_id") REFERENCES "halls" ("id");

ALTER TABLE "order" ADD FOREIGN KEY ("seat_id") REFERENCES "seat" ("id");

ALTER TABLE "session" ADD FOREIGN KEY ("price_id") REFERENCES "session_prices" ("id");

ALTER TABLE "movie_genre" ADD FOREIGN KEY ("id") REFERENCES "movie" ("genre");

ALTER TABLE "movie_genre" ADD FOREIGN KEY ("id") REFERENCES "genre" ("id");
