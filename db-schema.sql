CREATE TABLE halls (
                       id BIGSERIAL NOT NULL PRIMARY KEY,
                       name VARCHAR(100) NOT NULL,
                       UNIQUE (name)
);

CREATE TABLE seats (
                       id BIGSERIAL NOT NULL PRIMARY KEY,
                       hall_id BIGINT NOT NULL,
                       number VARCHAR(100) NOT NULL,
                       line VARCHAR(100) NOT NULL,
                       CONSTRAINT fk_hall FOREIGN KEY (hall_id) REFERENCES halls(id),
                       UNIQUE (hall_id, line, number)
);

CREATE TABLE films (
                       id BIGSERIAL NOT NULL PRIMARY KEY,
                       film VARCHAR(100) NOT NULL,
                       UNIQUE (film)
);

CREATE TABLE sessions (
                          id BIGSERIAL NOT NULL PRIMARY KEY,
                          hall_id BIGINT NOT NULL,
                          film_id BIGINT NOT NULL,
                          session_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          CONSTRAINT fk_hall FOREIGN KEY (hall_id) REFERENCES halls(id),
                          CONSTRAINT fk_film FOREIGN KEY (film_id) REFERENCES films(id),
                          UNIQUE (hall_id,session_at)
);

CREATE TABLE booking_session_seats (
                                       id BIGSERIAL NOT NULL PRIMARY KEY,
                                       session_id BIGINT NOT NULL,
                                       film_id BIGINT NOT NULL,
                                       hall_id BIGINT NOT NULL,
                                       seat_id BIGINT NOT NULL,
                                       price DECIMAL(10,2),
                                       is_reserved BOOLEAN NOT NULL DEFAULT FALSE,
                                       CONSTRAINT fk_session FOREIGN KEY (session_id) REFERENCES sessions(id),
                                       CONSTRAINT fk_film FOREIGN KEY (film_id) REFERENCES films(id),
                                       CONSTRAINT fk_hall FOREIGN KEY (hall_id) REFERENCES halls(id),
                                       CONSTRAINT fk_seat FOREIGN KEY (seat_id) REFERENCES seats(id),
                                       UNIQUE (session_id, hall_id, seat_id)
);

ALTER TABLE booking_session_seats ADD COLUMN film_id BIGINT NOT NULL DEFAULT 0;

UPDATE booking_session_seats b SET film_id = s.film_id
FROM sessions s
WHERE b.session_id = s.id