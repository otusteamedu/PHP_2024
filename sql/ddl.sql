CREATE TABLE "movie" (
                         "id" SERIAL PRIMARY KEY,
                         "name" varchar(255) NOT NULL,
                         "description" varchar(1000),
                         "director" varchar(255),
                         "producer" varchar,
                         "starring" varchar,
                         "running_time" integer
);


CREATE TABLE "genre" (
                         "id" SERIAL PRIMARY KEY,
                         "name" varchar(255)
);

CREATE TABLE "movie_genre" (
                               "id" SERIAL PRIMARY KEY,
                               "movie_id" integer REFERENCES "movie" ("id"),
                               "genre_id" integer REFERENCES "genre" ("id")
);


CREATE TABLE "halls" (
                         "id" SERIAL PRIMARY KEY,
                         "name" varchar(255) NOT NULL
);

CREATE TABLE "row" (
                       "id" SERIAL PRIMARY KEY,
                       "hall_id" integer NOT NULL REFERENCES "halls"("id")
);

CREATE TABLE "ticket_type" (
                               "id" SERIAL PRIMARY KEY,
                               "type" varchar(255) NOT NULL,
                               "discount" integer NOT NULL
);

CREATE TABLE "seat" (
                        "id" SERIAL PRIMARY KEY,
                        "row_id" integer NOT NULL REFERENCES "row"("id"),
                        "ticket_type" integer NOT NULL REFERENCES ticket_type("id")
);

CREATE TABLE "session_prices" (
                                  "id" SERIAL PRIMARY KEY,
                                  "price" float
);

CREATE TABLE "sessions" (
                           "id" SERIAL PRIMARY KEY,
                           "hall_id" integer NOT NULL REFERENCES "halls"("id"),
                           "movie_id" integer NOT NULL REFERENCES "movie"("id"),
                           "time_start" date,
                           "time_end" date,
                           "price_id" integer NOT NULL REFERENCES "session_prices"("id")
);

CREATE TABLE "user" (
                        "id" SERIAL PRIMARY KEY,
                        "name" varchar(255) NOT NULL,
                        "last_name" varchar(255) NOT NULL,
                        "middle_name" varchar(255),
                        "email" varchar(255) NOT NULL,
                        "phone" varchar(100)
);

CREATE TABLE "order" (
                         "id" SERIAL PRIMARY KEY,
                         "user_id" integer NOT NULL references "user" ("id"),
                         "session_id" integer NOT NULL REFERENCES "sessions"("id"),
                         "seat_id" integer NOT NULL REFERENCES "seat"("id")
);

