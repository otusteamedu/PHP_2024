CREATE TABLE movie (
	id SERIAL NOT NULL,
	name VARCHAR(50) NOT NULL,
	duration INTERVAL MINUTE NOT NULL,
	CONSTRAINT movie_pkey PRIMARY KEY(id)
);

CREATE EXTENSION IF NOT EXISTS btree_gist;

CREATE TABLE session (
	id SERIAL NOT NULL,
	movie_id SERIAL NOT NULL,
	hall_id SERIAL NOT NULL,
	start TIMESTAMPTZ NOT NULL,
    finish TIMESTAMPTZ NOT NULL,
	CONSTRAINT session_pkey PRIMARY KEY(id),
	CONSTRAINT check_time CHECK (start < finish),
    EXCLUDE USING GIST (
        hall_id WITH =,
        tstzrange(start, finish, '[]') WITH &&
    )
);

CREATE TABLE hall (
	id SERIAL NOT NULL,
	name VARCHAR(50) NOT NULL,
	CONSTRAINT hall_pkey PRIMARY KEY(id),
	CONSTRAINT name UNIQUE(name)
);

CREATE TABLE price (
	id SERIAL NOT NULL,
	session_id SERIAL NOT NULL,
	seat_type_id SERIAL NOT NULL,
	value MONEY NOT NULL,
	CONSTRAINT price_pkey PRIMARY KEY(id),
	CONSTRAINT session_seat_unique UNIQUE(session_id, seat_type_id)
);

CREATE TABLE ticket (
	id SERIAL NOT NULL,
	session_id SERIAL NOT NULL,
	seat_id SERIAL NOT NULL,
	price MONEY NOT NULL,
	discount_percent NUMERIC(5,2) DEFAULT 0,
	is_sold BOOLEAN NOT NULL,
	CONSTRAINT ticket_pkey PRIMARY KEY(id),
	CONSTRAINT ticket_unique UNIQUE(session_id, seat_id),
	CHECK (discount_percent >= 0 AND discount_percent <= 100)
);

CREATE TABLE seat_type (
	id SERIAL NOT NULL,
	name VARCHAR(50) NOT NULL,
	CONSTRAINT seat_type_pkey PRIMARY KEY(id)
);

CREATE TABLE seat (
	id SERIAL NOT NULL,
	hall_id SERIAL NOT NULL,
	horizont SMALLINT NOT NULL,
	vertical SMALLINT NOT NULL,
	seat_type_id SERIAL NOT NULL,
	CONSTRAINT seat_pkey PRIMARY KEY(id),
	CONSTRAINT seat_unique UNIQUE (hall_id, horizont, vertical)
);