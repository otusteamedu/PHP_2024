CREATE TABLE IF NOT EXISTS
  films (
    film_id SERIAL PRIMARY KEY,
    title varchar(255) NOT NULL,
    description text NOT NULL,
    rating decimal(2, 1) NOT NULL DEFAULT 0 CHECK (
      rating >= 0
      AND rating <= 10
    ),
    duration int NOT NULL,
    release_date date NOT NULL
  );

CREATE TABLE IF NOT EXISTS
  countries (
    country_id SERIAL PRIMARY KEY,
    country varchar(128) NOT NULL UNIQUE
  );

CREATE TABLE IF NOT EXISTS
  film_countries (
    film_id int REFERENCES films (film_id),
    country_id int REFERENCES countries (country_id),
    PRIMARY KEY (film_id, country_id)
  );

CREATE TABLE IF NOT EXISTS
  actors (
    actor_id SERIAL PRIMARY KEY,
    name varchar(128) NOT NULL
  );

CREATE TABLE IF NOT EXISTS
  film_actors (
    film_id int REFERENCES films (film_id),
    actor_id int REFERENCES actors (actor_id),
    PRIMARY KEY (film_id, actor_id)
  );

CREATE TABLE IF NOT EXISTS
  genres (
    genre_id SERIAL PRIMARY KEY,
    name varchar(128) UNIQUE NOT NULL
  );

CREATE TABLE IF NOT EXISTS
  film_genres (
    film_id int REFERENCES films (film_id),
    genre_id int REFERENCES genres (genre_id),
    PRIMARY KEY (film_id, genre_id)
  );

CREATE TABLE IF NOT EXISTS
  directors (
    director_id SERIAL PRIMARY KEY,
    name varchar(128) NOT NULL
  );

CREATE TABLE IF NOT EXISTS
  film_directors (
    film_id int REFERENCES films (film_id),
    director_id int REFERENCES directors (director_id),
    PRIMARY KEY (film_id, director_id)
  );

CREATE TABLE IF NOT EXISTS
  halls (
    hall_id SERIAL PRIMARY KEY,
    name varchar(128) UNIQUE NOT NULL
  );

CREATE TABLE IF NOT EXISTS
  seats (
    seat_id SERIAL PRIMARY KEY,
    hall_id int REFERENCES halls (hall_id),
    seat_row int NOT NULL,
    seat_number int NOT NULL,
    CONSTRAINT unique_seat_location UNIQUE (hall_id, seat_row, seat_number)
  );

CREATE TABLE IF NOT EXISTS
  sessions (
    session_id SERIAL PRIMARY KEY,
    film_id int REFERENCES films (film_id),
    hall_id int REFERENCES halls (hall_id),
    start_time timestamp NOT NULL,
    end_time timestamp NOT NULL,
    reccomended_price money NOT NULL,
    CONSTRAINT valid_time_range CHECK (start_time < end_time)
  );

CREATE TABLE IF NOT EXISTS
  visitors (
    visitor_id SERIAL PRIMARY KEY,
    visitor_name varchar(128) NOT NULL,
    e_mail varchar(128) NOT NULL UNIQUE
  );

CREATE TABLE IF NOT EXISTS
  tickets (
    ticket_id uuid DEFAULT gen_random_uuid () PRIMARY KEY,
    session_id int REFERENCES sessions (session_id),
    seat_id int REFERENCES seats (seat_id),
    purchased_at timestamp DEFAULT CURRENT_TIMESTAMP,
    selling_price money NOT NULL,
    visitor_id int REFERENCES visitors (visitor_id)
  );