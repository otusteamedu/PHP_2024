DROP TABLE IF EXISTS "countries" CASCADE;
CREATE TABLE "countries"(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS "genres" CASCADE;
CREATE TABLE "genres"(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS "years" CASCADE;
CREATE TABLE "years"(
    id SERIAL PRIMARY KEY,
    name INT NOT NULL
);

DROP TABLE IF EXISTS "age_limits" CASCADE;
CREATE TABLE "age_limits"(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS "halls" CASCADE;
CREATE TABLE "halls"(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    capacity INT NOT NULL
);

DROP TABLE IF EXISTS "films" CASCADE;
CREATE TABLE "films"(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    duration INT NOT NULL,
    age_limit INT NOT NULL,
    description TEXT NULL,
    year_id INT NOT NULL,
    FOREIGN KEY ("age_limit") REFERENCES "age_limits"("id"),
    FOREIGN KEY ("year_id") REFERENCES "years"("id")
);

DROP TABLE IF EXISTS "films_genres" CASCADE;
CREATE TABLE "films_genres"(
    id SERIAL PRIMARY KEY,
    film_id BIGINT NOT NULL,
    genre_id INT NOT NULL,
    FOREIGN KEY ("genre_id") REFERENCES "genres"("id")
);

DROP TABLE IF EXISTS "films_countries" CASCADE;
CREATE TABLE "films_countries"(
    id SERIAL PRIMARY KEY,
    film_id BIGINT NOT NULL,
    country_id INT NOT NULL,
    FOREIGN KEY ("film_id") REFERENCES "films"("id"),
    FOREIGN KEY ("country_id") REFERENCES "countries"("id")
);

DROP TABLE IF EXISTS "cinema_shows" CASCADE;
CREATE TABLE "cinema_shows"(
    id SERIAL PRIMARY KEY,
    hall_id BIGINT NOT NULL,
    film_id BIGINT NOT NULL,
    "date" DATE NOT NULL,
    "start" TIME NOT NULL,
    "end" TIME NOT NULL,
    FOREIGN KEY ("hall_id") REFERENCES "halls"("id"),
    FOREIGN KEY ("film_id") REFERENCES "films"("id")
);

DROP TABLE IF EXISTS "seats_type" CASCADE;
CREATE TABLE "seats_type"(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS "seats" CASCADE;
CREATE TABLE "seats"(
    id SERIAL PRIMARY KEY,
    hall_id BIGINT NOT NULL,
    row INT NOT NULL,
    place INT NOT NULL,
    seat_type INT NOT NULL,
    FOREIGN KEY ("hall_id") REFERENCES "halls"("id"),
    FOREIGN KEY ("seat_type") REFERENCES "seats_type"("id")
);

DROP TABLE IF EXISTS "cinema_show_seat" CASCADE;
CREATE TABLE "cinema_show_seat"(
    id SERIAL PRIMARY KEY,
    seat_id BIGINT NOT NULL,
    price DECIMAL(8, 2) NOT NULL,
    cinema_show_id BIGINT NOT NULL,
    FOREIGN KEY ("seat_id") REFERENCES "seats"("id"),
    FOREIGN KEY ("cinema_show_id") REFERENCES "cinema_shows"("id")
);

DROP TABLE IF EXISTS "users" CASCADE;
CREATE TABLE "users"(
    id SERIAL PRIMARY KEY,
    login VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS "orders" CASCADE;
CREATE TABLE "orders"(
    id SERIAL PRIMARY KEY,
    date_created TIMESTAMP NOT NULL,
    user_id BIGINT NOT NULL,
    FOREIGN KEY ("user_id") REFERENCES "users"("id")
);

DROP TABLE IF EXISTS "tickets" CASCADE;
CREATE TABLE "tickets"(
    id SERIAL PRIMARY KEY,
    cinema_show_seat_id BIGINT NOT NULL,
    order_id BIGINT NOT NULL,
    price DECIMAL(8, 2) NOT NULL,
    discount DECIMAL(8, 2) NOT NULL DEFAULT '0',
    FOREIGN KEY ("cinema_show_seat_id") REFERENCES "cinema_show_seat"("id"),
    FOREIGN KEY ("order_id") REFERENCES "orders"("id")
);
